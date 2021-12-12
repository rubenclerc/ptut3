<?php
require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . "Dao" . DIRECTORY_SEPARATOR . "EssayerDao.php");


class Tentative
{  
    private $code;
    private $challenge;
    private $adv;
    private $joueur;
    
    /**
     * __construct
     *
     * @param  int $code
     * @param  Challenge $c
     * @return void
     */
    public function __construct(int $code, Compte $joueur, Compte $adv, Challenge $c){
        $co=htmlentities($code);
        $this->code = $co;
        $this->challenge = $c;
        $this->adv = $adv;
        $this->joueur = $joueur;

        $essayerDao = new EssayerDao();
        $essayerDao->Create($joueur, $adv, $code, $c);
            
    }
    

    public function Gagner(): bool {
        $bool = false;
        $res = new Reponse($this);
        $res->Comparer();

        $r=substr_count($res->getRep(),"C");
        $ni = log10($this->code)+1;
        if ($r == $ni){
            $bool  =true;
        }
        return $bool;
    }
    
    public function getChallenge(): Challenge
    {
        return $this->challenge;
    }
    

    public function getAdv(): Joueur
    {
        return $this->adv;
    }

    public function getCode(): int
    {
        return $this->code;
    }
    public function Tenter(): Reponse {
        $res = new Reponse($this);
        return $res->Comparer($this);
    }

}
?>