<?php

namespace App\Casino\Controleur;

use App\Casino\modele\repository\StatRepository;

class ControleurAdmin extends ControleurGenerique
{
    public static function afficherStat(){
        $frequentation = (new StatRepository)->statNbrJoueurSemaine();
        $gains = (new StatRepository)->GainDuCasinoEtJoueurs();
        $gainCasino = $gains["gainCasino"];
        $gainJoueur =  $gains["gainJoueur"];

        $total = $gainCasino + $gainJoueur;
        $pourcentage = [];
        if ($total != 0){
            $pourcentage["gainCasinoPourcentage"] = ($gainCasino/$total) * 100;
            $pourcentage["gainJoueurPourcentage"] = ($gainJoueur/$total) * 100;
        }else{
            $pourcentage["gainCasinoPourcentage"] = 0;
            $pourcentage["gainJoueurPourcentage"] = 0;
        }

        $top3JoueurGain = (new StatRepository)->top3Gains();

        $meilleurGain = (new StatRepository)->meilleurGain();

        $meilleurGainE = (new StatRepository)->conversion($meilleurGain);

        $benefice = (new StatRepository)->benefice();

        $beneficeE = (new StatRepository)->conversion($benefice);

        $gainMoyen = (new StatRepository)->moyenneGain();

        $gainMoyenE = (new StatRepository)->conversion($gainMoyen);

        $miseMoyenne = (new StatRepository)->moyenneMise();

        $miseMoyenneE = (new StatRepository)->conversion($miseMoyenne);

        $nbPartiesJour = (new StatRepository)->nbPartiesJour();

        $nbPartiesTotal = (new StatRepository)->nbPartiesTotal();


        ControleurAdmin::afficherVue("vueGenerale.php",
            ["pagetitle" => "STATISTIQUE", "cheminVueBody" => "admin/stat.php",
                'frequentation' => $frequentation,
                "PourcentageGainJoueur"  => $pourcentage["gainJoueurPourcentage"],
                "PourcentageGainCasino" => $pourcentage["gainCasinoPourcentage"],
                "premier" => $top3JoueurGain[1], "deuxieme" => $top3JoueurGain[2],
                "troisieme" => $top3JoueurGain[3],"meilleurGain" => $meilleurGain, "benefice" => $benefice
                , "gainMoyen" => $gainMoyen , "miseMoyenne" => $miseMoyenne
                , "nbPartiesJour" => $nbPartiesJour, "nbPartiesTotal" => $nbPartiesTotal
                ,"meilleurGainE" => $meilleurGainE, "beneficeE" => $beneficeE
                , "gainMoyenE" => $gainMoyenE , "miseMoyenneE" => $miseMoyenneE]);
    }


}