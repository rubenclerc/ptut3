<?php
require_once "ConnBdd.php";

/**
 * Compte
 */
class Compte {

    // Attributs
    private string $username;

    private string $passwordHash;

    // Un compte n'est pas admin par défaut (souci de sécurité)
    private bool $estAdmin = false;
    
    /**
     * __construct
     *
     * @param  string $username
     * @param  string $password
     * @param  bool $estAdmin
     * @return void
     */
    public function __construct(string $username, string $password, bool $estAdmin){

        if(isset($username) && isset($password) && isset($estAdmin)){
            // Connexion à la base de données
            $db = Connexion();

            // Vérifcations de sécurité
            $user = htmlentities($username);
            $pass = htmlentities($password);
            
            if(!is_bool($estAdmin)){
                throw new BadValueError();
            }

            elseif(strlen($pass) < 12){
                throw new BadPasswordError("longueur inférieure à 12 caractères");
            }

            // On peut faire la requête
            else{
                // Hashage du mot de passe (CRYPT_BLOWFISH algo)
                $pass = password_hash($pass, PASSWORD_BCRYPT);

                // Requête d'insertion
                $req = $db->prepare("INSERT INTO compte (username, password, estAdmin) VALUES (?, ?, ?)");
            } 
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
            $req=$bdd->prepare('SELECT * FROM COMPTE WHERE username=:username');
            $req->bindParam(':username',$username);
            $req->execute();
            $row=$req->fetch(PDO::FETCH_ASSOC);
            $hash=$row['passwd'];
            if($password==$hash){
                $this->username = $username;
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
}
