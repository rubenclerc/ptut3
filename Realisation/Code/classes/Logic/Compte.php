<?php
require_once "ConnBdd.php";
require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . "Dao" . DIRECTORY_SEPARATOR . "CompteDao.php");

/**
 * Compte
 */
class Compte {

    // Attributs
    /**
     * @var int
     */
    private $nbPoints;

    /**
     * @var string
     */
    private $username;

    /**
     *  @var string
     */
    private $passwordHash;

    /**
     * @var bool
     */
    private $estAdmin;
    

    // Méthodes
    public function __construct($username = "", $passwordHash = "", $estAdmin = false){
        $this->username = $username;
        $this->passwordHash = $passwordHash;
        $this->estAdmin = $estAdmin;
    }

    // Constructeur créé lors de la connexion
    public function connexion(string $username, string $password): bool{
        $return = false;

        $this->username = htmlentities($username);
        $this->passwordHash = hash("sha256", $password);

        $compteDao = new CompteDao();
        $compte = $compteDao->Read($this->username, $this->passwordHash);

        if($compte != null){
            $this->estAdmin = $compte->getEstAdmin();
            $this->username = $compte->getUsername();
            $this->passwordHash = $compte->getPasswordHash();
            $return = true;
        }

        return $return;
    }

    public function inscription($username, $password): bool{
        $compteDao = new CompteDao();
        $exist = $compteDao->Userexist($username);
        $inscriptionValidee = false;

        if(!$exist){
            $this->username = htmlentities($username);
            $this->passwordHash = hash("sha256", $password);
            $inscriptionValidee = true;

            $compteDao->Create($this);
        }

        return $inscriptionValidee;
    }


    /**
     * seDeconnecter
     *
     * @return void
     */
    public function seDeconnecter(){
        session_destroy();
    }
    
    /**
     * getEstAdmin
     *
     * @return bool
     */
    public function getEstAdmin(): bool{
        return $this->estAdmin;
    }

    public function setUsername($username){
        $this->username = $username;
    }

    public function setPassHash($passHash){
        $this->passwordHash =  hash("sha256", $passHash);
    }

    public function toString(): string{
        return $this->username;
    }

    public function getUsername(): string{
        return $this->username;
    }

    public function getPasswordHash(): string{
        return $this->passwordHash;
    }

    public function getNbPoints():int{
        return $this->nbPoints;
    }
}