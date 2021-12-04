<?php
session_start();

    require_once "classes/Compte.php";
    require_once "classes/ConnBdd.php";

    $foo = false;
    $compte = new Compte();
    $compte->inscription($_POST["Identifiant"],$_POST["MdP"],$foo);
    Header('Location: accueil.php');
    exit();
?>