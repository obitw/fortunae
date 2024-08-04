<?php
namespace App\Casino\Controleur;
use App\Casino\lib\MessageFlash;
use App\Casino\lib\MotDePasse;
use App\Casino\modele\dataObject\Joueur;
use App\Casino\modele\HTTP\Session;
use App\Casino\modele\repository\JoueurRepository;
use JetBrains\PhpStorm\NoReturn;

class ControleurJoueur extends ControleurGenerique{
    public static function afficherFormulaire(){
        ControleurJoueur::afficherVue("vueGenerale.php", ["pagetitle" => "Formulaire de création", "cheminVueBody" => "joueur/formulaireCreation.php"]);
    }

    public static function creerDepuisFormulaire() : void {
        //je verifie que mdp et mdp2 sont identiques
        if ($_POST['mdp'] != $_POST['mdp2']){
            ControleurJoueur::afficherMessageFlash("danger", "Les mots de passe ne sont pas identiques", "?action=afficherFormulaire&controleur=joueur");
        }

        $tabFormulaire = [
            "login" => $_POST['login'],
            "nomUtilisateurCasino" => $_POST['nom'],
            "prenomUtilisateurCasino" => $_POST['prenom'],
            "email" => $_POST['email'],
            "dateDeNaissance" => $_POST['dateNaissance'],
            "credit" => 0,
            "motDePasse" => $_POST['mdp'],
            "estAdmin" => 0,
            "token" => '', 
            "emailAValider" => '',
            "nonce" => '',
        ];

        $joueurRepo = new JoueurRepository();
        //si le login ou le mail existe deja
        if ($joueurRepo->recupererParClePrimaire($tabFormulaire['login']) != null || $joueurRepo->recupererParClePrimaire($tabFormulaire['email']) != null){
            ControleurJoueur::afficherMessageFlash("danger", "Ce login ou cet email existe déjà", "?action=afficherFormulaire&controleur=joueur");
        }

        $joueur = Joueur::construireDepuisFormulaire($tabFormulaire);
        (new JoueurRepository())->sauvegarder($joueur);
        ControleurJoueur::redirectionVersURL("ControleurFrontal.php?action=afficherFormulaireConnexion&controleur=joueur");
    }

    public static function afficherFormulaireConnexion(){
        ControleurJoueur::afficherVue("vueGenerale.php", ["pagetitle" => "Formulaire de connexion", "cheminVueBody" => "joueur/formulaireConnexion.php"]);
    }

    public static function seConnecter()
    {
        $joueur = (new JoueurRepository())->recupererParClePrimaire($_POST['login']);
        if ($joueur == null) {
            ControleurJoueur::afficherMessageFlash("danger", "Ce joueur n'existe pas", "?action=afficherFormulaireConnexion&controleur=joueur");
        }
        else{
            $mdpHache = $joueur->getMotDePasse();
            if (MotDePasse::verifier($_POST['mdp'], $mdpHache)){
                Session::getInstance()->enregistrer("joueurConnecte", $joueur);
                MessageFlash::ajouter("success", "Vous etes connecte");
                ControleurJoueur::redirectionVersURL("ControleurFrontal.php?action=afficherAccueil&controleur=joueur");
            }
            else{
                ControleurJoueur::afficherMessageFlash("danger", "Connexion impossible", "?action=afficherFormulaireConnexion&controleur=joueur");
            }
        }
    }

    public static function deconnexion()
    {
        Session::getInstance()->supprimer("joueurConnecte");
        Session::getInstance()->supprimer("credit");
        Session::getInstance()->supprimer("mise");
        Session::getInstance()->supprimer("gain");
        MessageFlash::ajouter("success", "Vous etes deconnecte");
        ControleurJoueur::redirectionVersURL("ControleurFrontal.php?action=afficherAccueil&controleur=joueur");
    }
    #[NoReturn] private static function afficherMessageFlash(string $type, string $message, string $redirection): void
    {
        MessageFlash::ajouter($type, $message);
        self::redirectionVersURL($redirection);
    }


}