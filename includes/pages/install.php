<?php
include("Donnees.inc.php");

$mysqli = mysqli_connect($host, $user, $pass)
or die('Problème de création de la base :');

// We check if the database already exists. If this is the case, we delete it and recreate it :
query($mysqli, 'DROP DATABASE IF EXISTS ' . $base);
query($mysqli, 'CREATE DATABASE ' . $base);

if (mysqli_select_db($mysqli, $base) or die("Impossible de sélectionner la base : $base")) {
    // We start by creating the table of users :
    query($mysqli, "CREATE TABLE `" . $base . "`.`user` (`id_user` INT(10) NOT NULL AUTO_INCREMENT, `login` VARCHAR(100) NOT NULL, `password` VARCHAR(100) NOT NULL, `name` VARCHAR(100) NOT NULL, `age` INT(3) NOT NULL, PRIMARY KEY (`id_user`)) ENGINE = InnoDB;");
    // Then we create the table of ingredients :
    query($mysqli, "CREATE TABLE `" . $base . "`.`ingredient` (`id_ing` INT(10) NOT NULL AUTO_INCREMENT, `name` VARCHAR(100) NOT NULL, PRIMARY KEY (`id_ing`)) ENGINE = InnoDB;");
    // Then we create the table of recipes :
    query($mysqli, "CREATE TABLE `" . $base . "`.`recipe` (`id_rec` INT(10) NOT NULL AUTO_INCREMENT, `title` TEXT NOT NULL, `proportions` TEXT NOT NULL, `preparation` TEXT NOT NULL, `ingredients` TEXT NOT NULL, PRIMARY KEY (`id_rec`));");
    // Then we create the table contains :
    query($mysqli, "CREATE TABLE `" . $base . "`.`contains` (`ing_id` INT(10) NOT NULL , `rec_id` INT(10) NOT NULL , PRIMARY KEY (`ing_id`, `rec_id`)) ENGINE = InnoDB; ");

    // After creating all the tables, we need to add all the data from "Donnees.inc.php" in our database, starting with adding the recipes :
    $cocktail = "";
    foreach ($Recettes as $recipe => $value) {
        $title = mysqli_real_escape_string($mysqli, $value["titre"]);
        $preparation = mysqli_real_escape_string($mysqli, $value["preparation"]);
        $proportions = mysqli_real_escape_string($mysqli, $value["ingredients"]);
        $ingredients = "";
        foreach ($value["index"] as $ingredient) {
            $ingredients = $ingredients . mysqli_real_escape_string($mysqli, $ingredient) . "|";
        }
        $ingredients = substr($ingredients, 0, -1);
        $cocktail = $cocktail . '(\'' . $title . '\',\'' . $proportions . '\',\'' . $preparation . '\',\'' . $ingredients . '\'),';
    }

    $cocktail = substr($cocktail, 0, -1);
    query($mysqli, "INSERT INTO `" . $base . "`.`recipe` (`title`, `proportions`, `preparation`, `ingredients`) VALUES " . $cocktail);

    // Adding the ingredients :
    $ingredientsToAdd = "";
    foreach ($Recettes as $recipe => $value) {
        foreach ($value["index"] as $ing) {
            $ingredient = mysqli_real_escape_string($mysqli, $ing);
            if (strpos($ingredientsToAdd, '(\'' . $ingredient . '\'),') === false) {
                $ingredientsToAdd = $ingredientsToAdd . '(\'' . $ingredient . '\'),';
            }
        }
    }
    $ingredientsToAdd = substr($ingredientsToAdd, 0, -1);
    query($mysqli, "INSERT INTO `" . $base . "`.`ingredient` (`name`) VALUES " . $ingredientsToAdd);

    // Link the table recipe and the table ingredient :
    foreach ($Recettes as $recipe => $value) {
        $title = $value["titre"];
        $title = mysqli_real_escape_string($mysqli, $title);
        $getIdRecipe = query($mysqli, "SELECT `id_rec` FROM `recipe` WHERE `title` = '$title'");
        $idRecipe = mysqli_fetch_row($getIdRecipe);

        foreach ($value["index"] as $ingredient) {
            $ing = mysqli_real_escape_string($mysqli, $ingredient);
            $getIdIngredient = query($mysqli, "SELECT `id_ing` FROM `ingredient` WHERE `name` = '$ing'");
            $idIngredient = mysqli_fetch_row($getIdIngredient);
            if (isset($idRecipe[0]) && isset($idIngredient[0])) {
                query($mysqli, "SELECT * FROM `contains` WHERE `rec_id` = '" . $idRecipe[0] . "' AND `ing_id` = '" . $idIngredient[0] . "'");
                $alreadyThere = mysqli_affected_rows($mysqli);
                if ($alreadyThere != 1) {
                    query($mysqli, "INSERT INTO `" . $base . "`.`contains` (`rec_id`,`ing_id`) VALUES ('" . $idRecipe[0] . "','" . $idIngredient[0] . "')");
                }
            }
        }
    }
    ?>
    <div class="alert alert-success" role="alert">
        La base de donnée a été initialisée avec succès !
    </div>
    <br> <br> <br>
    <?php
    $_SESSION["isInstalled"] = true;
    mysqli_close($mysqli);
    header("Location: ./");

} ?>