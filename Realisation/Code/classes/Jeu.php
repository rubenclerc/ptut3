<?php

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
	private $challenges[];

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
     * @param challenge c
     */
    public function AddJoueur(challenge c){
        $this->challenges[]=c;
    }

    /**
     * ListerChallenges
     * 
     * @return challenges[]
     */
    public function ListerChallenges() : array{
        return $this->challenges[];
    }

    /**
     * ListerChallenges
     * 
     * @return Joueur[]
     */
    public function ListerJoueurs() : array{
        return $Joueurs[] -> getJoueur();
    }

