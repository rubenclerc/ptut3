<?php
require_once "Challenge.php";

/**
 * Jeu
 */
class Jeu
{  

    /**
	*challenges
	*
	*@var array
	*/
	private $challenges = [];

    /**
     *getNbChallenges
     *
     * @return int 
     */
	public function getNbChallenges(): int {
        return count($this->challenges);
    }

    /**
     * ListerChallenges
     * 
     * @return array
     */
    public function ListerChallenges(): array{
        return $this->challenges;
    }
    
    /**
     * ListerJoueurs
     *
     * @param  Challenge $c
     * @return array
     */
    public function ListerJoueurs(Challenge $c): array{

        $res = [];

        // Parcourt les joueurs du challenge et les ajoute au tableau résultat
        foreach($c->getJoueurs() as $joueur){
            $res[] = $joueur;
        }

        return $res;

    }

}
