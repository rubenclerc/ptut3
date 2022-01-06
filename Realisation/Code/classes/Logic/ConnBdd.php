<?php

function Connexion():PDO{
    try{
        $bdd=new PDO('mysql:host=localhost;dbname=grp-299_s3_prjtut', 'grp-299', 'YPZHFt7q');
    }
    catch(Exception $e){
        die("Erreur : ".$e->getMessage() );
    }
    return $bdd;
}
?>