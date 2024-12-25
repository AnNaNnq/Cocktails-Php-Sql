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
            if (preg_match("#^[a-zA-Z0-9]+$#", $username)) {
                $error = "";
            } else {
                $error = "Le login donné est incorrect, s'il vous plaît veuillez respecter le format : minuscules, majuscules (sans accent) et/ou chiffres";
            }
        } else {
            $error = "L'age donné est incorrect, s'il vous plaît veuillez respecter le format.";
        }
    } else {
        $error = "Le nom donné est incorrect, s'il vous plaît veuillez respecter le format : minuscules, majuscules, << - >> et/ou << >> (espace).";
    }

    if ($name !== "" && $age !== "" && $username !== "" && $password !== "" && $error == "") {
        $query = query($mysqli, "SELECT count(*) FROM `" . $base . "`.`user` WHERE login = '" . $username . "'");
        $answer = mysqli_fetch_array($query);
        $count = $answer['count(*)'];
        if ($count == 0) { ?>
            <div class="alert alert-success" role="alert">
                Votre compte à bien été créé.
            </div>
            <a href="./" class="button"> Retourner à l'accueil </a>
            <?php
            query($mysqli, "INSERT INTO `" . $base . "`.`user` (`login`,`password`,`name`,`age`) VALUES ('" . $username . "','" . $password . "','" . $name . "','" . $age . "')");
        } else { ?>
            <div class="alert alert-danger" role="alert">
                L'utilisateur existe déjà.
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
        <h1> S'enregistrer </h1>

        <label><b>Nom</b></label>
        <input type="text" placeholder="Entrez le nom" name="name" required>

        <label><b>Age</b></label>
        <input type="number" placeholder="Entrez l'age" name="age" min="1" required>

        <label><b>Nom d'utilisateur</b></label>
        <input type="text" placeholder="Entrez le login" name="username" required>

        <label><b>Mot de passe</b></label>
        <input type="password" placeholder="Entrez le mot de passe" name="password" required>

        <input type="submit" id='submit' value="S'enregistrer">
    </form>
</div>

