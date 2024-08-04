    <?php use App\Casino\lib\ConnexionUtilisateur;
    $trouve = ConnexionUtilisateur::estConnecte();
    $admin = ConnexionUtilisateur::estAdmin();
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <meta charset="UTF-8">
        <title><?php
            echo $pagetitle; ?>
        </title>
        <style>
            <?php require __DIR__ . "/../../ressource/style/style.css"; ?>
        </style>
    </head>
    <body>
    <header>
        <nav class="navBar">
            <div class="navGauche">
                <div class="logoNav">
                    <img id="logo" src="../ressource/img/logo.jpg" alt="logo" />
                </div>
                <div class="navSousGauche">
                <!-- Votre menu de navigation ici -->
                    <div class="nav_centre">
                        <a href="ControleurFrontal.php?action=afficherAccueil&controleur=generique">Accueil</a>
                    </div>
                    <div class="nav_centre">
                        <a href="ControleurFrontal.php?action=afficherJeu&controleur=machineasous">Jouer</a>
                    </div>
                    <div class="nav_centre">
                        <a href="ControleurFrontal.php?action=rajouterCredit&controleur=machineasous">Rajouter des credits</a>
                    </div>

                    <div class="nav_centre">
                        <a href="ControleurFrontal.php?action=afficherCgu&controleur=generique">CGU</a>
                    </div>

                    <?php
                    if($trouve) {
                        if($admin) {
                            echo "<div class='nav_centre'><a href='ControleurFrontal.php?action=afficherStat&controleur=admin'>Statistique</a></div>";
                        }
                    }?>
                </div>
            </div>
            <div class="navDroite">
                <?php
                if($trouve) {
                    echo "<div class='connexion'><a href='ControleurFrontal.php?action=deconnexion&controleur=joueur'>Deconnexion</a></div>";
                }
                else{
                    echo "<div class='connexion'><a href='ControleurFrontal.php?action=afficherFormulaireConnexion&controleur=joueur'>Connexion</a></div>";
                    echo "<div class='connexion'><a href='ControleurFrontal.php?action=afficherFormulaire&controleur=joueur'>Inscription</a></div>";
                }
                ?>
            </div>
            <div class="burger">
                <img src="../ressource/img/burger-bar.png" alt="burger">
                <div class="submenu-burger">
                    <div class="nav_centre">
                        <a href="ControleurFrontal.php?action=afficherAccueil&controleur=generique">Accueil</a>
                    </div>
                    <div class="nav_centre">
                        <a href="ControleurFrontal.php?action=afficherJeu&controleur=machineasous">Jouer</a>
                    </div>
                    <div class="nav_centre">
                        <a href="ControleurFrontal.php?action=rajouterCredit&controleur=machineasous">Rajouter des credits</a>
                    </div>

                    <div class="nav_centre">
                        <a href="ControleurFrontal.php?action=afficherCgu&controleur=generique">CGU</a>
                    </div>
                    <?php
                    if($trouve) {
                        if($admin) {
                            echo "<div class='nav_centre'><a href='ControleurFrontal.php?action=afficherStat&controleur=admin'>Statistique</a></div>";
                        }
                    }?>
                    <?php
                    if($trouve) {
                        echo "<div class='connexion'><a href='ControleurFrontal.php?action=deconnexion&controleur=joueur'>Deconnexion</a></div>";
                    }
                    else{
                        echo "<div class='connexion'><a href='ControleurFrontal.php?action=afficherFormulaireConnexion&controleur=joueur'>Connexion</a></div>";
                        echo "<div class='connexion'><a href='ControleurFrontal.php?action=afficherFormulaire&controleur=joueur'>Inscription</a></div>";
                    }
                    ?>
                </div>
            </div>





        </nav>

        <div>
            <?php
            /** @var string[][] $messagesFlash */
            foreach($messagesFlash as $type => $messagesFlashPourUnType) {
                // $type est l'une des valeurs suivantes : "success", "info", "warning", "danger"
                // $messagesFlashPourUnType est la liste des messages flash d'un type
                foreach ($messagesFlashPourUnType as $messageFlash) {
                    echo <<< HTML
            <div class="alert alert-$type">
               $messageFlash
            </div>
            HTML;
                }
            }
            ?>
        </div>
    </header>
    <main>
        <?php
        /** @var string $cheminVueBody */
        require __DIR__ . "/{$cheminVueBody}";
        ?>
    </main>

    </body>
    </html>