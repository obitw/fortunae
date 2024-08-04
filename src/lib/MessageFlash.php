<?php

namespace App\Casino\Lib;

use App\Casino\modele\HTTP\Session;

class MessageFlash
{

    // Les messages sont enregistrés en session associée à la clé suivante
    private static string $cleFlash = "_messagesFlash";

    // $type parmi "success", "info", "warning" ou "danger"
    public static function ajouter(string $type, string $message): void
    {
        $session = Session::getInstance();
        if (!$session->contient(self::$cleFlash)) {
            $session->enregistrer(self::$cleFlash, ["success" => [], "info" => [], "warning" => [], "danger" => []]);
        }
        $flashMessages = $session->lire(self::$cleFlash);
        $flashMessages[$type][] = $message;
        $session->enregistrer(self::$cleFlash, $flashMessages);
    }

    public static function contientMessage(string $type): bool
    {
        return Session::getInstance()->contient(self::$cleFlash) && isset(Session::getInstance()->lire(self::$cleFlash)[$type]);
    }

    // Attention : la lecture doit détruire le message
    public static function lireMessages(string $type): array
    {
        $session = Session::getInstance();
        if(self::contientMessage($type)) {
            $messages = $session->lire(self::$cleFlash);
            $session->supprimer(self::$cleFlash);
            return $messages[$type];
        }else{
            return [];
        }
    }

    public static function lireTousMessages() : array
    {
        $session = Session::getInstance();
        if($session->contient(self::$cleFlash)) {
            $messages = $session->lire(self::$cleFlash);
            $session->supprimer(self::$cleFlash);
            return $messages;
        }else{
            return [];
        }
    }

}