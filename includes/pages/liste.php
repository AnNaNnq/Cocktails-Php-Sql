<?php
$mysqli = mysqli_connect($host, $user, $pass)
or die('Problème de création de la base :');

if (mysqli_select_db($mysqli, $base) or die("Impossible de sélectionner la base : $base")) {
    $query = query($mysqli, "SELECT title, ingredients, id_rec FROM `recipe`;");
    $result = mysqli_fetch_all($query);
    foreach ($result as $recipe) { ?>
        <div class="listCocktails">
            <p> <a id="<?php echo $recipe[2] ?>" href="?page=details&id=<?php echo $recipe[2] ?>"><strong> <?php echo $recipe[0] ?> </strong> </a></p>
            <p>
                <?php
                $ingList = explode("|", $recipe[1]); ?>
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
