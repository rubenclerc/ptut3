<?php
require_once (dirname(__DIR__) . DIRECTORY_SEPARATOR . "Logic" . DIRECTORY_SEPARATOR . "ConnBdd.php");
require_once (dirname(__DIR__) . DIRECTORY_SEPARATOR . "Logic" . DIRECTORY_SEPARATOR . "Challenge.php");
require_once (dirname(__DIR__) . DIRECTORY_SEPARATOR . "Logic" . DIRECTORY_SEPARATOR . "Admin.php");
require_once (dirname(__DIR__) . DIRECTORY_SEPARATOR . "Logic" . DIRECTORY_SEPARATOR . "Rsa.php");


class ChallengeDao
{
    // Partie des challenges

    private $db;

    public function __construct(){
        $this->db = Connexion();
    }

    public function Create(Challenge $challenge, Admin $admin){
        $nomChallenge=$challenge->ToString();
        $dateDebut=$challenge->getDateDebut()->format('Y-m-d H:i:s');
        $dateFin=$challenge->getDateFin()->format('Y-m-d H:i:s');
        $nbParticipants=$challenge->getNbPlaces();
        $difficulte=$challenge->getDifficulte();
        $a=$admin->getUsername();

        $req=$this->db->prepare('SELECT * FROM compte WHERE username = :username');
            $req->bindParam(':username',$a);
            $req->execute();
            $row=$req->fetch(PDO::FETCH_ASSOC);
            $idA=$row['idCompte'];

        $req = $this->db->prepare("INSERT INTO CHALLENGE(nomChallenge, dateDebut, dateFin,nbPartcipants, difficulte, compteAdmin) VALUES(:nomChallenge, :dateDebut, :dateFin, :nbParticipants, :difficulte, :idAdmin)");
        $req->bindParam(':nomChallenge', $nomChallenge);
        $req->bindParam(':dateDebut', $dateDebut);
        $req->bindParam(':dateFin', $dateFin);
        $req->bindParam(':nbParticipants', $nbParticipants);
        $req->bindParam(':difficulte', $difficulte);
        $req->bindParam(':idAdmin', $idA);

        $req->execute();
    }

    public function Read(string $nomChallenge): Challenge{
        $challenge = null;
        $req=$this->db->prepare('SELECT * FROM challenge WHERE nomChallenge=:nomChall');
        $req->bindParam(':nomChall',$nomChallenge);
        $req->execute();
        $row=$req->fetch(PDO::FETCH_ASSOC);
        $challenge=new Challenge($row['nomChallenge'],$row['difficulte'],new DateTime($row['dateDebut']), new DateTime($row['dateFin']),$row['nbPartcipants']);
        return $challenge;
    }

    public function ReadId(int $idChallenge): Challenge{
        $challenge = null;
        $req=$this->db->prepare('SELECT * FROM challenge WHERE idChallenge=:idChall');
        $req->bindParam(':idChall',$idChallenge);
        $req->execute();
        $row=$req->fetch(PDO::FETCH_ASSOC);
        $challenge=new Challenge($row['nomChallenge'],$row['difficulte'],new DateTime($row['dateDebut']), new DateTime($row['dateFin']),$row['nbPartcipants']);
        return $challenge;
    }

    public function Update(Challenge $challenge, int $id){
        $nomChallenge=$challenge->ToString();
        $dateDebut=$challenge->getDateDebut()->format('Y-m-d H:i:s');
        $dateFin=$challenge->getDateFin()->format('Y-m-d H:i:s');
        $nbParticipants=$challenge->getNbPlaces();
        $difficulte=$challenge->getDifficulte();
        $date=date("Y-m-d H:i:s");
        $timestamp1 = strtotime($dateDebut); 
        $timestamp2 = strtotime($date);
        if(($timestamp1 > $timestamp2)){
            $req = $this->db->prepare('update challenge set nomChallenge = :nomChall, dateDebut = :dateDebut, dateFin = :dateFin, nbPartcipants = :nbParticipants, difficulte = :difficulte where idChallenge = :id');
            $req->bindParam(':nomChall',$nomChallenge);
            $req->bindParam(':dateDebut', $dateDebut);	
            $req->bindParam(':dateFin', $dateFin);
            $req->bindParam(':nbParticipants',$nbParticipants);
            $req->bindParam(':difficulte', $difficulte);
            $req->bindParam(':id',$id);
            $req->execute();
        }
    }

    public function Delete(Challenge $challenge){
        $nomChallenge=$challenge->ToString();
        $dateDebut=$challenge->getDateDebut();
        $stringDate = $dateDebut->format('Y-m-d H:i:s');
        $req=$this->db->prepare('SELECT * FROM challenge WHERE nomChallenge=:nomChall');
        $req->bindParam(':nomChall',$nomChallenge);
        $req->execute();
        $row=$req->fetch(PDO::FETCH_ASSOC);
        $idC=$row['idChallenge'];
        $date=date("Y-m-d H:i:s");
        $timestamp1 = strtotime($stringDate); 
        $timestamp2 = strtotime($date);  
        if($timestamp1 > $timestamp2){
            echo"ok";
            $reqdel = $this->db->prepare('delete from challenge  where idChallenge = '. $idC);
            $reqdel->execute();
        }

    }

