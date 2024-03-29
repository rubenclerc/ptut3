<?php
require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . "Logic" . DIRECTORY_SEPARATOR . "ConnBdd.php");
require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . "Logic" . DIRECTORY_SEPARATOR . "Challenge.php");
require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . "Logic" . DIRECTORY_SEPARATOR . "Tentative.php");

class EssayerDao{

    private $db;

    public function __construct(){
        $this->db = Connexion();
    }

    public function Create(Compte $attaquant, Compte $victime, int $code, Challenge $chall, bool $trouve){
        $att = $attaquant->getUsername();
        $vict = $victime->getUsername();
        $challenge = $chall->ToString();
        $trouv = $trouve;
        // Récupère l'ID de l'attaquant
        $req = $this->db->prepare('SELECT idCompte FROM Compte WHERE username = :username');
        $req->bindParam(':username', $att);
        $req->execute();
        $row = $req->fetch(PDO::FETCH_ASSOC);
        $idAttaquant = $row['idCompte'];

        // Récupère l'ID de la victime
        $req = $this->db->prepare('SELECT idCompte FROM Compte WHERE username = :usernameAdv');
        $req->bindParam(':usernameAdv', $vict);
        $req->execute();
        $row = $req->fetch(PDO::FETCH_ASSOC);
        $idVictime = $row['idCompte'];


        // Récupère l'ID du challenge
        $req = $this->db->prepare('SELECT idChallenge FROM Challenge WHERE nomChallenge = :nomChallenge');
        $req->bindParam(':nomChallenge', $challenge);
        $req->execute();
        $row = $req->fetch(PDO::FETCH_ASSOC);
        $idChallenge = $row['idChallenge'];

        // Insertion de la nouvelle tentative
        $req = $this->db->prepare('INSERT INTO Tentative(tmp) VALUES("")');
        $req->execute();

        // Récupération de la nouvelle tentative
        $req = $this->db->prepare('SELECT idTentative FROM Tentative ORDER BY idTentative DESC LIMIT 1');
        $req -> execute();

        $row = $req->fetch(PDO::FETCH_ASSOC);
        $idTentative = $row['idTentative'];

        if($trouv){
            // Insère le l'essai
            $req = $this->db->prepare('INSERT INTO Essayer(codeEssaye, tentative, joueurAttaquant, joueurAttaque, challenge, trouve) VALUES(:code, :id_Tentative, :id_Attaquant, :id_Attaque, :id_Challenge, 1)');
            $req->bindParam(':code',$code);	
            $req->bindParam(':id_Tentative', $idTentative);
            $req->bindParam(':id_Attaquant', $idAttaquant);
            $req->bindParam(':id_Attaque', $idVictime);
            $req->bindParam(":id_Challenge",$idChallenge);
            $req->execute();

        }else{
            // Insère le l'essai
            $req = $this->db->prepare('INSERT INTO Essayer(codeEssaye, tentative, joueurAttaquant, joueurAttaque, challenge, trouve) VALUES(:code, :id_Tentative, :id_Attaquant, :id_Attaque, :id_Challenge, 0)');
            $req->bindParam(':code',$code);	
            $req->bindParam(':id_Tentative', $idTentative);
            $req->bindParam(':id_Attaquant', $idAttaquant);
            $req->bindParam(':id_Attaque', $idVictime);
            $req->bindParam(":id_Challenge",$idChallenge);
            $req->execute();

        }


    }

    public function Read(int $idTentative): Tentative{
        $tentative = null;

        $req = $this->db->prepare('SELECT * FROM Essayer WHERE tentative = :idTentative');
        $req->execute(array('idTentative' => $idTentative));
        $row = $req->fetch(PDO::FETCH_ASSOC);

        $tentative = new Tentative($row["codeEssaye"], $row["joueurAttaquant"], $row["joueurAttaque"], $row["challenge"]);

        return $tentative;
    }

