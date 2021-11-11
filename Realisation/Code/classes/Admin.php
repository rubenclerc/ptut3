<?php
require_once "ConnBdd.php";
Class Admin extends Compte{

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
    public function ModifierChallenge(string $nomChallenge, int $difficulte, DateTime $dateDebut, DateTime $dateFin, int $nbPlaces){
        $bdd=Connexion();
        $req = $bdd->prepare('Update Challenge Set nomChallenge= :nomChallenge, difficulte= :difficulte, dateDebut= :dateDebut, dateFin= :dateFin, nbParticipants= :nbParticipants');
        $req->bindValue('nomChallenge',$nomChallenge);
        $req->bindValue('difficulte',$difficulte);
        $req->bindValue('dateDebut',$dateDebut);
        $req->bindValue('dateFin',$dateFin);
        $req->bindValue('nbParticipants',$nbPlaces);
        if(!$req->execute()){
            echo 'Erreur';
        }
        else{
            echo'Réussie !';
        }
    }

}
?>