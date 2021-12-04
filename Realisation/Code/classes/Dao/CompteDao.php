<?php
require_once "../Logic/ConnBdd.php";
require_once "../Logic/Compte.php";
require_once "../Logic/BadUserError.php";

class CompteDao{
    
    private $db;

    public function __construct(){
        $this->db = Connexion();
    }

    public function Create(Compte $c){
        $username=$c->getUsername();
        $pass=$c->getPasswordHash();
        $admin=$c->getEstAdmin();

        $req = $this->db->prepare('INSERT INTO compte (username, passw, estAdmin) values (:username, :pass, :estAdmin)');
        $req->bindParam(':username',$username);
        $req->bindParam(':pass', $pass);	
        $req->bindParam(':estAdmin', $admin);
        $req->execute();
    }

    public function Read(string $login, string $passHash): Compte{
        $compte = null;
        $row =null;

        if(isset($login)&&isset($passHash)){
            try{
                $req=$this->db->prepare('SELECT * FROM COMPTE WHERE username=:username');
                $req->bindParam(':username',$login);
                $req->execute();
                $row=$req->fetch(PDO::FETCH_ASSOC);
                $pass=$row['passw'];
                $c = null;
                if ($pass==$passHash){
                    $estAdmin=$row['estAdmin'];
                    $c = new Compte($login,$pass,$estAdmin);
                }
                return $c;
            }
            catch(BadUserError $ex){
                echo $ex->__toString();
            }
        }
    }

    public function Update(Compte $c){
        $username=$c->getUsername();
        $pass=$c->getPasswordHash();
        $admin=$c->getEstAdmin();

        $req=$this->db->prepare('SELECT idCompte FROM COMPTE WHERE username=:username');
        $req->bindParam(':username',$username);
        $req->execute();

        $row=$req->fetch(PDO::FETCH_ASSOC);
        $id=$row['idCompte'];

        $req = $this->db->prepare('update compte set username = :username, passw = :pass, estAdmin = :estAdmin where idCompte = '. $id);
        $req->bindParam(':username',$username);
        $req->bindParam(':pass', $pass);	
        $req->bindParam(':estAdmin', $admin);
        $req->execute();
    }
}