<?php
if (isset($_POST['password']) && isset($_POST['username'])) {
    // Connexion to the database :
    $mysqli = mysqli_connect($host, $user, $pass)
    or die('Problème de création de la base :');

    // We want to prevent the SQL injections :
    $username = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['username']));
    $password = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['password']));

    if ($username !== "" && $password !== "") {
        $query = query($mysqli, "SELECT count(*) FROM `" . $base . "`.`user` WHERE login = '" . $username . "' AND password = '" . $password . "'");
        $answer = mysqli_fetch_array($query);
        $count = $answer['count(*)'];
        if ($count == 1) {
            $_SESSION["isConnected"] = true; ?>
            <div class="alert alert-success" role="alert">
                Vous vous êtes connecté avec succès.
            </div>
            <a href="./" class="button"> Retourner à l'accueil </a>
            <?php
        } else { ?>
            <div class="alert alert-danger" role="alert">
                Il y a une erreur avec le mot de passe ou l'utilisateur.
            </div>
            <?php
        }
    } else { ?>
        <div class="alert alert-danger" role="alert">
            Les informations données ne sont pas correctes.
        </div>
        <?php
    }
    mysqli_close($mysqli);
}
?>
<div id="container">
    <form action="#" method="POST">
        <h1>Connexion</h1>

        <label><b>Nom d'utilisateur</b></label>
        <input type="text" placeholder="Entrez le nom d'utilisateur" name="username" required>

        <label><b>Mot de passe</b></label>
        <input type="password" placeholder="Entrez le mot de passe" name="password" required>

        <input type="submit" id='submit' value='Se connecter'>
    </form>
</div>
