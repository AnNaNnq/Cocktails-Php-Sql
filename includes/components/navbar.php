<nav class="navbar navbar-expand-lg navbar-light bg-light">

    <img src="includes/pictures/logo.png" alt="logo" height="75px" width="75px">
    <a href="./" class="title"> <h4> Cocktails </h4> </a>

    <div class="collapse navbar-collapse links" id="navbarSupportedContent">
        <?php if (isset($_SESSION["isInstalled"]) && $_SESSION["isInstalled"] == true) {?>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="./?page=liste"> Liste des cocktails </a>
                </li>
                <?php if (isset($_SESSION["isConnected"]) && $_SESSION["isConnected"] == true) {?>
                    <li class="nav-item">
                        <a class="nav-link" href="./?page=aliments"> Liste des aliments </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./?page=modifier"> Modifier son compte </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./?page=deconnexion"> Se déconnecter </a>
                    </li>
                    <?php
                } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./?page=connecter"> Se connecter </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./?page=enregistrer"> S'enregistrer </a>
                    </li>
                <?php
                } ?>
            </ul>
            <?php
        } ?>
    </div>

</nav>