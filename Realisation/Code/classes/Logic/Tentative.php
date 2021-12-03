<?php

class Tentative
{  
    private int $code;
    private Challenge $challenge;
    private Joueur $adv;
    private Joueur $joueur;
    
    /**
     * __construct
     *
     * @param  int $code
     * @param  Challenge $c
     * @return void
     */
    public function __construct(int $code, Challenge $c, Joueur $joueur, Joueur $adv){
        $co=htmlentities($code);
        $this->code = $co;
        $this->challenge = $c;
        $this->adv = $adv;
        $this->joueur = $joueur;

        // Partie DAO à faire
        $db = Connexion();

        $req=$db->prepare('SELECT codeEssaye FROM Participer WHERE challenge=:challenge and joueur=:id_adv');
            $req->bindParam(':username',$user);
            $req->bindParam(':id_adv', $adv);
            $req->execute();
            $row=$req->fetch(PDO::FETCH_ASSOC);

            
        $req = $db->prepare('INSERT INTO TENTATIVE(code, idC, id_joueur, id_adv) VALUES(:code, :id_challenge, :id_joueur, :id_adv)');
            $req->bindParam(':code',$code);	
            $req->bindParam(':id_joueur', $joueur);
            $req->bindParam(':id_adv', $adv);
            $req->execute();
            echo"coucou";
            
            
            
            if ($this->Gagner()){
                ///à remplir
            }
       
    }
    
    /**
     * Gagner
     *
     * @return bool
     */
    public function Gagner(): bool {
        $bool = false;
        $res = new Reponse($this);
        $st =$res->Comparer($this);
        $r=substr_count($st,"C");
        $ni = log10($this->code)+1;
        if ($r == $ni){
            $bool  =true;
        }
        return $bool;
    }
    
    /**
     * getChallenge
     *
     * @return Challenge
     */
    public function getChallenge(): Challenge
    {
        return $this->challenge;
    }
    
    /**
     * getAdv
     *
     * @return Joueur
     */
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

    public function getA(): int
    {
        $res = new Reponse($this);
        $st =$res->Comparer($this);
        return $r=substr_count($st,"A");
    }

    public function getB(): int
    {
        $res = new Reponse($this);
        $st =$res->Comparer($this);
        return $r=substr_count($st,"B");
    }

    public function getC(): int
    {
        $res = new Reponse($this);
        $st =$res->Comparer($this);
        return $r=substr_count($st,"C");
    }
}
?>