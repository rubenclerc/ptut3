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

        $req = $this->db->prepare('INSERT INTO Compte(username, passw, estAdmin, nbPoints) VALUES(:username, :pass, 0, 0)');
        $req->bindParam(':username',$username);
        $req->bindParam(':pass', $pass);	
        $req->execute();
    }

    public function Read(string $login, string $passHash): Compte{

        $Compte = null;
        $row = null;

        if(isset($login)&&isset($passHash)){
            try{
                $req=$this->db->prepare('SELECT * FROM Compte WHERE username=:username');
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
                $Compte = new Compte($row["username"], $row["passw"], $row["estAdmin"], $row['nbPoints']);
            }
        }

        return $Compte;
    }

    public function DirtyRead(string $username): Compte{
        $Compte = null;
        $row = null;

        $req=$this->db->prepare('SELECT * FROM Compte WHERE username=:username');
        $req->bindParam(':username',$username);
        $req->execute();

        $row=$req->fetch(PDO::FETCH_ASSOC);

        $Compte = new Compte($row["username"], $row["passw"], $row["estAdmin"], $row['nbPoints']);

        return $Compte;
    }

    public function Update(Compte $c){
        $username=$c->getUsername();
        $pass=$c->getPasswordHash();
        $admin=$c->getEstAdmin();

        $req=$this->db->prepare('SELECT idCompte FROM Compte WHERE username=:username');
        $req->bindParam(':username',$username);
        $req->execute();

        $row=$req->fetch(PDO::FETCH_ASSOC);
        $id=$row['idCompte'];

        $req = $this->db->prepare('UPDATE Compte SET username = :username, passw = :pass, estAdmin = :estAdmin WHERE idCompte = '. $id);
        $req->bindParam(':username',$username);
        $req->bindParam(':pass', $pass);	
        $req->bindParam(':estAdmin', $admin);
        $req->execute();
    }

    public function UserExist($username): bool {
        $exist=true;
        $user=htmlentities($username);

        $req=$this->db->prepare('SELECT idCompte FROM Compte WHERE username=:username');
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
        $req = $this->db->prepare('SELECT idCompte FROM Compte WHERE username=:username');
        $req->bindParam(':username',$username);
        $req->execute();

        $row = $req->fetch(PDO::FETCH_ASSOC);
        $id = $row['idCompte'];

        // Requête pour le nombre de parties jouées
        $reqParties = $this->db->prepare('SELECT SUM(IF(joueur = :idCompte, 1, 0)) AS nbParties FROM Participer');
        $reqParties->bindParam(':idCompte',$id);
        $reqParties->execute();

        $rowParties = $reqParties->fetch(PDO::FETCH_ASSOC);
        $nbParties = $rowParties['nbParties'];

        // Requête pour le nombre de parties gagnées
        $reqWin = $this->db->prepare('SELECT SUM(IF(compteJoueur = :idCompte, 1, 0)) AS nbWin FROM Challenge');
        $reqWin->bindParam(':idCompte',$id);
        $reqWin->execute();

        $rowWin = $reqWin->fetch(PDO::FETCH_ASSOC);
        $nbWin = $rowWin['nbWin'];

        // Requête pour le nombre de points
        $reqPoints = $this->db->prepare('SELECT nbPoints FROM Compte WHERE username = :username');
        $reqPoints->bindParam(':username',$username);
        $reqPoints->execute();

        $rowPoints = $reqPoints->fetch(PDO::FETCH_ASSOC);
        $nbPoints = $rowPoints['nbPoints'];

        // Requête pour le nombre de découvertes
        $reqDecouvertes = $this->db->prepare('SELECT SUM(IF(trouve = 1, 1, 0)) AS nbDecouv FROM Essayer WHERE joueurAttaquant = :idCompte');
        $reqDecouvertes->bindParam(':idCompte',$id);
        $reqDecouvertes->execute();

        $rowDecouvertes = $reqDecouvertes->fetch(PDO::FETCH_ASSOC);
        $nbDecouvertes = $rowDecouvertes['nbDecouv'];

        // Ajout des stats au résultat
        $ret["nbParties"] = $nbParties;
        $ret["nbWin"] = $nbWin;
        $ret["nbPoints"] = $nbPoints;
        $ret["nbDecouv"] = $nbDecouvertes;

        return $ret;
    }

    public function addPoints($username, $points){
        $req = $this->db->prepare('UPDATE Compte SET nbPoints = nbPoints + :points WHERE username = :username');
        $req->bindParam(':username',$username);
        $req->bindParam(':points',$points);
        $req->execute();
    }

    public function codeTrouves($chal, $user){
        $req = $this->db->prepare('SELECT SUM(IF(trouve = 1, 1, 0)) AS nb FROM Essayer WHERE joueurAttaquant = (SELECT idCompte FROM Compte WHERE username = :user) AND trouve = 1 AND challenge = (SELECT idChallenge FROM Challenge WHERE nomChallenge = :chal)');
        $req->bindParam(':user',$user);
        $req->bindParam(':chal',$chal);
        $req->execute();

        $row = $req->fetch(PDO::FETCH_ASSOC);

        if($row['nb'] == NULL){
            $row['nb'] = 0;
        }

        return $row['nb'];
    }
}