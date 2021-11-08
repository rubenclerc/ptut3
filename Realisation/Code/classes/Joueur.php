<?php

/**
 * Joueur
 */
class Joueur extends Compte{
    private int $nbPoints;

    private Challenge $challenges[];

    private Tentative $tentatives[];

    $this->estAdmin=false;
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
        $challenge.addCode($code);
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
    public function toString():string{
        string $var = "Le nom du joueur est : $this->username et son nombre de points est : $this->nbPoints";
        return $var;
    }



}