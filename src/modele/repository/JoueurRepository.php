<?php

namespace App\Casino\modele\repository;
use App\Casino\modele\dataObject\Joueur;

class JoueurRepository extends AbstractRepository{

    protected function getNomClePrimaire(): string
    {
        return "login";
    }

    protected function getNomTable(): string
    {
        return "UtilisateursCasino";
    }

    protected function getNomsColonnes(): array
    {
        return ["login", "nomUtilisateurCasino", "prenomUtilisateurCasino", "email", "motDePasse", "estAdmin", "credit", "dateDeNaissance", "token", "emailAValider", "nonce"];
    }

    protected function construireDepuisTableau(array $objetFormatTableau): Joueur
    {
        return new Joueur(
            $objetFormatTableau['login'],
            $objetFormatTableau['nomUtilisateurCasino'],
            $objetFormatTableau['prenomUtilisateurCasino'],
            $objetFormatTableau['email'],
            $objetFormatTableau['motDePasse'],
            $objetFormatTableau['estAdmin'],
            $objetFormatTableau['credit'],
            $objetFormatTableau['dateDeNaissance'],
            $objetFormatTableau['token'],
            $objetFormatTableau['emailAValider'],
            $objetFormatTableau['nonce']
        );
    }
}