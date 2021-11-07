<?php

/**
 * Challenge
 */
class Challenge
{    
    /**
     * nomChallenge
     * 
     * @var string
     */
    private $nomChallenge;

     /**
     * codes
     * 
     * @var array
     */
    private $codes;

     /**
     * difficulte
     * 
     * @var int
     */
    private $difficulte;

     /**
     * dateDebut
     * 
     * @var DateTime
     */
    private $dateDebut;

     /**
     * dateFin
     * 
     * @var DateTime
     */
    private $dateFin;

     /**
     * duree
     * 
     * @var string
     */
    private $duree;

     /**
     * nbParticipants
     * 
     * @var int
     */
    private $nbParticipants;

     /**
     * nbPlaces
     * 
     * @var int
     */
    private $nbPlaces;

     /**
     * gagnant
     * 
     * @var Joueur
     */
    private $gagnant;
    
    /**
     * Challenge
     *
     * @param  string nomChallenge
     * @param  int difficulte
     * @param  DateTime dateDebut
     * @param  DateTime dateFin
     * @param  int nbPlaces
     * @return Challenge
     */
    public function Challenge($nomChallenge,$difficulte,$dateDebut,$dateFin,$nbPlaces) {
        $this->nomChallenge  = $nomChallenge;
        $this->difficulte = $difficulte;
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
        $this->nbPlaces = $nbPlaces;
    }

    
    /**
     * ToString
     *
     * 
     * @return string
     */
    public  function ToString() {
        $var = "";
        $var = "Le nom du challenge est $nomChallenge, la difficulté est $difficulte, le challenge commence le $dateDebut, la duree est de $duree et fini donc le $dateFin, il y a $nbPlaces places et $nbParticipants Participants."
        return $var ;
    }

    
}