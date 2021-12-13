<?php

/**
 * Reponse 
 */
class Reponse
{ 
    /**
     * @var string
     */
    private $rep;

    /**
     * @var Tentative
     */
    private $tentative;

    /**
     * @var array
     */
    private $codeChallenge;

    public function __construct(Tentative $t)
    {
        $this->tentative = $t;
        $this->codeChallenge = $t->getChallenge()->getCode($t->getAdv());
    }

    /**
     * Comparer
     * A = chiffre qui a rien a voir avec le code
     * B = bon chiffre mais mal placé
     * c = bon chiffre bien placé
     * @return void
     */
    public function Comparer(): void {

        $var = strval($this->tentative->getCode());
        $var2 = strval($this->tentative->getChallenge()->getCode($this->tentative->getAdv()));
        $gemalin = "";
        $cpt =intval(log10($var2)) + 1;


        for ($i=0;$i<$cpt;$i++){
            $gemalin.="A";
        }


        for($x=0;$x<$cpt;$x++){
            for($y=0;$y<$cpt;$y++){
                if(strcmp($var[$x],$var2[$y]) == 0){
                    $gemalin[$x]="B";
                }
            }
        }

        for ($i = 0; $i <=$cpt-1; $i++) {
            if ($var2[$i]==$var[$i]){
                //comparer le i caractere 
                $gemalin[$i]="C";
            }
        }
        $this->rep = $gemalin;
    }

    public function getRep(){
        return $this->rep;
    }

    public function get(): Reponse{
        return $this;
    }
}
?>