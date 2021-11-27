<?php
require_once "ConnBdd.php";

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

    /**
     * __construct
     *
     * @return void
     */
    public function __construct(){
    }

    // Constructeur créé lors de la connexion
    public function connexion(){

    }

    public function inscription($username, $password){
        if(isset($username) && isset($password)){
            // Connexion à la base de données
            $db = Connexion();

            // Vérifcations de sécurité
            $user = htmlentities($username);
            $pass = htmlentities($password);

            // Hashage du mot de passe (CRYPT_BLOWFISH algo)
            $pass = password_hash($pass, PASSWORD_BCRYPT);

            // Requête d'insertion
            $req = $db->prepare("INSERT INTO compte (username, password, estAdmin) VALUES (:username, :password, :estAdmin)");
            $req->bindParam(':username',$user);
            $req->bindParam(':password',$pass);
            $req->bindParam(':estAdmin', 0);
            $req->execute();

        }
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

    public function userExist($username): bool {
        $exist=true;
        $bdd = Connexion();
        $user=htmlentities($username);
        $req=$bdd->prepare('SELECT * FROM COMPTE WHERE username=:username');
        $req->bindParam(':username',$user);
        $req->execute();
        $row=$req->fetch(PDO::FETCH_ASSOC);
        if($row==0){
            $exist=false;
        }
        return $exist;
    }
}