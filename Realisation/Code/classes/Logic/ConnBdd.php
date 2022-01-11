<?php

function Connexion():PDO{
    try{
        $bdd=new PDO('mysql:host=ZAZA;dbname=grp-AZAZAZA', 'grp-AZAZAZAE', 'AZAZZA');
    }
    catch(Exception $e){
        die("Erreur : ".$e->getMessage() );
    }
    return $bdd;
}
?>
