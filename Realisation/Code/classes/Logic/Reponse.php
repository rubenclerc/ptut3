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
     * B = mal placé
     * c = bon
     * @return void
     */
    public function Comparer(): void {

        $var = $this->tentative->getCode();
        $var2 =$this->tentative->getChallenge()->getLastCode($this->tentative->getAdv());
        $ni = intval(log10($var)) +1;
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

    public function get(): Reponse{
        return $this;
    }
}
?>