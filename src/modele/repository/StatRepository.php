<?php

namespace App\Casino\modele\Repository;

use App\Casino\modele\repository\ConnexionBaseDeDonnee;

class StatRepository
{
    public function statNbrJoueurSemaine(): array
    {
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query( "SELECT DAYNAME(J.idDate) AS jour_semaine, COUNT(DISTINCT J.pseudoUtilisateurCasino) AS nombre_joueurs
                                                                        FROM Jouer J
                                                                        JOIN Jeux Jeu ON J.idJeu = Jeu.idJeu
                                                                        WHERE Jeu.nomJeu = 'Machine à Sous'
                                                                        AND WEEK(J.idDate) = WEEK(CURRENT_DATE())
                                                                        GROUP BY jour_semaine;");
        $joursSemaine = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
        $frequentation = array_fill_keys($joursSemaine, 0);
        foreach ($pdoStatement as $formatTableau) {
            $frequentation[$formatTableau["jour_semaine"]] = $formatTableau["nombre_joueurs"];
        }
        return $frequentation;
    }

    public function GainDuCasinoEtJoueurs(): array
    {
        $parti = ["gainCasino", "gainJoueur"];
        $gains = array_fill_keys($parti, 0);
        $pdoStatement  = ConnexionBaseDeDonnee::getPdo()->query("SELECT  SUM(gainObtenu) AS gain_cumule
                                                                    FROM Jouer
                                                                    WHERE DATE(idDate) = CURRENT_DATE()");
        foreach ($pdoStatement as $formatTableau) {
            $gains["gainJoueur"] = $formatTableau["gain_cumule"];
        }
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query("SELECT SUM(miseEffectuer - gainObtenu) AS pertes_cumulees_total
                                                                    FROM Jouer
                                                                     WHERE DATE(idDate) = CURRENT_DATE();");
        foreach ($pdoStatement as $formatTableau) {
            $gains["gainCasino"] = $formatTableau["pertes_cumulees_total"];
        }

        return $gains;
    }
    public function top3Gains(): array{
        $pdoStatement  = ConnexionBaseDeDonnee::getPdo()->query("SELECT pseudoUtilisateurCasino,
                                                                           MAX(gainObtenu) AS gain
                                                                    FROM Jouer
                                                                    GROUP BY pseudoUtilisateurCasino
                                                                    ORDER BY gain DESC
                                                                    LIMIT 3;");

        $classement = [];
        if ($pdoStatement->rowCount() > 0) {
        $i = 0;
        foreach ($pdoStatement as $formatTableau) {
            $classement[$i + 1] = [$formatTableau["pseudoUtilisateurCasino"], $formatTableau["gain"]];
            $i++;
        }

        // Si le nombre de résultats est inférieur à 3, complétez avec des valeurs par défaut
        while ($i < 3) {
            $classement[$i + 1] = [' ', 0];
            $i++;
        }
    } else {
            // Aucun résultat, initialisez le tableau avec des valeurs par défaut
            $classement = [[' ', 0], [' ', 0], [' ', 0]];
        }

        return $classement;
    }

    public function meilleurGain()
    {
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query("SELECT MAX(gainObtenu) AS meilleur_gain
                                                                        FROM Jouer
                                                                        WHERE DATE(idDate) = CURRENT_DATE()
                                                                        GROUP BY pseudoUtilisateurCasino
                                                                        ORDER BY meilleur_gain DESC
                                                                        LIMIT 1;");
        $meilleurGain = 0;
        foreach ($pdoStatement as $formatTableau) {
            $meilleurGain = $formatTableau["meilleur_gain"];
        }
        return $meilleurGain;
    }

    public function benefice()
    {
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query("SELECT SUM(miseEffectuer - gainObtenu) AS benefice
                                                                        FROM Jouer;");

        $benefice = 0;
        foreach ($pdoStatement as $formatTableau) {
            $benefice = $formatTableau["benefice"];
        }
        return $benefice;
    }

    public function nbPartiesTotal(){
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query("SELECT COUNT(*) AS nombre_de_parties
                                                                    FROM Jouer;");

        $partieTotal = $pdoStatement->fetchColumn();
        return $partieTotal;
    }

    public function nbPartiesJour(){
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query("SELECT COUNT(*) AS nombre_de_parties_jour
                                                                        FROM Jouer
                                                                        WHERE DATE(idDate) = CURRENT_DATE();");

        $partieJour  = $pdoStatement->fetchColumn();
        return $partieJour;
    }

    public function moyenneMise(){
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query("SELECT ROUND(AVG(miseEffectuer), 2) AS mise_moyenne
                                                                        FROM Jouer;
                                                                        ");

        $miseMoyenne  = $pdoStatement->fetchColumn();
        return $miseMoyenne;
    }

    public function moyenneGain(){
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query("SELECT ROUND(AVG(gainObtenu), 2) AS gain_moyen
                                                                        FROM Jouer;
                                                                        ");

        $moyenneGain = $pdoStatement->fetchColumn();
        return $moyenneGain;
    }

    public function conversion($valeur){

        return $valeur / 100;
    }

}