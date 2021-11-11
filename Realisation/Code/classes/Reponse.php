<?php

/**
 * Reponse 
 */
class Reponse
{  
    /**
     * rep
     * 
     * @var string
     */
    private $rep;

    /**
     * tentative 
     * 
     * @var string
     */
    private Tentative $tentative;

    /**
     * codeChallenge 
     * 
     * @var string
     */
    private Tentative $codeChallenge;

    /**
     * __construct
     * 
     * @var string
     */
    public function __construct(string $rep)
    {
        $this->rep = $rep;
    }

    /**
     * Comparer
     * 
     * @return Reponse
     */
    public function Comparer() : Reponse {
        $result= new Reponse("");
        $var = $this->tentative;
        $var2 =$this->codeChallenge;
        $gemalin="";
        $r ="";
        if (count($var)==count($var2)){
        $cpt = count($var2);
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
        $result->rep = $var;
        $result->rep.=$r;
    }
        return $result;
    }
}
?>