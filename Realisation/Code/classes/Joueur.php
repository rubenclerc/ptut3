<?php
require_once "Challenge.php";
/**
 * Joueur
 */
class Joueur extends Compte{
    private int $nbPoints;

    private Challenge $challenges = [];

    private Tentative $tentatives = [];


    public function __construct(){

    }


    /**
     * Joueur
     * @param $username
     * @param $passwordHash
     */
    public function Joueur(string $username, string $passwordHash){
        $this->username=$username;
        $this->password=$passwordHash;
    }
    /**
     * Participer
     * @param $challenge
     * @param $code
     */
    public function Participer(Challenge $challenge, int $code){
        $challenges[]=$challenge;
        $challenge->addCode($code);
    }
    /**
     * EssayerCode
     * @param $code
     * @return Tentative
     */
    public function EssayerCode(int $code) : Tentative{
        $tentative = new Tentative($code);
        $this->tentatives[]=$tentative;
        return $tentative;
    }
    /**
     * toString
     * @return string
     */
    public function ToString():string{
        
        return "str";
    }

}
?>