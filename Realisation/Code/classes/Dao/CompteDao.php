<?php
require_once "../Logic/ConnBdd.php";
require_once "../Logic/Compte.php";
require_once "../Logic/BadUserError.php";
require_once "../Logic/BadPasswordError.php";

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
        $row = null;

        if(isset($login)&&isset($passHash)){
            try{
                $req=$this->db->prepare('SELECT * FROM COMPTE WHERE username=:username');
                $req->bindParam(':username',$login);
                $req->execute();

                $row=$req->fetch(PDO::FETCH_ASSOC);
            }
            catch(Exception $ex){
                echo $ex->__toString();
            }

            if($row["username"] == null){
                throw new BadUserError();
            }
            elseif($row["passw"] != $passHash){
                throw new BadPasswordError("");
            }
            else{
                $compte = new Compte($row["username"], $row["passw"], $row["estAdmin"]);
            }
        }

        return $compte;
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