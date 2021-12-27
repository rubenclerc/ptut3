<?php
require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . "Logic" . DIRECTORY_SEPARATOR . "Compte.php");
require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . "Logic" . DIRECTORY_SEPARATOR . "ConnBdd.php");
require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . "Logic" . DIRECTORY_SEPARATOR . "BadUserError.php");
require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . "Logic" . DIRECTORY_SEPARATOR . "BadPasswordError.php");

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

            if(($row["username"] == null)){
                $userError = new BadUserError();
                throw new $userError;
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

    public function DirtyRead(string $username): Compte{
        $compte = null;
        $row = null;

        $req=$this->db->prepare('SELECT * FROM COMPTE WHERE username=:username');
        $req->bindParam(':username',$username);
        $req->execute();

        $row=$req->fetch(PDO::FETCH_ASSOC);

        $compte = new Compte($row["username"], $row["passw"], $row["estAdmin"]);

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

    public function UserExist($username): bool {
        $exist=true;
        $user=htmlentities($username);

        $req=$this->db->prepare('SELECT idCompte FROM COMPTE WHERE username=:username');
        $req->bindParam(':username',$user);
        $req->execute();
        $row = $req->fetch(PDO::FETCH_ASSOC);
        if($row==0){
            $exist=false;
        }

        return $exist;
    }

    public function getStat($username): array{
        // Init
        $ret = array();

        // On récupère l'id du joueur
        $req = $this->db->prepare('SELECT idCompte FROM COMPTE WHERE username=:username');
        $req->bindParam(':username',$username);
        $req->execute();

        $row = $req->fetch(PDO::FETCH_ASSOC);
        $id = $row['idCompte'];

        // Requête pour le nombre de parties jouées
        $reqParties = $this->db->prepare('SELECT SUM(IF(joueur = :idCompte, 1, 0)) AS nbParties FROM PARTICIPER');
        $reqParties->bindParam(':idCompte',$id);
        $reqParties->execute();

        $rowParties = $reqParties->fetch(PDO::FETCH_ASSOC);
        $nbParties = $rowParties['nbParties'];

        // Requête pour le nombre de parties gagnées
        $reqWin = $this->db->prepare('SELECT SUM(IF(compteJoueur = :idCompte, 1, 0)) AS nbWin FROM CHALLENGE');
        $reqWin->bindParam(':idCompte',$id);
        $reqWin->execute();

        $rowWin = $reqWin->fetch(PDO::FETCH_ASSOC);
        $nbWin = $rowWin['nbWin'];

        // Ajout des stats au résultat
        $ret["nbParties"] = $nbParties;
        $ret["nbWin"] = $nbWin;

        return $ret;
    }
}