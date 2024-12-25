<?php
if (isset($_POST['name']) && isset($_POST['password']) && isset($_POST['username']) && isset($_POST['age'])) {
    // Connexion to the database :
    $mysqli = mysqli_connect($host, $user, $pass)
    or die('Problème de création de la base :');

    // We want to prevent the SQL injections :
    $name = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['name']));
    $age = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['age']));
    $username = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['username']));
    $password = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['password']));

    // We test all the data to verify if it respects the rules :
    if (preg_match("#^[a-zA-ZàâèéêîïùÀÂÈÉÊÎÏÛ -]+$#", $name)) {
        if (preg_match("#^[1-9]{1}[0-9]{0,2}$#", $age)) {
            $error = "";
        } else {
            $error = "Le nouvel age donné est incorrect, s'il vous plaît veuillez respecter le format.";
        }
    } else {
        $error = "Le nouveau nom donné est incorrect, s'il vous plaît veuillez respecter le format : minuscules, majuscules, << - >> et/ou << >> (espace).";
    }

    if ($username !== "" && $error == "") {
        $query = query($mysqli, "SELECT count(*) FROM `" . $base . "`.`user` WHERE login = '" . $username . "'");
        $answer = mysqli_fetch_array($query);
        $count = $answer['count(*)'];
        if ($count == 1) {
            query($mysqli, "UPDATE `" . $base . "`.`user` SET `password` = '" . $password . "', `name` = '" . $name . "', `age` = '" . $age . "' WHERE login = '" . $username . "'");
            ?>
            <div class="alert alert-success" role="alert">
                Vos modifications ont été enregistré avec succès.
            </div>
            <a href="./" class="button"> Retourner à l'accueil </a>
            <?php
        } else { ?>
            <div class="alert alert-danger" role="alert">
                L'utilisateur n'existe pas.
            </div>
            <?php
        }
    } else {?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error;?>
        </div>
        <?php
    }
    mysqli_close($mysqli);
}
?>

<div id="container">
    <form action="#" method="POST">
        <h1> Modifier </h1>

        <p class="titreModif"> Vos informations </p>

        <label><b>Votre nom d'utilisateur</b></label>
        <input type="text" placeholder="Entrez le login" name="username" required>

        <br> <br> <p class="titreModif"> Nouvelles informations </p>

        <label><b>Nouveau nom</b></label>
        <input type="text" placeholder="Entrez le nom" name="name" required>

        <label><b>Nouvel age</b></label>
        <input type="number" placeholder="Entrez l'age" name="age" min="1" required>

        <label><b>Nouveau mot de passe</b></label>
        <input type="password" placeholder="Entrez le mot de passe" name="password" required>

        <input type="submit" id='submit' value="Modifier">
    </form>
</div>
