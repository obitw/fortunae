<?php
require_once __DIR__ . '/../src/lib/Psr4AutoloaderClass.php';
use App\Casino\Controleur\ControleurGenerique;


$loader = new App\Casino\lib\Psr4AutoloaderClass();
$loader->register();
$loader->addNamespace('App\Casino', __DIR__ .'/../src');

if(isset($_GET['controleur'])) {
    $controleur = $_GET['controleur'];
    if($controleur == "machineasous"){
        $controleur = "MachineASous";
    }
}
else{
    $controleur = "generique";
}
$nomDeClasseControleur = "App\\Casino\\Controleur\\Controleur" . ucfirst($controleur);
if (!class_exists($nomDeClasseControleur)) {
    ControleurGenerique::afficherErreur("Controleur inconnu");
}
else{
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        if (method_exists($nomDeClasseControleur, $action)) {
            $nomDeClasseControleur::$action();
        }
        else {
            $nomDeClasseControleur::afficherErreur("Une erreur est survenue, veuillez verifier votre saisie");
        }
    }
    else {
        ControleurGenerique::afficherAccueil();
    }
}
