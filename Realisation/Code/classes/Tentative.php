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
    private $code;

    /**
     * joueur 
     * 
     * @var Joueur
     */
    private Joueur $joueur;

    public function __construct(string $Code){
        $this->code = $Code;
    }

    public function Tenter(): Reponse {
        $res = new Reponse();

        return $res->Comparer();
    }
}
?>