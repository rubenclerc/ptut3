<?php
require_once 'Joueur.php';


/**
 * Challenge
 */
class Challenge 
{   

    // Attributs

    private string $nomChallenge;
    private array $codes;
    private int $difficulte;
    private DateTime $dateDebut;
    private DateTime $dateFin;
    private int $nbPlaces;
    private Joueur $gagnant;
    private array $participants;

    // Méthodes

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
    public function __construct(string $nomChallenge, int $difficulte, DateTime $dateDebut, DateTime $dateFin, int $nbPlaces)
    {
        $this->nomChallenge = $nomChallenge;
        $this->difficulte = $difficulte;
        $this->nbPlaces = $nbPlaces;

        if($dateFin < $dateDebut)
        {
            throw new Exception("La date de fin doit être supérieure à la date de début");
        }
        else{
            $this->dateDebut = $dateDebut;
            $this->dateFin = $dateFin;
        }
    }
    
    /**
     * setNomChallenge
     *
     * @param  string $nomChallenge
     * @return void
     */
    public function setNomChallenge(string $nomChallenge){
        $this->nomChallenge=$nomChallenge;
    }
    
    /**
     * addCode
     *
     * @param  int $code
     * @return void
     */
    public function addCode(int $code){
        $this->codes[]=$code;
    }
    
    /**
     * setDifficulte
     *
     * @param  int $difficulte
     * @return void
     */
    public function setDifficulte(int $difficulte){
        if($difficulte > 4){
            throw new BadValueError();
        }
        else{
            $this-> $difficulte=$difficulte;
        }
    }
    
    /**
     * setDateDebut
     *
     * @param  DateTime $dateDebut
     * @return void
     */
    public function setDateDebut(DateTime $dateDebut){
        $this-> $dateDebut=$dateDebut;
    }
    
    /**
     * setDateFin
     *
     * @param  DateTime $dateFin
     * @return void
     */
    public function setDateFin(DateTime $dateFin){
        $this-> $dateFin=$dateFin;
    }

     /**
     * getDuree
     * 
     * @return int
     */
    public function getDuree(): int{
        $duree = $this->dateFin->getTimestamp() - $this->dateDebut->getTimestamp();
		return $duree;
    }
    
    /**
     * setNbPlaces
     *
     * @param  int $nbPlaces
     * @return void
     */
    public function setNbPlaces(int $nbPlaces){
        $this->$nbPlaces=$nbPlaces;
    }	
	
    /**
     *getNbJoueur
     *
     * @return int 
     */
	public function getNbJoueur(): int{
        return count($this->participants);
    }

    /**
     * AddJoueur
     * @param Joueur j
     */
    public function addJoueur(Joueur $j){
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
     * ToString
     *
     * 
     * @return string
     */
    public  function ToString(): string{
        return "$this->nomChallenge";
    }    
}
?>