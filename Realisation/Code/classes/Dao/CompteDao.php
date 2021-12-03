<?php
require_once "../Logic/ConnBdd.php";
require_once "../Logic/Compte.php";

class CompteDao{

    public function Create(Compte $c){
        
    }

    public function Read(string $login, string $passHash): Compte{

        return new Compte();
    }

    public function Update(Compte $c){

    }
}