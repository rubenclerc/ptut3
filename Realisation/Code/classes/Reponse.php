<?php

/**
 * Reponse 
 */
class Reponse
{ 
    /**
     * @var Reponse
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
    public function Comparer(Tentative $t): string {
        $var = $t->getCode();
        $var2 =$this->codeChallenge;
        $ni = log10($this->code)+1;
        $gemalin = "";
        for ($i=0;$i<$ni;$i++){
        $gemalin.="A";
        }
        $r ="";

        $cpt = count(array_map('intval', str_split($var2)));
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
        return $this->rep;
    }
}
?>