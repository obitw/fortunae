<?php
namespace App\Casino\modele\repository;
use App\Casino\modele\dataObject\AbstractDataObject;

abstract class AbstractRepository{


    public function sauvegarder(AbstractDataObject $object): void {
        $sql = "INSERT INTO {$this->getNomTable()} (";
        $nomsColonnes = $this->getNomsColonnes();
        foreach ($nomsColonnes as $nomColonne) {
            $sql .= "$nomColonne, ";
        }
        $sql = substr($sql, 0, -2);
        $sql .= ") VALUES (";
        foreach ($nomsColonnes as $nomColonne) {
            $sql .= ":$nomColonne"."Tag, ";
        }
        $sql = substr($sql, 0, -2);
        $sql .= ")";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = $object->formatTableau();
        var_dump($values);
        $pdoStatement->execute($values);
    }

    public function mettreAJour(AbstractDataObject $object): void
    {
        $sql = "UPDATE {$this->getNomTable()} SET ";
        $nomsColonnes = $this->getNomsColonnes();
        foreach ($nomsColonnes as $nomColonne) {
            $sql .= "$nomColonne = :$nomColonne"."Tag, ";
        }
        $sql = substr($sql, 0, -2);
        $sql .= " WHERE {$this->getNomClePrimaire()} = :{$this->getNomClePrimaire()}Tag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = $object->formatTableau();
        $pdoStatement->execute($values);
    }


    public  function supprimer($valeurClePrimaire): void
    {
        $sql = "DELETE FROM {$this->getNomTable()} WHERE {$this->getNomClePrimaire()} = :{$this->getNomClePrimaire()}Tag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);

        $values = array(
            $this->getNomClePrimaire()."Tag" => $valeurClePrimaire,
        );

        $pdoStatement->execute($values);
    }


    public function recuperer() : array
    {
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query("SELECT * FROM {$this->getNomTable()}");
        $tab = [];
        foreach ($pdoStatement as $formatTableau) {
            $tab[] = $this->construireDepuisTableau($formatTableau);
        }
        return $tab;
    }
    public function recupererParClePrimaire(string $valeurClePrimaire): ?AbstractDataObject
    {
        $sql = "SELECT * from {$this->getNomTable()}  WHERE {$this->getNomClePrimaire()} = :{$this->getNomClePrimaire()}Tag";
        // Préparation de la requête
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);

        $values = array(
            $this->getNomClePrimaire()."Tag" => $valeurClePrimaire,
        );

        $pdoStatement->execute($values);

        $objectFormatTableau = $pdoStatement->fetch();

        if (!$objectFormatTableau) {
            return null;
        }
        return $this->construireDepuisTableau($objectFormatTableau);
    }

    protected abstract function getNomClePrimaire(): string;
    protected abstract function getNomTable(): string;
    protected abstract function getNomsColonnes(): array;
    protected abstract function construireDepuisTableau(array $objetFormatTableau) : AbstractDataObject;



}
?>
