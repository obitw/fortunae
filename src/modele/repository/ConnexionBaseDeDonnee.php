<?php
namespace App\Casino\modele\repository;
use App\Casino\configuration\Configuration;
use PDO;

class ConnexionBaseDeDonnee {
    private PDO $pdo;
    private static ?ConnexionBaseDeDonnee $instance = null;
    public function __construct()
    {
        $hostname = Configuration::getHostname();
        $databaseName = Configuration::getDatabase();
        $login = Configuration::getLogin();
        $password = Configuration::getPassword();
        $port = Configuration::getPort();

        $this->pdo = new PDO("mysql:host=$hostname;port=$port;dbname=$databaseName", $login, $password,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

        // On active le mode d'affichage des erreurs, et le lancement d'exception en cas d'erreur
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public static function getPdo(): PDO
    {
        return ConnexionBaseDeDonnee::getInstance() ->pdo;
    }

    private static function getInstance() : ConnexionBaseDeDonnee {
        // L'attribut statique $pdo s'obtient avec la syntaxe ConnexionBaseDeDonnee::$pdo
        // au lieu de $this->pdo pour un attribut non statique
        if (is_null(ConnexionBaseDeDonnee::$instance))
            // Appel du constructeur
            ConnexionBaseDeDonnee::$instance = new ConnexionBaseDeDonnee();
        return ConnexionBaseDeDonnee::$instance;
    }



}
?>