    public function ListAll(): array{
        $req=$this->db->prepare('SELECT * FROM CHALLENGE');
        $req->execute();
        $challenges = array();
        while($row=$req->fetch(PDO::FETCH_ASSOC)){
            $c = new Challenge($row['nomChallenge'], $row['difficulte'], new DateTime($row['dateDebut']), new DateTime($row['dateFin']), $row['nbPartcipants']);
            $challenges[] = $c;
        }
        return $challenges;
    }


    // Partie d'un challenge précis

    public function ListParticipants(string $nomChallenge): array{

        $participants=array();
        $req=$this->db->prepare('SELECT idChallenge from challenge where nomChallenge = :nomChallenge');
        $req->bindParam(':nomChallenge',$nomChallenge);
        $req->execute();
        $row=$req->fetch(PDO::FETCH_ASSOC);
        $idC = $row['idChallenge'];

        $req=$this->db->prepare('SELECT * from Compte inner join Participer on Compte.idCompte=Participer.joueur WHERE challenge = :idChal');
        $req->bindParam(':idChal',$idC);
        $req->execute();
        
        while($row=$req->fetch(PDO::FETCH_ASSOC)){
            $j = new Compte($row['username'],$row['passw'],$row['estAdmin']);
            $participants[]=$j;
        }
        return $participants;
    }

    public function UpdateParticipants(string $nomChallenge, string $username, int $code){

        //On récupère l'ID du challenge
        $req=$this->db->prepare('SELECT idChallenge from challenge where nomChallenge = :nomChallenge');
        $req->bindParam(':nomChallenge',$nomChallenge);
        $req->execute();
        $row=$req->fetch(PDO::FETCH_ASSOC);
        $idC = $row['idChallenge'];

        //On récupère l'ID du joueur
        $req=$this->db->prepare('SELECT idCompte from compte where username = :username');
        $req->bindParam(':username',$username);
        $req->execute();
        $row=$req->fetch(PDO::FETCH_ASSOC);
        $idCo = $row['idCompte'];

        //On insert le joueur, le challenge et le code dans la table
        $req=$this->db->prepare('INSERT into participer (codeJoueur, nbPoints, challenge, joueur) values(:code, 0, :challenge, :joueur)');
        $req->bindParam(':challenge',$idC);
        $req->bindParam(':joueur',$idCo);
        $req->bindParam(':code',$code);
        $req->execute();
    }

    public function ChallengeExits(string $nomChallenge): bool{
        $res = true;
        $chall = htmlentities($nomChallenge);

        $req = $this->db->prepare('SELECT idChallenge FROM challenge where nomChallenge = :nomChallenge');
        $req->bindParam(':nomChall',$chall);
        $req->execute();

        if($req->rowCount() == 0){
            $res = false;
        }

        return $res;
    }

    public function CountParticipants(string $nomChallenge): int{
        $req = $this->db->prepare('SELECT COUNT(*) FROM Participer inner join Challenge on Participer.challenge=Challenge.idChallenge where Challenge.nomChallenge = :nomChallenge');
        $req->bindParam(':nomChallenge',$nomChallenge);
        $req->execute();

        $row = $req->fetch(PDO::FETCH_ASSOC);

        return $row['COUNT(*)'];
    }

    public function isIn(string $user, string $nomChallenge):bool{
        $res = false;

        $req = $this->db->prepare('SELECT * FROM Participer WHERE joueur = (SELECT idCompte FROM compte WHERE username = :user) AND challenge = (SELECT idChallenge FROM challenge WHERE nomChallenge = :nomChallenge)');
        $req->bindParam(':user',$user);
        $req->bindParam(':nomChallenge',$nomChallenge);
        $req->execute();

        $nbLines = $req->rowCount();

        if($nbLines >= 1){
            $res = true;
        }


        return $res;
    }

    public function getCode(string $nomChallenge, string $login): int{

        $req = $this->db->prepare('SELECT codeJoueur FROM PARTICIPER WHERE challenge = (SELECT idChallenge FROM challenge WHERE nomChallenge = :nomChallenge) AND joueur = (SELECT idCompte FROM compte WHERE username = :login)');
        $req->bindParam(':nomChallenge',$nomChallenge);
        $req->bindParam(':login',$login);
        $req->execute();

        $row = $req->fetch(PDO::FETCH_ASSOC);
        $code = $row['codeJoueur'];

        return $code;
    }

    public function getId(string $nomChallenge):int{
        $nomChall = $nomChallenge;
        $req=$this->db->prepare('SELECT idChallenge from challenge where nomChallenge = :nomChall');
        $req->bindParam(':nomChall',$nomChall);
        $req->execute();
        $row = $req->fetch(PDO::FETCH_ASSOC);
        return $row['idChallenge'];
    }

}