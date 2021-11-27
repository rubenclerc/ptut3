<?php 
    require_once "classes/Compte.php";
    require_once "classes/ConnBdd.php";
    require_once "classes/ConnBdd.php";
    $foo = false;
    $Test = new Compte();
    $Test->inscription($_POST["Identifiant"],$_POST["MdP"],$foo);
    Header('Location: Accueil.php');
?>