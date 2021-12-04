<?php
require_once "../Logic/ConnBdd.php";
require_once "../Logic/Challenge.php";
require_once "../Logic/Admin.php";

class ChallengeDao
{
    // Partie des challenges

    private $db;

    public function __construct(){
        $this->db = Connexion();
    }

    public function Create(Challenge $challenge, Admin $admin){
        $nomChallenge=$challenge->ToString();
        $dateDebut=$challenge->getDateDebut();
        $dateFin=$challenge->getDateFin();
        $nbParticipants=$challenge->getNbPlaces();
        $difficulte=$challenge->getDiffuculte();

        $req=$this->db->prepare('SELECT * FROM compte WHERE username = :username');
            $req->bindParam(':username',$admin->getUsername());
            $req->execute();
            $row=$req->fetch(PDO::FETCH_ASSOC);
            $idA=$row['idCompte'];

        $req = $this->db->prepare("INSERT INTO CHALLENGE(nomChallenge, dateDebut, dateFin, nbParticipantsMax, difficulte, compteAdmin) VALUES(:nomChallenge, :dateDebut, :dateFin, :nbParticipantsMax, :difficulte, :idAdmin)");
        $req->bindParam(':nomChallenge', $nomChallenge);
        $req->bindParam(':dateDebut', $dateDebut);
        $req->bindParam(':dateFin', $dateFin);
        $req->bindParam(':nbParticipantsMax', $nbParticipants);
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
        $challenge=new Challenge($row['nomChallenge'],$row['difficulte'],$row['dateDebut'],$row['dateFin'],$row['nbParticipants']);
        return $challenge;
    }

    public function Update(Challenge $challenge){
        $nomChallenge=$challenge->ToString();
        $dateDebut=$challenge->getDateDebut();
        $dateFin=$challenge->getDateFin();
        $nbParticipants=$challenge->getNbPlaces();
        $difficulte=$challenge->getDiffuculte();
        $req=$this->db->prepare('SELECT * FROM challenge WHERE nomChallenge=:nomChall');
        $req->bindParam(':nomChall',$nomChallenge);
        $req->execute();
        $row=$req->fetch(PDO::FETCH_ASSOC);
        $idC=$row['idChallenge'];
        $date=$row['dateDebut'];
        if($dateDebut<$date){
            $req = $this->db->prepare('update challenge set nomChallenge = :nomChall, dateDebut = :dateDebut, dateFin = :dateFin, nbParticipants = :nbParticipants, difficulte = :difficulte where idChallenge = '. $idC);
            $req->bindParam(':nomChall',$nomChallenge);
            $req->bindParam(':dateDebut', $dateDebut);	
            $req->bindParam(':dateFin', $dateFin);
            $req->bindParam(':nbParticipants',$nbParticipants);
            $req->bindParam(':difficulte', $difficulte);
            $req->execute();
        }
    }

    public function Delete(Challenge $challenge){
        $nomChallenge=$challenge->ToString();
        $dateDebut=$challenge->getDateDebut();
        $req=$this->db->prepare('SELECT * FROM challenge WHERE nomChallenge=:nomChall');
        $req->bindParam(':nomChall',$nomChallenge);
        $req->execute();
        $row=$req->fetch(PDO::FETCH_ASSOC);
        $idC=$row['idChallenge'];
        $date=$row['dateDebut'];
        if($dateDebut<$date){
            $req = $this->db->prepare('delete challenge  where idChallenge = '. $idC);
            $req->bindParam(':nomChall',$nomChallenge);
            $req->bindParam(':dateDebut', $dateDebut);	
            $req->bindParam(':dateFin', $dateFin);
            $req->bindParam(':nbParticipants',$nbParticipants);
            $req->bindParam(':difficulte', $difficulte);
            $req->execute();
        }

    }

    public function ListAll(): array{
        $req=$this->db->prepare('SELECT * from challenge');
        $req->execute();
        $challenges = array();
        while($row=$req->fetch(PDO::FETCH_ASSOC)){
            $c = new Challenge($row['nomChallenge'],$row['difficulte'],$row['dateDebut'],$row['dateFin'],$row['nbParticipants']);
            array_push($challanges,$c);
        }
        return $challenges;
    }


    // Partie d'un challenge précis

    public function ListParticipants(string $nomChallenge): array{
        $participants=array();
        $req=$this->db->prepare('SELECT idChallenge from challenge where nomChallenge = :nomChallenge');
        $req->bindParam(':nomChall',$nomChallenge);
        $req->execute();
        $row=$req->fetch(PDO::FETCH_ASSOC);
        $idC = $row['idChallenge'];
        $req=$this->db->prepare('SELECT * from Compte inner join Participer on Compte.idJoueur=Participer.joueur inner join Challenge on Participer.challenge=Challenge.idChallenge where Challenge.idChallenge = '.$idC);
        while($row=$req->fetch(PDO::FETCH_ASSOC)){
            $j = new Joueur($row['username'],$row['passw'],$row['estAdmin']);
            array_push($participants,$j);
        }
        return $participants;
    }

    public function UpdateParticipants(string $nomChallenge, string $username, int $code){
        //On récupère l'ID du challenge
        $req=$this->db->prepare('SELECT idChallenge from challenge where nomChallenge = :nomChallenge');
        $req->bindParam(':nomChall',$nomChallenge);
        $req->execute();
        $row=$req->fetch(PDO::FETCH_ASSOC);
        $idC = $row['idChallenge'];

        //On récupère l'ID du joueur
        $req=$this->db->prepare('SELECT idCompte from compte where usernmae = :username');
        $req->bindParam(':username',$username);
        $req->execute();
        $row=$req->fetch(PDO::FETCH_ASSOC);
        $idCo = $row['idCompte'];

        //On insert le joueur, le challenge et le code dans la table
        $req=$this->db->prepare('INSERT into Participer (challenge,joueur,codeJoueur) values(:challenge,:joueur,:code)');
        $req->bindParam(':challenge',$idC);
        $req->bindParam(':joueur',$idCo);
        $req->bindParam(':code',$code);
        $req->execute();
    }

}