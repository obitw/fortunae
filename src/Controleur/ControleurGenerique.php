<?php

namespace App\Casino\Controleur;
use App\Casino\lib\MessageFlash;
class ControleurGenerique
{

    public static function redirectionVersURL(string $url): void
    {
        header("Location: $url");
        exit();
    }

    public static function afficherErreur(string $messageErreur = "")
    {
        ControleurGenerique::afficherVue('vueGenerale.php', ["pagetitle" => "Erreur", "cheminVueBody" => "erreurGenerique.php", "erreur" => $messageErreur]);
    }


    protected static function afficherVue(string $cheminVue, array $parametres = []): void
    {
        $messagesFlash = MessageFlash::lireTousMessages();
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../vue/$cheminVue"; // Charge la vue
    }
    public static function afficherAccueil(): void
    {
        MessageFlash::ajouter("success", "Bienvenue sur le site de la roulette");
        ControleurGenerique::afficherVue("vueGenerale.php", ["pagetitle" => "Accueil", "cheminVueBody" => "acceuil.php"]);

    }
    public static function afficherJeu(): void
    {
        ControleurGenerique::afficherVue("vueGenerale.php", ["pagetitle" => "Jeu", "cheminVueBody" => "jeu.php"]);
    }

    public static function afficherRegles(): void
    {
        ControleurGenerique::afficherVue("vueGenerale.php", ["pagetitle" => "Règles", "cheminVueBody" => "regles.php"]);
    }

    public static function afficherContact(): void
    {
        ControleurGenerique::afficherVue("vueGenerale.php", ["pagetitle" => "Contact", "cheminVueBody" => "contact.php"]);
    }

    public static function afficherCgu(): void
    {
        ControleurGenerique::afficherVue("vueGenerale.php", ["pagetitle" => "Conditions Générales", "cheminVueBody" => "cgu.php"]);
    }


}