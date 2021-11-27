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
    public function connexion(string $username, string $password): bool{
        $return = false;

        $this->username = htmlentities($username);
        $this->passwordHash = hash("sha256", $password);

        $db = Connexion();

        $req = $db->prepare("SELECT username, passw, estAdmin FROM COMPTE WHERE username = :user AND passw = :pass");
        $req->execute(array(
            'user' => $this->username,
            'pass' => $this->passwordHash
        ));

        $result = $req->fetch(PDO::FETCH_ASSOC);

        if($result['username'] == $this->username && $result['passw'] == $this->passwordHash){
            $return = true;           
        }

        return $return;
    }

    public function inscription($username, $password,$estAdmin){
        if(isset($username) && isset($password)){
            // Connexion à la base de données
            $db = Connexion();

            // Vérifcations de sécurité
            $user = htmlentities($username);
            $pass = htmlentities($password);

            // Hashage du mot de passe (CRYPT_BLOWFISH algo)
            $pass = password_hash($pass, PASSWORD_BCRYPT);

            // Requête d'insertion
            $req = $db->prepare('INSERT INTO compte (username, passw, estAdmin) values (:username, :pass, :estAdmin)');
            $req->bindParam(':username',$user);
            $req->bindParam(':pass',$pass);
            $req->bindParam(':estAdmin', $estAdmin);
            $req->execute();
            echo"coucou";
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