<?php

Class Admin extends Compte{

    public function __construct(){
        $this->estAdmin=true;
    }


    /**
     * CreerChallenge
     * @param $nomChallenge
     * @param $difficulte
     * @param $dateDebut
     * @param $dateFin
     * @param $nbPlaces
     * @return Challebge
     */
    public function CreerChallenge (string $nomChallenge, int $difficulte, DateTime $dateDebut, DateTime $dateFin, int $nbPlaces) : Challenge{
        $challenge = new Challenge($nomChallenge,$difficulte,$dateDebut,$dateFin,$nbPlaces);
        return $challenge;
    }
    /**
     * SupprimerChallenge
     * @param $nomChallenge
     */
    public function SupprimerChallenge(string $nomChallenge){

    }
    /**
     * 
     */
    public function ModifierChallenge(string $nomChallenge){

    }

}