<?php
require_once "ConnBdd.php";
require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . "Dao" . DIRECTORY_SEPARATOR . "CompteDao.php");

/**
 * Compte
 */
class Compte {

    // Attributs

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
     * seConnecter
     *
     * @return void
     */
    public function seConnecter(){

        if(isset($username)&&isset($password)){
            $bdd = Connexion();
            $user=htmlentities($username);
            $pass=htmlentities($password);
            $req=$bdd->prepare('SELECT * FROM COMPTE WHERE username=:username');
            $req->bindParam(':username',$user);
            $req->execute();
            $row=$req->fetch(PDO::FETCH_ASSOC);
            $hash=$row['passwd'];
            if($pass==$hash){
                $this->username = $user;
            }
            else{
                echo "Ce n'est pas le bon mot de passe ou le bon nom d'utilisateur";
            }
        }
        else{
            echo'';
        }
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

    public function toString(): string{
        return $this->username;
    }

    public function getUsername(): string{
        return $this->username;
    }

    public function getPasswordHash(): string{
        return $this->passwordHash;
    }
}