<?php
namespace App\Casino\modele\HTTP;

use App\Casino\configuration\ConfigurationSite;
use Exception;

class Session
{
    private static ?Session $instance = null;

    /**
     * @throws Exception
     */
    private function __construct()
    {
        if (session_start() === false) {
            throw new Exception("La session n'a pas réussi à démarrer.");
        }
        $this->verifierDerniereActivite();

    }

    public static function getInstance(): Session
    {
        if (is_null(Session::$instance))
            Session::$instance = new Session();
        return Session::$instance;
    }

    public function contient($nom): bool
    {
        return isset($_SESSION[$nom]);
    }

    public function enregistrer(string $nom, mixed $valeur): void
    {
        $_SESSION[$nom] = $valeur;
    }

    public function lire(string $nom): mixed
    {
        if (isset($_SESSION[$nom])) {
            return $_SESSION[$nom];
        } else {
            return null;
        }
    }

    public function supprimer($nom): void
    {
        unset($_SESSION[$nom]);
    }

    public function detruire(): void
    {
        session_unset();     // unset $_SESSION variable for the run-time
        session_destroy();   // destroy session data in storage
        Cookie::supprimer(session_name()); // deletes the session cookie

    }

    public function verifierDerniereActivite(): void
    {
        $dureeDexpirationSession = (new ConfigurationSite())->getDureeDexpirationSession();
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $dureeDexpirationSession)) {
            $this->detruire();
        }
        $_SESSION['LAST_ACTIVITY'] = time();

    }
}
?>