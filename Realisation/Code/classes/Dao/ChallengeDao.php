<?php
require_once "../Logic/ConnBdd.php";
require_once "../Logic/Challenge.php";

class ChallengeDao
{
    // Partie des challenges

    public function Create(Challenge $challenge){

    }

    public function Read(string $nomChallenge): Challenge{
        return new Challenge("","", new DateTime(), new DateTime(), "", "");
    }

    public function Update(Challenge $challenge){

    }

    public function Delete(Challenge $challenge){

    }

    public function ListAll(): array{
        return array();
    }


    // Partie d'un challenge précis

    public function ListParticipants(string $nomChallenge): array{
        return array();
    }

    public function UpdateParticipants(string $nomChallenge, string $username){

    }

}