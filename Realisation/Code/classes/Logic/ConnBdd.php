<?php

function Connexion():PDO{
    try{
        $bdd=new PDO('mysql:host=localhost;dbname=ptut3', 'root', '');
    }
    catch(Exception $e){
        die("Erreur : ".$e->getMessage() );
    }
    return $bdd;
}
?>