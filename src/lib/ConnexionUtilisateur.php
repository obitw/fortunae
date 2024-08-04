<?php
namespace App\Casino\lib;

use App\Casino\modele\HTTP\Session;

class ConnexionUtilisateur
{
    // L'utilisateur connecté sera enregistré en session associé à la clé suivante
    private static string $cleConnexion = "joueurConnecte";

    public static function estConnecte(): bool
    {
        $session = Session::getInstance();
        return $session->contient(ConnexionUtilisateur::$cleConnexion);
    }

    public static function deconnecter(): void
    {
        $session = Session::getInstance();
        $session->supprimer(ConnexionUtilisateur::$cleConnexion);
    }

    public static function getLoginUtilisateurConnecte(): ?string
    {
        $session = Session::getInstance();
        if (ConnexionUtilisateur::estConnecte()){
            $joueur = $session->lire(ConnexionUtilisateur::$cleConnexion);
            return $joueur->getLogin(); // Changed from getPseudoUtilisateurCasino to getLogin
        }else{
            return null;
        }
    }

    public static function estAdmin(): bool
    {
        $session = Session::getInstance();
        if (ConnexionUtilisateur::estConnecte()){
            $joueur = $session->lire(ConnexionUtilisateur::$cleConnexion);
            return $joueur->getEstAdmin() === 1; // Check if the user is an admin
        }else{
            return false;
        }
    }
}