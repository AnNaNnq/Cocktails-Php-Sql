<?php
// Connexion to the database :
$mysqli = mysqli_connect($host, $user, $pass)
or die('Problème de création de la base :');

if (mysqli_select_db($mysqli, $base) or die("Impossible de sélectionner la base : $base")) {
    if (isset($_GET["id"])) {
        $aliment = $_GET["id"];
        ?>
        <br> <h2> Voici les recettes qui contiennent cet aliment : </h2> <br>
        <?php
        $aliment = mysqli_real_escape_string($mysqli, $aliment);
        $query = query($mysqli, "SELECT r.`title`, r.`id_rec` FROM `recipe`r, `ingredient`i, `contains`c WHERE i.id_ing = '" . $aliment . "' AND r.`id_rec` = c.`rec_id` AND c.ing_id = i.id_ing;");
        $result = mysqli_fetch_all($query);
        foreach ($result as $recipe) {
            ?>
            <div class="listCocktails">
                <p><a href="?page=details&id=<?php echo $recipe[1] ?>"><strong> <?php echo $recipe[0] ?> </strong> </a> </p>
            </div>
        <?php }
    } else {
        echo "error 404";
    }
}
mysqli_close($mysqli);

?>