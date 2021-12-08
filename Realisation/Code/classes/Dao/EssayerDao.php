<?php
require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . "Logic" . DIRECTORY_SEPARATOR . "ConnBdd.php");
require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . "Logic" . DIRECTORY_SEPARATOR . "Joueur.php");
require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . "Logic" . DIRECTORY_SEPARATOR . "Challenge.php");
require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . "Logic" . DIRECTORY_SEPARATOR . "Tentative.php");

class EssayerDao{

    private $db;

    public function __construct(){
        $this->db = Connexion();
    }

    public function Create(Joueur $attaquant, Joueur $victime, int $code, Challenge $chall){
        
        // Récupère l'ID de l'attaquant
        $req = $this->db->prepare('SELECT idCompte FROM Compte WHERE username = :username');
        $req->bindParam(':username', $attaquant->getUsername());
        $req->execute();
        $row = $req->fetch(PDO::FETCH_ASSOC);
        $idAttaquant = $row['idCompte'];

        // Récupère l'ID de la victime
        $req = $this->db->prepare('SELECT idCompte FROM Compte WHERE username = :usernameAdv');
        $req->bindParam(':usernameAdv', $victime->getUsername());
        $req->execute();
        $row = $req->fetch(PDO::FETCH_ASSOC);
        $idVictime = $row['idCompte'];

        // Récupère l'ID du challenge
        $req = $this->db->prepare('SELECT idChallenge FROM Challenge WHERE nomChallenge = :nomChallenge');
        $req->bindParam(':nomChallenge',$chall->ToString());
        $req->execute();
        $row = $req->fetch(PDO::FETCH_ASSOC);
        $idChallenge = $row['idChallenge'];

        // Insère le l'essai
        $req = $this->db->prepare('INSERT INTO Essayer(codeEssaye, joueurAttaquant, joueurAttaque, challenge) VALUES(:code, :id_Attaquant, :id_Attaque, :id_Challenge)');
        $req->bindParam(':code',$code);	
        $req->bindParam(':id_Attaquant', $idAttaquant);
        $req->bindParam(':id_Attaque', $idVitime);
        $req->bindParam(":id_Challenge",$idChallenge);
        $req->execute();

    }

    public function Read(int $idTentative): Tentative{
        $tentative = null;

        $req = $this->db->prepare('SELECT * FROM ESSAYER WHERE tentative = :idTentative');
        $req->execute(array('idTentative' => $idTentative));
        $row = $req->fetch(PDO::FETCH_ASSOC);

        $tentative = new Tentative($row["codeEssaye"], $row["joueurAttaquant"], $row["joueurAttaque"], $row["challenge"]);

        return $tentative;
    }

    public function ListAll(Joueur $joueur, Challenge $challenge): array{
        // Initialisation du résultat
        $listeTentatives = [];

        // Récupération de l'identifiant du challenge
        $reqIdC = $this->db->prepare('SELECT idChallenge FROM CHALLENGE WHERE nomChallenge = :nomChallenge');
        $reqIdC->execute(array('nomChallenge' => $challenge->ToString()));
        $rowIdC = $reqIdC->fetch(PDO::FETCH_ASSOC);

        // Récupération de l'identifiant du joueur
        $reqIdJ = $this->db->prepare('SELECT idJoueur FROM JOUEUR WHERE username = :username');
        $reqIdJ->execute(array('username' => $joueur->getUsername()));
        $rowIdJ = $reqIdJ->fetch(PDO::FETCH_ASSOC);

        // Récupération des tentatives
        $reqArr = $this->db->prepare('SELECT * FROM ESSAYER WHERE joueurAttaquant = :idJoueur AND challenge = :idChallenge');
        $reqArr->execute(array('idJoueur' => $rowIdJ["idJoueur"], 'idChallenge' => $rowIdC["idChallenge"]));

        while($row = $reqArr->fetch(PDO::FETCH_ASSOC)){
            $tentative = new Tentative($row["codeEssaye"], $row["joueurAttaquant"], $row["joueurAttaque"], $row["challenge"]);
            $listeTentatives[] = $tentative;
        }

        return $listeTentatives;
    }

}