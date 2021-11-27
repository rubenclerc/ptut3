<?php
require_once 'Joueur.php';


/**
 * Challenge
 */
class Challenge 
{   

    // Attributs

    /**
     * @var string
     */
    private $nomChallenge;

    /**
     * @var array
     */
    private $codes;

    /**
     * @var int
     */
    private $difficulte;

    /**
     * @var DateTime
     */
    private $dateDebut;

    /**
     * @var DateTime
     */
    private $dateFin;

    /**
     * @var int
     */
    private $nbPlaces;

    /**
     * @var Joueur
     */
    private $gagnant;

    /**
     * @var array
     */
    private $participants;

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

            // Insertion dans la DB
            $db = Connexion();
            $req = $db->prepare("INSERT INTO CHALLENGE(nomChallenge, dateDebut, dateFin, nbParticipantsMax, difficulte) VALUES(:nomChallenge, :dateDebut, :dateFin, :nbParticipantsMax, :difficulte)");
            $req->bindParam(':nomChallenge', $this->nomChallenge);
            $req->bindParam(':dateDebut', $this->dateDebut);
            $req->bindParam(':dateFin', $this->dateFin);
            $req->bindParam(':nbParticipantsMax', $this->nbPlaces);
            $req->bindParam(':difficulte', $this->difficulte);

            $req->execute();
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

        $db = Connexion();
        $req = $db->prepare("UPDATE CHALLENGE SET nomChallenge = :nomChallenge WHERE nomChallenge = :nomChallenge");
        $req->bindParam(':nomChallenge', $this->nomChallenge);

        $req->execute();
    }
    
    /**
     * addCode
     *
     * @param  int $code
     * @return void
     */
    public function addCode(Joueur $j, int $code){
        $this->codes[$j->toString()] =  $code;
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

            $db = Connexion();
            $req = $db->prepare("UPDATE CHALLENGE SET difficulte = :difficulte WHERE nomChallenge = :nomChallenge");
            $req->bindParam(':difficulte', $this->difficulte);
            $req->bindParam(':nomChallenge', $this->nomChallenge);
    
            $req->execute();
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

        $db = Connexion();
        $req = $db->prepare("UPDATE CHALLENGE SET dateDebut = :dateDebut WHERE nomChallenge = :nomChallenge");
        $req->bindParam(':dateDebut', $this->dateDebut);
        $req->bindParam(':nomChallenge', $this->nomChallenge);

        $req->execute();
    }
    
    /**
     * setDateFin
     *
     * @param  DateTime $dateFin
     * @return void
     */
    public function setDateFin(DateTime $dateFin){
        $this-> $dateFin=$dateFin;

        $db = Connexion();
        $req = $db->prepare("UPDATE CHALLENGE SET dateFin = :dateFin WHERE nomChallenge = :nomChallenge");
        $req->bindParam(':dateFin', $this->dateFin);
        $req->bindParam(':nomChallenge', $this->nomChallenge);

        $req->execute();
    }

    /**
     * setNbPlaces
     *
     * @param  int $nbPlaces
     * @return void
     */
    public function setNbPlaces(int $nbPlaces){
        $this->$nbPlaces=$nbPlaces;

        $db = Connexion();
        $req = $db->prepare("UPDATE CHALLENGE SET nbParticipantsMax = :nbParticipantsMax WHERE nomChallenge = :nomChallenge");
        $req->bindParam(':nbParticipantsMax', $this->nbPlaces);
        $req->bindParam(':nomChallenge', $this->nomChallenge);

        $req->execute();
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
     * getCode
     *
     * @param  Joueur $j
     * @return int
     */
    public function getCode(Joueur $j): int{
        return $this->codes[$j->toString()];
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