<?php
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
    header('Location: .?op=deletepokemon&result=0&message=' . urlencode($e->getMessage()));
    exit;
}
if(isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header('Location: .?op=deletepokemon&result=0&message=' . urlencode('No se proporcionó ID'));
    exit;
}
$sql = 'delete from pokemon where id = :id';
$sentence = $connection->prepare($sql);
$parameters = ['id' => $id];
foreach($parameters as $nombreParametro => $valorParametro) {
    $sentence->bindValue($nombreParametro, $valorParametro);
}
if(!$sentence->execute()){
    header('Location: .?op=deletepokemon&result=0&message=' . urlencode('Error al ejecutar la consulta SQL'));
    exit;
}
$resultado = $sentence->rowCount();
$connection = null;
$url = '.?op=deletepokemon&result=' . $resultado . '&message=' . urlencode('Pokemon eliminado correctamente');
header('Location: ' . $url);