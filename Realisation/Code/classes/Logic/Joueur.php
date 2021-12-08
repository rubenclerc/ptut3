<?php
require_once "Challenge.php";
require_once "Reponse.php";
require_once "Compte.php";

/**
 * Joueur
 */
class Joueur extends Compte{

    /**
     * @var int
     */
    private $nbPoints;

    /**
     * @var array
     */
    private $tentatives = [];


    public function __construct(string $username="", string $password="", bool $estAdmin=false, int $nbPoints = 0){
        parent::__construct($username, $password,$estAdmin);
        $this->nbPoints = $nbPoints;
    }
    /**
     * Participer
     * @param $challenge
     * @param $code
     */
    public function participer(Challenge $challenge, int $code){
        $challenges[]=$challenge;
        $challenge->addCode($this,$code);

        $db = Connexion();
        $req = $db->prepare("SELECT idCompte WHERE username = :username");
        $req->execute(array(
            'username' => $this->username
        ));

        $row = $req->fetch();
        $idJ = $row['idCompte'];

        $req = $db->prepare("SELECT idChallenge WHERE nomChallenge = :nomChallenge");
        $req->execute(array(
            'nomChallenge' => $challenge->ToString()
        ));

        $row = $req->fetch();
        $idChall = $row['idChallenge'];

        $req = $db->prepare("INSERT INTO PARTICIPER(idCompte, idChallenge, code) VALUES (:idJoueur, :idJoueur, :code)");
        $req->execute(array(
            'idJoueur' => $idJ,
            'idChallenge' => $idChall,
            'code' => $code
        ));
    }
    /**
     * EssayerCode
     * @param $code
     * @return Reponse
     */
    public function essayerCode(int $code, Challenge $c, Joueur $j): Reponse{
        $tentative = new Tentative($code, $j ,$this, $c);
        $this->tentatives[]=$tentative;
        
        return $tentative->Tenter();
    }

    public function peutParticiper(Challenge $challenge):bool{
       return false;
    }

    public function getNbPoints():int{
        return $this->nbPoints;
    }
}
?>