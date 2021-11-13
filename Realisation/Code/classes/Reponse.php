<?php

/**
 * Reponse 
 */
class Reponse
{ 
    private $rep;
    private Tentative $tentative;
    private int $codeChallenge;

    public function __construct(Tentative $t)
    {
        $this->tentative = $t;
        $t->getChallenge()->getCode($t->getAdv());
    }

    /**
     * Comparer
     * 
     * @return Reponse
     */
    public function Comparer(): Reponse {
        $var = $this->tentative->getCode();
        $var2 =$this->codeChallenge;
        $gemalin="";
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
        $r=substr_count($gemalin,"A");
        $r.=substr_count($gemalin,"B");
        $r.=substr_count($gemalin,"C");

        $this->rep = $var;
        $this->rep.=$r;
        
        return $this;
    }
}
?>