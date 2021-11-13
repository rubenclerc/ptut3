<?php

/**
 * Tentative 
 */
class Tentative
{  

    /**
     * Code
     * 
     * @var string
     */
    private $Code;

    /**
     * joueur 
     * 
     * @var Joueur
     */
    private Joueur $joueur;

    public function __construct(string $Code){
        $this->Code = $Code;
    }

    public function Tenter() : Reponse {
        return $Code;
    }

    
}
?>