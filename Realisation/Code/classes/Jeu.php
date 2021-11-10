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
	public function getNbChallenges() : int {
        return count($this->challenges);
    }

    /**
     * AddChallenges
     * 
     * @param Challenge c
     */
    public function AddJoueur(){
    }

    /**
     * ListerChallenges
     * 
     * @return challenges[]
     */
    public function ListerChallenges() : array{
        return [];
    }

    /**
     * ListerChallenges
     * 
     * @return Joueur[]
     */
    public function ListerJoueurs() : array{
        return [];

    }

}
?>