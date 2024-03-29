<?php
require_once "ConnBdd.php";
require_once 'Compte.php';

Class Admin extends Compte{
    
    /**
     * __construct
     *
     * @param  string $username
     * @param  string $password
     * @param  bool $estAdmin
     * @return void
     */
    public function __construct(string $username="", string $password="", bool $estAdmin=true){
        $user=htmlentities($username);
        $pass=htmlentities($password);
        $admin=htmlentities($estAdmin);
        parent::__construct($user,$pass,$admin);
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
        $nom=htmlentities($nomChallenge);
        $diff=htmlentities($difficulte);
        $nb=htmlentities($nbPlaces);
        $challenge = new Challenge($nom,$diff,$dateDebut,$dateFin,$nb);

        return $challenge;
    }
    /**
     * SupprimerChallenge
     * @param $nomChallenge
     */
    public function supprimerChallenge(string $nomChallenge){
        $bdd=Connexion();
        $nom=htmlentities($nomChallenge);
        $req = $bdd->prepare('DELETE FROM CHALLENGE WHERE nomChallenge= :nomChallenge');
        $req->execute(array(
            'nomChallenge' => $nom
        ));
    }

}
?>