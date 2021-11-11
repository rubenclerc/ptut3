<?php

include 'Joueur.php';


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

    public function setNomChallenge(string $nomChallenge){
        $this->nomChallenge=$nomChallenge;
    }

     /**
     * codes
     * 
     * @var array
     */
    private $codes = [];

    public function addCode(int $code){
        $this->codes[]=$code;
    }

     /**
     * difficulte
     * 
     * @var int
     */
    private $difficulte;

    public function setDifficulte(int $difficulte){
        $this-> $difficulte=$difficulte;
    }

     /**
     * dateDebut
     * 
     * @var DateTime
     */
    private $dateDebut;

    public function setDateDebut(DateTime $dateDebut){
        $this-> $dateDebut=$dateDebut;
    }

     /**
     * dateFin
     * 
     * @var DateTime
     */
    private $dateFin;

    public function setDateFin(DateTime $dateFin){
        $this-> $dateFin=$dateFin;
    }

     /**
     * getDuree
     * 
     * @return DateTime
     */
    public function getDuree() : int{
        $duree = $this->dateFin->diff($this->dateDebut);
		return $duree;
    }


     /**
     * nbPlaces
     * 
     * @var int
     */
    private $nbPlaces;

    public function setNbPlaces(int $nbPlaces){
        $this->$nbPlaces=$nbPlaces;
    }

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
	private $participants = [];
	
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
    public function AddJoueur(Joueur $j){
        $this->participants[]=$j;
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
        $var = "Le nom du challenge est {$this->nomChallenge}, la difficulté est  {$this->difficulte}, le challenge commence le  {$this->dateDebut}, la duree est de  {$this->duree} et fini donc le  {$this->dateFin}, il y a  {$this->nbPlaces} places et  {$this->nbParticipants} Participants.";
        return $var ;
    }

    
}
?>