    public function ListAll(Compte $joueur, Compte $adv, Challenge $challenge): array{
        // Initialisation du résultat
        $listeTentatives = [];

        // Récupération de l'identifiant du challenge
        $reqIdC = $this->db->prepare('SELECT idChallenge FROM Challenge WHERE nomChallenge = :nomChallenge');
        $reqIdC->execute(array('nomChallenge' => $challenge->ToString()));
        $rowIdC = $reqIdC->fetch(PDO::FETCH_ASSOC);

        // Récupération de l'identifiant du joueur
        $reqIdJ = $this->db->prepare('SELECT idCompte FROM Compte WHERE username = :username');
        $reqIdJ->execute(array('username' => $joueur->getUsername()));
        $rowIdJ = $reqIdJ->fetch(PDO::FETCH_ASSOC);


        // Récupération de l'identifiant de l'adversaire
        $reqIdA = $this->db->prepare('SELECT idCompte FROM Compte WHERE username = :username');
        $reqIdA->execute(array('username' => $adv->getUsername()));
        $rowIdA = $reqIdA->fetch(PDO::FETCH_ASSOC);

        // Récupération des tentatives
        $reqArr = $this->db->prepare('SELECT * FROM Essayer WHERE joueurAttaquant = :idJoueur AND challenge = :idChallenge AND joueurAttaque = :idAdversaire');
        $reqArr->execute(array('idJoueur' => $rowIdJ['idCompte'], 'idChallenge' => $rowIdC['idChallenge'], 'idAdversaire' => $rowIdA['idCompte']));

        while($row = $reqArr->fetch(PDO::FETCH_ASSOC)){
            
            // Création du joueur
            $jreq = $this->db->prepare('SELECT * FROM Compte WHERE idCompte = :idCompte');
            $jreq->execute(array('idCompte' => $rowIdJ['idCompte']));
            $jrow = $jreq->fetch(PDO::FETCH_ASSOC);
            $joueur = new Compte($jrow['username'], $jrow['passw'], $jrow['estAdmin'], $jrow['nbPoints']);

            // Création de l'adversaire
            $areq = $this->db->prepare('SELECT * FROM Compte WHERE idCompte = :idCompte');
            $areq->execute(array('idCompte' => $rowIdA['idCompte']));
            $arow = $areq->fetch(PDO::FETCH_ASSOC);
            $adversaire = new Compte($arow['username'], $arow['passw'], $arow['estAdmin'], $arow['nbPoints']);

            // Création du challenge
            $creq = $this->db->prepare('SELECT * FROM Challenge WHERE idChallenge = :idChallenge');
            $creq->execute(array('idChallenge' => $rowIdC['idChallenge']));
            $crow = $creq->fetch(PDO::FETCH_ASSOC);
            $challenge = new Challenge($crow['nomChallenge'], intval($crow['difficulte']), new DateTime($crow['dateDebut']), new DateTime($crow['dateFin']), intval($crow['nbPartcipants']));

            $tentative = new Tentative($row["codeEssaye"], $joueur, $adversaire, $challenge);
            $listeTentatives[] = $tentative;
        }

        return $listeTentatives;
    }

    public function Trouve(compte $j, compte $adv, Challenge $challenge):bool{
        $b = false;
        $jName = $j->getUsername();
        $chall =  $challenge->ToString();
        $reqJ=$this->db->prepare('SELECT idCompte FROM Compte WHERE username=:jName');
        $reqJ->bindParam(':jName',$jName);
        $reqJ->execute();
        $jrow=$reqJ->fetch(PDO::FETCH_ASSOC);
        $aName = $adv->getUsername();
        $reqA=$this->db->prepare('SELECT idCompte FROM Compte WHERE username=:aName');
        $reqA->bindParam(':aName',$aName);
        $reqA->execute();
        $arow=$reqA->fetch(PDO::FETCH_ASSOC);
        $idJ=intval($jrow['idCompte']);
        $idA=intval($arow['idCompte']);
        $reqC=$this->db->prepare('SELECT idChallenge FROM Challenge WHERE nomChallenge=:Nchall');
        $reqC->bindParam(':Nchall',$chall);
        $reqC->execute();
        $crow=$reqC->fetch(PDO::FETCH_ASSOC);
        $idC=intval($crow['idChallenge']);
        $req=$this->db->prepare('SELECT * FROM Essayer WHERE joueurAttaquant=:idJ AND joueurAttaque=:idA AND challenge=:idC');
        $req->bindParam(':idJ',$idJ);
        $req->bindParam(':idA',$idA);
        $req->bindParam(':idC',$idC);
        $req->execute();
        while($row=$req->fetch(PDO::FETCH_ASSOC)){
            if($row['trouve']==1){
                $b=true;
            }
        }
        return $b;
    }

}