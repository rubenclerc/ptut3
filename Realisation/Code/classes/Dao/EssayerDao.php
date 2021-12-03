<?php
require_once "../Logic/ConnBdd.php";
require_once "../Logic/Joueur.php";
require_once "../Logic/Challenge.php";
require_once "../Logic/Tentative.php";

class EssayerDao{

    public function Create(Joueur $attaquant, Joueur $victime, int $code, Challenge $chall){

    }

    public function Read(Tentative $tentative){

    }

    public function ListAll(Joueur $joueur): array{
        return array();
    }

}