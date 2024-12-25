<?php
// Connexion to the database :
$mysqli = mysqli_connect($host, $user, $pass)
or die('Problème de création de la base :');
$sqlRequete = "SELECT i.`name`, COUNT(*), i.id_ing FROM recipe AS r INNER JOIN `contains` AS c ON r.`id_rec` = c.`rec_id` INNER JOIN ingredient AS i ON c.ing_id = i.id_ing GROUP BY i.name;";


if (mysqli_select_db($mysqli, $base) or die("Impossible de sélectionner la base : $base")) {
    ?>
    <br> <h2> Liste des aliments : </h2> <br>
    <table class="tableauAliments">
        <tr>
            <th>
                Nombre de recettes
                <?php if (!isset($_GET["tri"]) || $_GET["tri"] == "ald" || $_GET["tri"] == "alc") { ?>
                    <a href="./?page=aliments&tri=nbd"> <img src="includes/pictures/nonTri.png" alt="tri" height="15px" width="15px"> </a>
                    <?php
                } else if ($_GET["tri"] == "nbd") { ?>
                    <a href="./?page=aliments&tri=nbc"> <img src="includes/pictures/triD.png" alt="tri" height="15px" width="15px"> </a>
                    <?php
                    $sqlRequete = "SELECT i.`name`, COUNT(*), i.id_ing FROM recipe AS r INNER JOIN `contains` AS c ON r.`id_rec` = c.`rec_id` INNER JOIN ingredient AS i ON c.ing_id = i.id_ing GROUP BY i.name ORDER BY COUNT(*) DESC, i.name;";
                } else { ?>
                    <a href="./?page=aliments&tri=nbd"> <img src="includes/pictures/triC.png" alt="tri" height="15px" width="15px"> </a>
                    <?php
                    $sqlRequete = "SELECT i.`name`, COUNT(*), i.id_ing FROM recipe AS r INNER JOIN `contains` AS c ON r.`id_rec` = c.`rec_id` INNER JOIN ingredient AS i ON c.ing_id = i.id_ing GROUP BY i.name ORDER BY COUNT(*), i.name;";
                } ?>
            </th>
            <th>
                Aliment
                <?php if (!isset($_GET["tri"]) || $_GET["tri"] == "alc") { ?>
                    <a href="./?page=aliments&tri=ald"> <img src="includes/pictures/triC.png" alt="tri" height="15px" width="15px"> </a>
                    <?php
                    $sqlRequete = "SELECT i.`name`, COUNT(*), i.id_ing FROM recipe AS r INNER JOIN `contains` AS c ON r.`id_rec` = c.`rec_id` INNER JOIN ingredient AS i ON c.ing_id = i.id_ing GROUP BY i.name;";
                } else if ($_GET["tri"] == "ald") { ?>
                    <a href="./?page=aliments&tri=alc"> <img src="includes/pictures/triD.png" alt="tri" height="15px" width="15px"> </a>
                    <?php
                    $sqlRequete = "SELECT i.`name`, COUNT(*), i.id_ing FROM recipe AS r INNER JOIN `contains` AS c ON r.`id_rec` = c.`rec_id` INNER JOIN ingredient AS i ON c.ing_id = i.id_ing GROUP BY i.name DESC;";
                } else { ?>
                    <a href="./?page=aliments&tri=alc"> <img src="includes/pictures/nonTri.png" alt="tri" height="15px" width="15px"> </a>
                    <?php
                } ?>
            </th>
        </tr>
        <?php
        $query = query($mysqli, $sqlRequete);
        $result = mysqli_fetch_all($query);
        foreach ($result as $recipe) { ?>
            <tr>
                <td> <?php echo $recipe[1]; ?> </td>
                <td><a class="listeAliments"
                       href="?page=recettesParAliment&id=<?php echo $recipe[2] ?>"> <?php echo $recipe[0] ?> </a></td>
            </tr>
            <?php
        } ?>
    </table>
    <br>
    <?php
}
mysqli_close($mysqli);

?>
