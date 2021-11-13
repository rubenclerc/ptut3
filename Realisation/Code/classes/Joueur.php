<?php
require_once "Challenge.php";
require_once "Reponse.php";

/**
 * Joueur
 */
class Joueur extends Compte{

    private int $nbPoints;
    private array $tentatives = [];


    public function __construct(string $username, string $password, bool $estAdmin){
        parent::__construct($username, $password,$estAdmin);
    }
    /**
     * Participer
     * @param $challenge
     * @param $code
     */
    public function participer(Challenge $challenge, int $code){
        $challenges[]=$challenge;
        $challenge->addCode($code);

        $db = Connexion();
        $req = $db->prepare("SELECT idCompte WHERE username = :usernamae");
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
        $tentative = new Tentative($code, $c ,$this, $j);
        $this->tentatives[]=$tentative;
        
        return $tentative->Tenter();
    }
    /**
     * toString
     * @return string
     */
    public function toString():string{
        
        return "$this->username";
    }

}
?>