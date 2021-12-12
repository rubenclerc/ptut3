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
     * @var int
     */
    private $codeChallenge;

    public function __construct(Tentative $t)
    {
        $this->tentative = $t;
        $t->getChallenge()->getCode($t->getAdv());
    }

    /**
     * Comparer
     * B = mal placé
     * c = bon
     * @return Reponse
     */
    public function Comparer(): void {

        $var = $this->tentative->getCode();
        $var2 =$this->codeChallenge;
        $ni = intval(log10($this->code)) +1;
        $gemalin = "";

        for ($i=0;$i<$ni;$i++){
        $gemalin.="A";
        }

        $r ="";

        $cpt =intval(log10($var2)) + 1;

        for($x=0;$x<$cpt;$x++){
            for($y=0;$y<$cpt;$y++){
                if($var2[$x]==$var[$y]){
                    $gemalin[$x]="B";
                }
            }
        }

        for ( $i = 0; $i <=$cpt; $i++) {
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


    public function getB(): int
    {
        return substr_count($this->rep,"B");
    }

    public function getC(): int
    {
        return substr_count($this->rep,"C");
    }
}
?>