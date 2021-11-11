<?php
require_once "ConnBdd.php";
/**
 * 
 */
class Compte {
    private string $username;

    private string $password;

    private bool $estAdmin;
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct(string $username, string $password, bool $estAdmin){
        if(isset($username)&&isset($password)){
            $bdd = Connexion();
            $req=$bdd->prepare('Select from Compte where username=:username');
            $req->bindParam(':username',$username);
            $req->execute();
            $row=$req->fetch(PDO::FETCH_ASSOC);
            $hash=$row['passwd'];
            if($password==$hash){
                $this->estAdmin = $estAdmin;
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
     * 
     */
    public function getEstAdmin() : bool{
        return $this->estAdmin;
    }
}
?>