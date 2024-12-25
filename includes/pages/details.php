<?php
$mysqli = mysqli_connect($host, $user, $pass)
or die('Problème de création de la base :');

if (mysqli_select_db($mysqli, $base) or die("Impossible de sélectionner la base : $base")) {
    if (isset($_GET["id"])) {
        $recipe = $_GET["id"];
        $query = query($mysqli, "SELECT title, proportions, preparation, ingredients FROM `recipe` WHERE id_rec = '$recipe';");
        $result = mysqli_fetch_row($query); ?>
        <a href="./?page=liste#<?php echo $recipe ?>" class="btn btn-success back"> ←</a>
        <div class="listCocktailsDetail">
            <p>
                <strong> <?php echo $result[0] ?> </strong>
            </p>
            <img src="includes/pictures/cocktail.png">
            <p>
                <h5> Proportions : </h5>
                <?php $propList = explode("|", $result[1]); ?>
                <ul> <?php
                    foreach ($propList as $prop) { ?>
                        <li> <?php echo $prop ?> </li>
                    <?php } ?>
                </ul>
            </p>
            <p>
                <h5> Préparation : </h5>
                <?php echo $result[2] ?>
            </p>
            <p>
                <h5> Ingrédients : </h5>
                <?php
                $ingList = explode("|", $result[3]); ?>
            <ul> <?php
                foreach ($ingList as $ing) {
                    $ing2 = mysqli_real_escape_string($mysqli, $ing);
                    $query = query($mysqli, "SELECT DISTINCT i.id_ing FROM `recipe`r, `ingredient`i, `contains`c WHERE i.name = '" . $ing2 . "' AND r.`id_rec` = c.`rec_id` AND c.ing_id = i.id_ing; ");
                    $id = mysqli_fetch_all($query); ?>
                    <li> <a class="listeAliments" href="?page=recettesParAliment&id=<?php echo $id[0][0] ?>"> <?php echo $ing ?> </a> </li>
                    <?php
                } ?>
            </ul>
            </p>


        </div>


        <?php

    }
}

mysqli_close($mysqli);