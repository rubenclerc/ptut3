<?php

/**
 * Challenge
 */
class Challenge
{    
    include 'Joueur.php';
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
    private $codes[];

    public function addCode(int $code){
        $this->codes[]=$code;
    }

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
     * getDuree
     * 
     * @return DateTime
     */
    public function getDuree() : DateTime{
		$duree= $this->dateFin-$this->dateDebut;
		return $duree;
    }


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
	*joueurs
	*
	*@var array
	*/
	private $participants[];
	
    /**
     *getNbJoueur
     *
     * @return int 
     */
	public function getNbJoueur() : int{
        return count($this->joueurs);
    }

    /**
     * AddJoueur
     * @param Joueur j
     */
    public function AddJoueur(Joueur j){
        $this->participants[]=j;
    }

    /**
     * getJoueurs
     * @return array
     */
    public function getJoueurs():array{
        return $this->participants;
    }

    
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
    public  function ToString() : string{
        $var = "";
        $var = "Le nom du challenge est $nomChallenge, la difficulté est $difficulte, le challenge commence le $dateDebut, la duree est de $duree et fini donc le $dateFin, il y a $nbPlaces places et $nbParticipants Participants."
        return $var ;
    }

    
}