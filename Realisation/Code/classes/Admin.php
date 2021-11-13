<?php
require_once "ConnBdd.php";

Class Admin extends Compte{
    
    /**
     * __construct
     *
     * @param  string $username
     * @param  string $password
     * @param  bool $estAdmin
     * @return void
     */
    public function __construct(string $username, string $password, bool $estAdmin){
        parent::__construct($username,$password,$estAdmin);
    }

    /**
     * CreerChallenge
     * @param $nomChallenge
     * @param $difficulte
     * @param $dateDebut
     * @param $dateFin
     * @param $nbPlaces
     * @return Challenge
     */
    public function creerChallenge (string $nomChallenge, int $difficulte, DateTime $dateDebut, DateTime $dateFin, int $nbPlaces) : Challenge{
        $challenge = new Challenge($nomChallenge,$difficulte,$dateDebut,$dateFin,$nbPlaces);

        return $challenge;
    }
    /**
     * SupprimerChallenge
     * @param $nomChallenge
     */
    public function supprimerChallenge(string $nomChallenge){
        $bdd=Connexion();

        $req = $bdd->prepare('DELETE FROM CHALLENGE WHERE nomChallenge= :nomChallenge');
        $req->execute(array(
            'nomChallenge' => $nomChallenge
        ));
    }
    /**
     * 
     */
    public function modifierChallenge(Challenge $c, string $nomChallenge, int $difficulte, DateTime $dateDebut, DateTime $dateFin, int $nbPlaces){
        $bdd=Connexion();
        $req = $bdd->prepare('UPDATE CHALLENGE nomChallenge= :nomChallenge, difficulte= :difficulte, dateDebut= :dateDebut, dateFin= :dateFin, nbParticipants= :nbParticipants WHERE nomChallenge = :oldName');

        $req->execute(array(
            'nomChallenge' => $nomChallenge,
            'difficulte' => $difficulte,
            'dateDebut' => $dateDebut,
            'dateFin' => $dateFin,
            'nbParticipants' => $nbPlaces,
            'oldName' => $c->ToString()
        ));

        $c->setNomChallenge($nomChallenge);
        $c->setDifficulte($difficulte);
        $c->setDateDebut($dateDebut);
        $c->setDateFin($dateFin);
        $c->setNbPlaces($nbPlaces);
    }

}
?>