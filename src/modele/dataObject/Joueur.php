<?php
namespace App\Casino\modele\dataObject;
use App\Casino\lib\MotDePasse;

class Joueur extends AbstractDataObject{

    private string $login;
    private string $nomUtilisateurCasino;
    private string $prenomUtilisateurCasino;
    private string $email;
    private string $motDePasse;
    private int $estAdmin;
    private float $credit;
    private string $dateDeNaissance;
    private string $token;
    private string $emailAValider;
    private string $nonce;

    public function __construct(string $login, string $nom, string $prenom, string $email, string $mdpHache, int $estAdmin, float $credit, string $dateDeNaissance, string $token, string $emailAValider, string $nonce)
    {
        $this->login = $login;
        $this->nomUtilisateurCasino = $nom;
        $this->prenomUtilisateurCasino = $prenom;
        $this->email = $email;
        $this->motDePasse = $mdpHache;
        $this->estAdmin = $estAdmin;
        $this->credit = $credit;
        $this->dateDeNaissance = $dateDeNaissance;
        $this->token = $token;
        $this->emailAValider = $emailAValider;
        $this->nonce = $nonce;
    }

    // Getters
    public function getLogin(): string { return $this->login; }
    public function getNomUtilisateurCasino(): string { return $this->nomUtilisateurCasino; }
    public function getPrenomUtilisateurCasino(): string { return $this->prenomUtilisateurCasino; }
    public function getEmail(): string { return $this->email; }
    public function getMotDePasse(): string { return $this->motDePasse; }
    public function getEstAdmin(): int { return $this->estAdmin; }
    public function getCredit(): float { return $this->credit; }
    public function getDateDeNaissance(): string { return $this->dateDeNaissance; }
    public function getToken(): string { return $this->token; }
    public function getEmailAValider(): string { return $this->emailAValider; }
    public function getNonce(): string { return $this->nonce; }

    // Setters
    public function setLogin(string $login): void { $this->login = $login; }
    public function setNomUtilisateurCasino(string $nom): void { $this->nomUtilisateurCasino = $nom; }
    public function setPrenomUtilisateurCasino(string $prenom): void { $this->prenomUtilisateurCasino = $prenom; }
    public function setEmail(string $email): void { $this->email = $email; }
    public function setMotDePasse(string $mdpHache): void { $this->motDePasse = $mdpHache; }
    public function setEstAdmin(int $estAdmin): void { $this->estAdmin = $estAdmin; }
    public function setCredit(float $credit): void { $this->credit = $credit; }
    public function setDateDeNaissance(string $dateDeNaissance): void { $this->dateDeNaissance = $dateDeNaissance; }
    public function setToken(string $token): void { $this->token = $token; }
    public function setEmailAValider(string $emailAValider): void { $this->emailAValider = $emailAValider; }
    public function setNonce(string $nonce): void { $this->nonce = $nonce; }


    public function formatTableau(): array
    {
        return [
            'loginTag' => $this->getLogin(),
            'nomUtilisateurCasinoTag' => $this->getNomUtilisateurCasino(),
            'prenomUtilisateurCasinoTag' => $this->getPrenomUtilisateurCasino(),
            'emailTag' => $this->getEmail(),
            'motDePasseTag' => $this->getMotDePasse(),
            'estAdminTag' => $this->getEstAdmin(),
            'creditTag' => $this->getCredit(),
            'dateDeNaissanceTag' => $this->getDateDeNaissance(),
            'tokenTag' => $this->getToken(),
            'emailAValiderTag' => $this->getEmailAValider(),
            'nonceTag' => $this->getNonce(),
        ];
    }

    public static function construireDepuisFormulaire(array $tabFormulaire): Joueur
    {
        return new Joueur(
            $tabFormulaire["login"],
            $tabFormulaire["nomUtilisateurCasino"],
            $tabFormulaire["prenomUtilisateurCasino"],
            $tabFormulaire["email"],
            (new MotDePasse())->hacher($tabFormulaire["motDePasse"]),
            $tabFormulaire["estAdmin"],
            $tabFormulaire["credit"],
            $tabFormulaire["dateDeNaissance"],
            $tabFormulaire["token"],
            $tabFormulaire["emailAValider"],
            $tabFormulaire["nonce"]
        );
    }
}

    
?>