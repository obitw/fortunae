<?php
namespace App\Casino\Util;

use App\Casino\modele\dataObject\MachineASous;

class TestAlea
{


    public static function genererXtirages($x) : array {
        $mas = new MachineASous(1, "Machine à sous");
        $mas->setMise(1);
        // tableau qui contient les résultats de chaque tirage de 1 a 7 pour le milieu, l'extremité et la diagonale
        $resultats = ["perdu" => 0, "1 milieu" => 0, "1 extremite" => 0, "1 diagonale" => 0, "2 milieu" => 0, "2 extremite" => 0, "2 diagonale" => 0, "3 milieu" => 0, "3 extremite" => 0, "3 diagonale" => 0, "4 milieu" => 0, "4 extremite" => 0, "4 diagonale" => 0, "5 milieu" => 0, "5 extremite" => 0, "5 diagonale" => 0, "6 milieu" => 0, "6 extremite" => 0, "6 diagonale" => 0, "7 milieu" => 0, "7 extremite" => 0, "7 diagonale" => 0];
        for ($i = 0 ; $i < $x ; $i++) {
            $resultat = $mas->jouer();
            $gainMilieu = $mas->calculerGainMilieu($resultat);
            $gainExtremite = $mas->calculerGainExtremite($resultat);
            $gainDiagonale = $mas->calculerGainDiagonale($resultat);
            if($gainMilieu == 0 && $gainExtremite == 0 && $gainDiagonale == 0) {
                $resultats["perdu"]++;
            }
            else {
                switch ($gainDiagonale) {
                    case 0:
                        break;
                    case 0.5:
                        $resultats["1 diagonale"]++;
                        break;
                    case 1:
                        $resultats["2 diagonale"]++;
                        break;
                    case 2:
                        $resultats["3 diagonale"]++;
                        break;
                    case 5:
                        $resultats["4 diagonale"]++;
                        break;
                    case 10:
                        $resultats["5 diagonale"]++;
                        break;
                    case 50:
                        $resultats["6 diagonale"]++;
                        break;
                    case 100:
                        $resultats["7 diagonale"]++;
                        break;
                }
                switch ($gainMilieu) {
                    case 0:
                        break;
                    case 5:
                        $resultats["1 milieu"]++;
                        break;
                    case 10:
                        $resultats["2 milieu"]++;
                        break;
                    case 20:
                        $resultats["3 milieu"]++;
                        break;
                    case 45:
                        $resultats["4 milieu"]++;
                        break;
                    case 60:
                        $resultats["5 milieu"]++;
                        break;
                    case 75:
                        $resultats["6 milieu"]++;
                        break;
                    case 150:
                        $resultats["7 milieu"]++;
                        break;
                }
                switch ($gainExtremite) {
                    case 0:
                        break;
                    case 0.3:
                        $resultats["1 extremite"]++;
                        break;
                    case 0.5:
                        $resultats["2 extremite"]++;
                        break;
                    case 0.8:
                        $resultats["3 extremite"]++;
                        break;
                    case 5:
                        $resultats["4 extremite"]++;
                        break;
                    case 10:
                        $resultats["5 extremite"]++;
                        break;
                    case 50:
                        $resultats["6 extremite"]++;
                        break;
                    case 100:
                        $resultats["7 extremite"]++;
                        break;
                }
            }
        }
        return $resultats;
    }

    public static function calculProba($tab, $nbDeTirage) : void {
        foreach ($tab as $key => $value) {
            echo "$key : " . $value/$nbDeTirage*100 . "%<br>";
        }
    }


}

?>