<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
if(!isset($_SESSION['user'])) {
    header('Location:.');
    exit;
}
try {
    $connection = new \PDO(
      'mysql:host=localhost;dbname=pokemondb3',
      'pokemonuser3',
      'pokemonpassword',
      array(
        PDO::ATTR_PERSISTENT => true,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'set names utf8')
    );
} catch(PDOException $e) {
    header('Location: ..?op=editpokemon&result=0&message=' . urlencode($e->getMessage()));
    exit;
}
if(isset($_POST['id'])) {
    $id = $_POST['id'];
} else {
    header('Location: ..?op=editpokemon&result=0&message=' . urlencode('No se proporcionó ID'));
    exit;
}

$user = null;
if(isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}

if(isset($_POST['name'])) {
    $name = trim($_POST['name']);
} else {
    header('Location: .?op=editpokemon&result=0&message=' . urlencode('No se proporcionó nombre'));
    exit;
}
if(isset($_POST['weight'])) {
    $weight = $_POST['weight'];
} else {
    header('Location: .?op=editpokemon&result=0&message=' . urlencode('No se proporcionó peso'));
    exit;
}
if(isset($_POST['height'])) {
    $height = $_POST['height'];
} else {
    header('Location: .?op=editpokemon&result=0&message=' . urlencode('No se proporcionó altura'));
    exit;
}
if(isset($_POST['type'])) {
    $type = $_POST['type'];
} else {
    header('Location: .?op=editpokemon&result=0&message=' . urlencode('No se proporcionó tipo'));
    exit;
}
if(isset($_POST['evolution'])) {
    $evolution = $_POST['evolution'];
} else {
    header('Location: .?op=editpokemon&result=0&message=' . urlencode('No se proporcionó evolución'));
    exit;
}
//debería meter la misma validación que antes en store.php
$sql = 'update pokemon set name = :name, weight = :weight, height = :height, type = :type, evolution= :evolution where id = :id';
$sentence = $connection->prepare($sql);
$parameters = ['name' => $name, 'weight' => $weight, 'height' => $height, 'type' => $type, 'evolution' => $evolution,'id' => $id];
foreach($parameters as $nombreParametro => $valorParametro) {
    $sentence->bindValue($nombreParametro, $valorParametro);
}
try {
    $sentence->execute();
    $resultado = $sentence->rowCount();
    $url = '.?op=editpokemon&result=' . $resultado . '&message=' . urlencode('Pokemon actualizado correctamente');
} catch(PDOException $e) {
    $resultado = 0;
    $_SESSION['old']['name'] = $name;
    $_SESSION['old']['weight'] = $weight;
    $_SESSION['old']['height'] = $height;
    $_SESSION['old']['type'] = $type;
    $_SESSION['old']['evolution'] = $evolution;
    $url = 'edit.php?id=' . $id . '&op=editpokemon&result=0&message=' . urlencode($e->getMessage());
}
header('Location: ' . $url);