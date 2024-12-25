<?php
session_start();
include("config.inc.php");
include("functions.inc.php");

?>

<!DOCTYPE>
<html>

<head>
    <title>Cocktails</title>
    <meta charset="utf-8"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
    <link href="structure.css" type="text/css" rel="stylesheet"/>
</head>

<body>
<header>
    <?php
    include("./includes/components/navbar.php");
    ?>
</header>

<main>

    <?php
    if (isset($_GET["page"])) {
        if ($_GET["page"] == "install") {
            include("./includes/pages/home.php");
            include("./includes/pages/install.php");
        } else if ($_GET["page"] == "enregistrer") {
            include("./includes/pages/enregistrer.php");
        } else if ($_GET["page"] == "connecter") {
            include("./includes/pages/connecter.php");
        } else if ($_GET["page"] == "liste") {
            include("./includes/pages/liste.php");
        } else if ($_GET["page"] == "details") {
            include("./includes/pages/details.php");
        } else if ($_GET["page"] == "modifier") {
            include("./includes/pages/modifier.php");
        } else if ($_GET["page"] == "deconnexion") {
            include("./includes/pages/deconnexion.php");
        } else if ($_GET["page"] == "recettesParAliment") {
            include("./includes/pages/recettesParAliment.php");
        } else if ($_GET["page"] == "aliments") {
            include("./includes/pages/listeDesAliments.php");
        }
    } else {
        include("./includes/pages/home.php");
    }
    ?>
</main>

</body>
</html>