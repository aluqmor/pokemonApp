<?php

// 1º Habilito la visualización de errores (solo en desarrollo)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Compruebo si el usuario está logueado
session_start();
if(!isset($_SESSION['user'])) {
    header('Location:.'); // redireccion
    exit; //detengo la ejecución
}

// Conexión a la base de datos
try {
    $connection = new \PDO(
      'mysql:host=localhost;dbname=pokemondb',
      'pokeuser',
      'pokemonpassword',
      array(
        PDO::ATTR_PERSISTENT => true,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'set names utf8')
    );
} catch(PDOException $e) {
    header('Location: create.php?op=errorconnection&result=0');
    exit;
}

$resultado = 0;
$url = 'create.php?op=insertproduct&result=' . $resultado;

// Compruebo que los datos obligatorios: 
if(isset($_POST['name']) && isset($_POST['weight']) && isset($_POST['height']) && isset($_POST['type']) && isset($_POST['evolution'])) {
    $name = $_POST['name'];
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $type = $_POST['type'];
    $evolution = $_POST['evolution'];
    $ok = true;
    $name = trim($name);

    // Verifica que el nombre tenga entre 2 y 100 caracteres
    if(strlen($name) < 2 || strlen($name) > 100) { 
        $ok = false;
    }
    // Verifica que el peso sea un número entre 0 y 1,000,000
    if(!(is_numeric($weight) && $weight >= 0 && $weight <= 1000000)) { 
        $ok = false;
    }
    if(!(is_numeric($height) && $height >= 0 && $height <= 1000000)) { 
        $ok = false;
    }
    if(strlen($type) < 2 || strlen($type) > 100) { 
        $ok = false;
    }
    if(!(is_numeric($evolution) && $evolution >= 0 && $evolution <= 1000000)) { 
        $ok = false;
    }

    if($ok) {
        // Prepara la consulta SQL para insertar un producto
        $sql = 'insert into product (name, weight, height, type, evolution) values (:name, :weight, :height, :type, :evolution)'; 
        $sentence = $connection->prepare($sql); 
        // Define los parámetros para la consulta
        $parameters = ['name' => $name, 'weight' => $weight, 'height' => $height, 'type' => $type, 'evolution' => $evolution]; 
        foreach($parameters as $nombreParametro => $valorParametro) { 
            $sentence->bindValue($nombreParametro, $valorParametro); 
        }

        try {
            $sentence->execute(); 
            $resultado = $connection->lastInsertId(); 
            $url = 'index.php?op=insertproduct&result=' . $resultado; 
        } catch(PDOException $e) {
            $_SESSION['old']['name'] = $name;
            $_SESSION['old']['weight'] = $weight;
            $_SESSION['old']['height'] = $height;
            $_SESSION['old']['type'] = $type;
            $_SESSION['old']['evolution'] = $evolution;
        } 
    }
}
if($resultado == 0) {
    $_SESSION['old']['name'] = $name; // Guarda el nombre en la sesión en caso de error
    $_SESSION['old']['weight'] = $weight; // Guarda el peso en la sesión en caso de error
    $_SESSION['old']['height'] = $height; // Guarda la altura en la sesión en caso de error
    $_SESSION['old']['type'] = $type; // Guarda el tipo en la sesión en caso de error
    $_SESSION['old']['evolution'] = $evolution; // Guarda la evolución en la sesión en caso de error
}

// El método header() redirecciona a la URL indicada
header('Location: ' . $url);