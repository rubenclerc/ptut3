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

        //Récupère l'ID du joueur
        $req=$db->prepare('SELECT * FROM Compte WHERE username = :username');
            $req->bindParam(':username',$this->joueur->getUsername());
            $req->execute();
            $row=$req->fetch(PDO::FETCH_ASSOC);
            $idJ=$row['idCompte'];
        

        //Récupère l'ID de l'adversaire
        $req=$db->prepare('SELECT * FROM Compte WHERE username = :usernameAdv');
            $req->bindParam(':usernameAdv',$this->adv->getUsername());
            $req->execute();
            $row=$req->fetch(PDO::FETCH_ASSOC);
            $idA=$row['idCompte'];

        //Récupère l'ID du challenge
        $req=$db->prepare('SELECT * FROM Challenge WHERE nomChallenge = :nomChallenge');
            $req->bindParam(':nomChallenge',$this->challenge->ToString());
            $req->execute();
            $row=$req->fetch(PDO::FETCH_ASSOC);
            $idC=$row['idChallenge'];
        
        //Récupère le code du joueur attaqué
        $req=$db->prepare('SELECT * FROM Participer WHERE challenge=:challenge and joueur=:id_adv');
            $req->bindParam(':challenge', $idC);
            $req->bindParam(':id_adv', $idA);
            $req->execute();
            $row=$req->fetch(PDO::FETCH_ASSOC);
            $codeAdv = $row['codeJoueur'];

            
        $req = $db->prepare('INSERT INTO Essayer(codeEssaye, joueurAttaquant, joueurAttaque, challenge) VALUES(:code, :id_Attaquant, :id_Attaque, :id_Challenge)');
            $req->bindParam(':code',$code);	
            $req->bindParam(':id_Attaquant', $idJ);
            $req->bindParam(':id_Attaque', $idA);
            $req->bindParam(":id_Challenge",$idC);
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