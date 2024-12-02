<?php

// Control de sesión
session_start();
if(!isset($_SESSION['user'])) {
    header('Location:.');
    exit;
}

// Lectura de datos, continuación del hack
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
            <a class="navbar-brand" href="..">PokeDB</a>
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
                <div>
                    <form action="store.php" method="post">
                        <div class="form-group">
                            <label for="name">name</label>
                            <input value="<?= $name ?>" required type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="weight">weight</label>
                            <input value="<?= $weight ?>" required type="number" step="0.001" class="form-control" id="weight" name="weight">
                        </div>
                        <div class="form-group">
                            <label for="height">height</label>
                            <input value="<?= $height ?>" required type="number" step="0.001" class="form-control" id="height" name="height">
                        </div>
                        <div class="form-group">
                            <label for="type">type</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="" disabled <?= empty($type) ? 'selected' : '' ?>></option>
                                <option value="normal" <?= $type == 'normal' ? 'selected' : '' ?>>Normal</option>
                                <option value="fire" <?= $type == 'fire' ? 'selected' : '' ?>>Fire</option>
                                <option value="water" <?= $type == 'water' ? 'selected' : '' ?>>Water</option>
                                <option value="grass" <?= $type == 'grass' ? 'selected' : '' ?>>Grass</option>
                                <option value="electric" <?= $type == 'electric' ? 'selected' : '' ?>>Electric</option>
                                <option value="ice" <?= $type == 'ice' ? 'selected' : '' ?>>Ice</option>
                                <option value="fighting" <?= $type == 'fighting' ? 'selected' : '' ?>>Fighting</option>
                                <option value="poison" <?= $type == 'poison' ? 'selected' : '' ?>>Poison</option>
                                <option value="ground" <?= $type == 'ground' ? 'selected' : '' ?>>Ground</option>
                                <option value="flying" <?= $type == 'flying' ? 'selected' : '' ?>>Flying</option>
                                <option value="psychic" <?= $type == 'psychic' ? 'selected' : '' ?>>Psychic</option>
                                <option value="bug" <?= $type == 'bug' ? 'selected' : '' ?>>Bug</option>
                                <option value="rock" <?= $type == 'rock' ? 'selected' : '' ?>>Rock</option>
                                <option value="ghost" <?= $type == 'ghost' ? 'selected' : '' ?>>Ghost</option>
                                <option value="dragon" <?= $type == 'dragon' ? 'selected' : '' ?>>Dragon</option>
                                <option value="dark" <?= $type == 'dark' ? 'selected' : '' ?>>Dark</option>
                                <option value="steel" <?= $type == 'steel' ? 'selected' : '' ?>>Steel</option>
                                <option value="fairy" <?= $type == 'fairy' ? 'selected' : '' ?>>Fairy</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="evolution">evolution</label>
                            <input value="<?= $evolution ?>" required type="number" step="0.001" class="form-control" id="evolution" name="evolution">
                        </div>
                        <button type="submit" class="btn btn-primary">add</button>
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