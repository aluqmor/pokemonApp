<?php
//compruebo sesión
session_start();
if(!isset($_SESSION['user'])) {
    header('Location:.');
    exit;
}

$name = '';
$weight = '';
$height = '';
$type = '';
$evolution = '';
if(isset($_SESSION['old']['name'])) {
    $name = $_SESSION['old']['name'];
    unset($_SESSION['old']['name']);
}
if(isset($_SESSION['old']['weight'])) {
    $weight = $_SESSION['old']['weight'];
    unset($_SESSION['old']['weight']);
}
if(isset($_SESSION['old']['height'])) {
    $height = $_SESSION['old']['height'];
    unset($_SESSION['old']['height']);
}
if(isset($_SESSION['old']['type'])) {
    $type = $_SESSION['old']['type'];
    unset($_SESSION['old']['type']);
}
if(isset($_SESSION['old']['evolution'])) {
    $evolution = $_SESSION['old']['evolution'];
    unset($_SESSION['old']['evolution']);
}
//establecer conexión bd
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
    //echo 'no connection';
    header('Location: .'); // habría que dar explicaciones
    exit;
}

if(isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $url = '.?op=editproduct&result=noid';
    header('Location: ' . $url);
    exit;
}
// Control
$user = null;
if(isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}


$sql = 'select * from product where id = :id';
$sentence = $connection->prepare($sql);
$parameters = ['id' => $id];
foreach($parameters as $nombreParametro => $valorParametro) {
    $sentence->bindValue($nombreParametro, $valorParametro);
}
if(!$sentence->execute()){
    echo 'no sql';
    exit;
}
if(!$fila = $sentence->fetch()) {
    echo 'no data';
    exit;
}
$id = $fila['id'];
if($name == '') {
    $name = $fila['name'];
}
if($weight == '') {
    $weight = $fila['weight'];
}
if($height == '') {
    $height = $fila['height'];
}
if($type == '') {
    $type = $fila['type'];
}
if($evolution == '') {
    $evolution = $fila['evolution'];
}
$connection = null;
?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Pokemon</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <a class="navbar-brand" href="..">Pokemon</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="..">home</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="./">pokemon</a>
                    </li>
                </ul>
            </div>
        </nav>
        <main role="main">
            <div class="jumbotron">
                <div class="container">
                    <h4 class="display-4">pokemon</h4>
                </div>
            </div>
            <div class="container">
            <?php
                if(isset($_GET['op']) && isset($_GET['result'])) {
                    if($_GET['result'] > 0) {
                        ?>
                        <div class="alert alert-primary" role="alert">
                            result: <?= $_GET['op'] . ' ' . $_GET['result'] ?>
                        </div>
                        <?php 
                    } else {
                        ?>
                        <div class="alert alert-danger" role="alert">
                            result: <?= $_GET['op'] . ' ' . $_GET['result'] ?>
                        </div>
                        <?php
                        }
                }
                ?>
                <div0>
                    <form action="update.php" method="post">
                        <div class="form-group">
                            <label for="name">name</label>
                            <input value="<?= $name ?>" required type="text" class="form-control" id="name" name="name" placeholder="name">
                        </div>
                        <div class="form-group">
                            <label for="weight">weight</label>
                            <input value="<?= $weight ?>" required type="number" step="0.001" class="form-control" id="weight" name="weight" placeholder="weight">
                        </div>
                        <div class="form-group">
                            <label for="height">height</label>
                            <input value="<?= $height ?>" required type="number" step="0.001" class="form-control" id="height" name="height" placeholder="height">
                        </div>
                        <div class="form-group">
                            <label for="type">type</label>
                            <input value="<?= $type ?>" required type="text" class="form-control" id="type" name="type" placeholder="type">
                        </div>
                        <div class="form-group">
                            <label for="evolution">evolution</label>
                            <input value="<?= $evolution ?>" required type="number" step="0.001" class="form-control" id="evolution" name="evolution" placeholder="evolution">
                        </div>
                        <input type="hidden" name="id" value="<?= $id ?>" />
                        <button type="submit" class="btn btn-primary">edit</button>
                    </form>
                </div>
                <hr>
            </div>
        </main>
        <footer class="container">
            <p>&copy; IZV 2024</p>
        </footer>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>