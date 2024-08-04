<?php

namespace App\Casino\modele\dataObject;

use App\Casino\Util\GenerateurAleatoire;

class MachineASous extends AbstractDataObject
{
    private string $id_jeu;
    private string $nom_jeu;
    private int $mise = 0;
    private float $gain = 0;
    private static array $multiplicateurMilieu = [5, 10, 20, 45, 60, 75, 150];
    private static array $multiplicateurExtremite = [0.3, 0.5, 0.8, 5, 10, 50, 100];
    private static array $multiplicateurDiagonale = [0.5, 1, 2, 5, 10, 50, 100];
    private static array $rouleau;

    private static GenerateurAleatoire $generateurAleatoire;

    public function __construct(string $id_jeu, string $nom_jeu)
    {
        $this->id_jeu = $id_jeu;
        $this->nom_jeu = $nom_jeu;

        // Initialisation de la propriété statique $rouleau
        self::$rouleau = [];

        self::$rouleau = array_merge(self::$rouleau, array_fill(0, 23, 1));   // Symbole "1"

        self::$rouleau = array_merge(self::$rouleau, array_fill(0, 20, 2));   // Symbole "2"

        self::$rouleau = array_merge(self::$rouleau, array_fill(0, 17, 3));   // Symbole "3"

        self::$rouleau = array_merge(self::$rouleau, array_fill(0, 14, 4));   // Symbole "4"

        self::$rouleau = array_merge(self::$rouleau, array_fill(0, 11, 5));   // Symbole "5"

        self::$rouleau = array_merge(self::$rouleau, array_fill(0, 8, 6));   // Symbole "6"

        self::$rouleau = array_merge(self::$rouleau, array_fill(0, 5, 7));   // Symbole "7"


        self::$generateurAleatoire = new GenerateurAleatoire(time(), count(self::$rouleau));
    }

    public function jouer(): array
    {
        for ($i = 0 ; $i < 3 ; $i++) {
            shuffle(self::$rouleau);
            for($j = 0 ; $j < 3 ; $j++) {
                $resultat[$i][$j] = self::$generateurAleatoire->genererValeursAleatoires(self::$rouleau);
            }
        }
        return $resultat;
    }
    public function calculerGainMilieu(array $resultat): float
    {
        $gainTemp = 0;
        if ($resultat[1][0] == $resultat[1][1] && $resultat[1][1] == $resultat[1][2]) {
            $gainTemp = self::$multiplicateurMilieu[$resultat[1][0] - 1] * $this->mise;
        }
        return $gainTemp;
    }

    public function calculerGainExtremite(array $resultat): float
    {
        $gainTemp = 0;
        if ($resultat[0][0] == $resultat[0][1] && $resultat[0][1] == $resultat[0][2]) {
            $gainTemp = self::$multiplicateurExtremite[$resultat[0][0] - 1] * $this->mise;
        } else if ($resultat[2][0] == $resultat[2][1] && $resultat[2][1] == $resultat[2][2]) {
            $gainTemp = self::$multiplicateurExtremite[$resultat[2][0] - 1] * $this->mise;
        }
        return $gainTemp;
    }

    public function calculerGainDiagonale(array $resultat): float
    {
        $gainTemp = 0;
        if ($resultat[0][0] == $resultat[1][1] && $resultat[1][1] == $resultat[2][2]) {
            $gainTemp = self::$multiplicateurDiagonale[$resultat[0][0] - 1] * $this->mise;
        } else if ($resultat[0][2] == $resultat[1][1] && $resultat[1][1] == $resultat[2][0]) {
            $gainTemp = self::$multiplicateurDiagonale[$resultat[0][2] - 1] * $this->mise;
        }
        return $gainTemp;
    }

    public function calculerGain(array $resultat): float
    {
        $this->gain = $this->calculerGainMilieu($resultat) + $this->calculerGainExtremite($resultat) + $this->calculerGainDiagonale($resultat);
        return $this->gain;
    }

    public function setMise(int $mise): void
    {
        $this->mise = $mise;
    }

    public function formatTableau(): array
    {
        return [
            "id_jeuTag" => $this->id_jeu,
            "nom_jeuTag" => $this->nom_jeu,
        ];
    }

    public function getMise(): int
    {
        return $this->mise;
    }

    public function getGain(): float
    {
        return $this->gain;
    }

    public function getIdJeu(): string
    {
        return $this->id_jeu;
    }
}
