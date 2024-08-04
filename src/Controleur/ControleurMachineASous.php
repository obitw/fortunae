<?php

namespace App\Casino\Controleur;

use App\Casino\lib\ConnexionUtilisateur;
use App\Casino\modele\dataObject\MachineASous;
use App\Casino\modele\HTTP\Session;
use App\Casino\modele\repository\JoueurRepository;
use App\Casino\modele\repository\MachineASousRepository;
use App\Casino\Util\TestAlea;

class ControleurMachineASous extends ControleurGenerique{

    public static function jouer() : void {
        $machineASous = (new MachineASousRepository)->recupererParClePrimaire($_GET['id']);
        if ($machineASous == null) {
            ControleurMachineASous::afficherVue("vueGenerale.php", ["pagetitle" => "Erreur", "cheminVueBody" => "erreurMachineASous.php"]);
        } else {
            ControleurMachineASous::afficherVue("vueGenerale.php", ["pagetitle" => "Jouer à la machine à sous", "cheminVueBody" => "machineASous/jouer.php", "machineASous" => $machineASous]);
        }
    }

    public static function lancer() : void
    {
        $mas = new MachineASous(1, "Machine à sous");
        $mas->setMise(Session::getInstance()->lire("mise"));
        if (Session::getInstance()->lire("mise") == 0) {
            $donnees["erreur"] = 2;
            echo json_encode($donnees);
        }
        else if (Session::getInstance()->lire("credit") < $mas->getMise()) {
            $donnees["erreur"] = 1;
            echo json_encode($donnees);
        } else {
            $resultat = $mas->jouer();
            $gain = $mas->calculerGain($resultat);
            $creditNouveau = Session::getInstance()->lire("credit") + $gain - $mas->getMise();
            $donnees["resultat"] = $resultat;
            $donnees["gain"] = $gain;
            $donnees["credit"] = $creditNouveau;
            $donnees["erreur"] = 0;
            if(ConnexionUtilisateur::estConnecte()){
                $login = ConnexionUtilisateur::getLoginUtilisateurConnecte();
                $joueur = (new JoueurRepository())->recupererParClePrimaire($login);
                (new MachineASousRepository())->sauvegarderPartie($mas->getIdJeu(),
                    $gain,
                    $mas->getMise(),
                    Session::getInstance()->lire("credit"),
                    $joueur->getPseudoUtilisateurCasino(),
                    date("Y-m-d H:i:s"));
            }
            echo json_encode($donnees);
            Session::getInstance()->enregistrer("credit", $creditNouveau);
        }
    }

    public static function afficherJeu() : void
    {
        if (!ConnexionUtilisateur::estConnecte()) {
            $session = Session::getInstance();
            if (!$session->contient("credit")) {
                $credit = 10000; //Donne des crédits pour tester
                $session->enregistrer("credit", $credit);
            }

            if (!$session->contient("mise")) {
                $session->enregistrer("mise", 0);
            }

            if (!$session->contient("gain")) {
                $session->enregistrer("gain", 0);
            }

        } else {
            $login = ConnexionUtilisateur::getLoginUtilisateurConnecte();
            $joueur = (new JoueurRepository())->recupererParClePrimaire($login);
            $session = Session::getInstance();
            $session->enregistrer("credit", $joueur->getCredit());
            if ($session->contient("mise")) {
                $mise = $session->lire("mise");
            } else {
                $session->enregistrer("mise", 0);
            }
            if ($session->contient("gain")) {
                $gain = $session->lire("gain");
            } else {
                $session->enregistrer("gain", 0);
            }
        }
        ControleurMachineASous::afficherVue(
            "vueGenerale.php",
            [
                "pagetitle" => "Machine à sous",
                "cheminVueBody" => "/machineasous/vueMachineASous.php"
            ]);
    }





    public static function sendData(){
        if(ConnexionUtilisateur::estConnecte()){

        }
        $session = Session::getInstance();
        $donnees["mise"] = $session->lire("mise");
        $donnees["gain"] = $session->lire("gain");
        $donnees["credit"] = $session->lire("credit");

        echo json_encode($donnees);
    }

    public static function miserPlus(){
        self::miser(true);
    }

    public static function miserMoins(){
        self::miser(false);
    }

    public static function miser($plus) : void{
        $session = Session::getInstance();
        $credit = $session->lire("credit");
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, true);
        $mise = $input["mise"];
        $valeur = $input["valeur"];

        if ($plus) {
            if($valeur != 2 &&  $valeur != 10 && $valeur != 0 ){
                if ($credit >= $mise+$valeur) {
                    $mise += $valeur;
                }
            }
            else if ($valeur == 2 ){
                if ($credit >= $mise*2) {
                    $mise *= 2;
                }
            }
            else if ($valeur == 10 ){
                if ($credit >= $mise*10) {
                    $mise *= 10;
                }
            }
            else if ($valeur == 0 ){
                $mise =  $credit;
            }
            else{
                $mise = 0;
            }
        }else{
            if($valeur != 2 &&  $valeur != 10 && $valeur != 0 ){
                if ($mise-$valeur >= 0) {
                    $mise -= $valeur;
                }
            }
            else if ($valeur == 2 ){
                if ($mise/2 >= 0) {
                    $mise /= 2;
                }
            }
            else if ($valeur == 10 ){
                if ($mise/10 >= 0) {
                    $mise /= 10;
                }
            }
            else if ($valeur == 0 ){
                $mise =  0;
            }
            else{
                $mise = 0;
            }
        }
        $session->enregistrer("mise", $mise);
        echo json_encode(["mise" => $mise]);
    }
    public static function afficherRegles(): void
    {
        ControleurMachineASous::afficherVue("machineasous/reglesMachineASous.php", ["pagetitle" => "Règles de la Machine à Sous"]);
    }

    public static function statistique():void{
        $nbTirage = 10000;
        if (isset($_GET["nbTirage"])){
            $nbTirage = $_GET["nbTirage"];
        }
        echo "Nombre de tirage : " . $nbTirage. "<br>";
        TestAlea::calculProba(TestAlea::genererXtirages($nbTirage), $nbTirage);
    }

    public static function rajouterCredit(): void{
        if(!ConnexionUtilisateur::estConnecte()){
            Session::getInstance()->enregistrer("credit", 10000);
        }else{
            $login = ConnexionUtilisateur::getLoginUtilisateurConnecte();
            $joueur = (new JoueurRepository())->recupererParClePrimaire($login);
            $joueur->setCredit($joueur->getCredit() + 10000.0);
            (new JoueurRepository())->mettreAJour($joueur);
        }

        ControleurGenerique::redirectionVersURL("ControleurFrontal.php?action=afficherJeu&controleur=machineasous");
    }
}

?>