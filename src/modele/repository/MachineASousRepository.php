<?php

namespace App\Casino\Modele\Repository;

use App\Casino\Modele\DataObject\Joueur;
use App\Casino\Modele\DataObject\MachineASous;
use http\Encoding\Stream;

class MachineASousRepository extends AbstractRepository{

    public  function getNomTable() : string {
        return "Jeux";
    }
    protected function construireDepuisTableau(array $MachineASousFormatTableau) : MachineASous
    {
        return new MachineASous($MachineASousFormatTableau['id_jeu'],$MachineASousFormatTableau['nom_jeu']);
    }


    protected function getNomClePrimaire(): string
    {
        return "id_jeu";
    }

    protected function getNomsColonnes(): array
    {
        return ["id_jeu","nom_jeu"];
    }

    public function sauvegarderPartie(int $idJeu, int $gain, int $mise, int $credit, string $pseudo, string $dateTime) : void{
        $sql = "CALL InsererPartie(
        :pseudoUtilisateurCasinoTag, 
        :idJeuTag,
        :idDateTag,
        :miseEffectuerTag,
        :gainTag,
        :creditTag)";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array(
            "pseudoUtilisateurCasinoTag" => $pseudo,
            "idJeuTag" => $idJeu,
            "idDateTag" => $dateTime,
            "miseEffectuerTag" => $mise,
            "gainTag" => $gain,
            "creditTag" => $credit
        );

        $pdoStatement->execute($values);
    }

}
