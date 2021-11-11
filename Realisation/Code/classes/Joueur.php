<?php
require_once "Challenge.php";
/**
 * Joueur
 */
class Joueur extends Compte{
    private int $nbPoints;

    private Challenge $challenges = [];

    private Tentative $tentatives = [];


    public function __construct(string $username, string $password, bool $estAdmin){
        parent::__construct($username, $password,$estAdmin);
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