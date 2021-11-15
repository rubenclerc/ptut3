<?php

class Tentative
{  
    private int $code;
    private Challenge $challenge;
    private Joueur $adv;
    private Joueur $joueur;
    
    /**
     * __construct
     *
     * @param  inr $code
     * @param  Challenge $c
     * @return void
     */
    public function __construct(int $code, Challenge $c, Joueur $joueur, Joueur $adv){
        $co=htmlentities($code);
        $this->code = $co;
        $this->challenge = $c;
        $this->adv = $adv;
        $this->joueur = $joueur;

        /* Partie DAO à faire
        $db = Connexion();

        $req = $db->prepare("INSERT INTO TENTATIVE(code, idC, id_joueur, id_adv) VALUES(:code, :id_challenge, :id_joueur, :id_adv)");
        */
    }
    
    /**
     * Tenter
     *
     * @return Reponse
     */
    public function Tenter(): Reponse {
        $res = new Reponse($this);
        return $res->Comparer();
    }
    
    /**
     * getChallenge
     *
     * @return Challenge
     */
    public function getChallenge(): Challenge
    {
        return $this->challenge;
    }
    
    /**
     * getAdv
     *
     * @return Joueur
     */
    public function getAdv(): Joueur
    {
        return $this->adv;
    }

    public function getCode(): int
    {
        return $this->code;
    }
}
?>