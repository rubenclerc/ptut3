<?php
session_start();

require_once 'classes/Logic/ConnBdd.php';
require_once 'classes/Logic/Compte.php';

// Set du username
$compte = new Compte();
$compte->setUsername($_SESSION['username']);

// Si un utilisateur veut accéder à la page sans être connecté
if(!isset($_SESSION['username'])) {
    header('Location: connexion.php');
    exit();
}

// Déconnexion
if(isset($_POST['deconnexion'])){
    $compte->seDeconnecter();
    header('Location: connexion.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- META -->
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Titre -->
        <title>MindMaster</title>
        <link rel="icon" href="pictures/logo.png">

        <!-- CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="styles/styles.css">

    </head>

    <body>
        <div class="container-fluid">
            <div class="row my-3 mb-5 justify-content-between">
                <img class="col-md-2" src="pictures/logoEcrit.png" alt="Logo Mindmaster" id="navLogo">

                <h1 class="col-md-2 bleu nav-red-border text-center align-self-center py-2">Challenge 1</h1>
                
                <h1 class="col-md-2 bleu nav-red-border text-center align-self-center py-2"><?= $compte->toString() ?></h1>

                <a href="connexion.php" class="col-md-2 text-center align-self-center py-2">
                    <form action="accueil.php" method="POST">
                            <button type="submit" class="btn btn-danger" name="deconnexion"><h3> Se déconnecter </h3></button>
                    </form>
                </a>
                
            </div>
        </div>

        <div class="container">
                <div class="row red-border my-3 px-5 py-3">
                        <h1 class="rouge text-center">Rejoindre le challenge </h1>

                        <form action="code.php" method="POST">
                            <div class="row justify-content-around form-group">
                                <input class="col-md-1 blue-border" type="number" min="0" max="9" name="" id="">
                                <input class="col-md-1 blue-border" type="number" min="0" max="9" name="" id="">
                                <input class="col-md-1 blue-border" type="number" min="0" max="9" name="" id="">
                                <input class="col-md-1 blue-border" type="number" min="0" max="9" name="" id="">
                                <input class="col-md-1 blue-border" type="number" min="0" max="9" name="" id="">
                                <input class="col-md-1 blue-border" type="number" min="0" max="9" name="" id="">
                            </div>

                            <div class="row justify-content-center px-5 pt-3">
                                <input class="btn btn-primary" type="submit" value="Valider">
                            </div>
                        </form>
                    </div>


        </div>

        <div class="footer my-3">                
            <div class="row justify-content-around text-center">
                <div class="row justify-content-around">
                    <hr class="blue-hr">
                </div>                    

                <a href="#" class="col-md-6 nav-link">Conditions d'utilisations</a>
                <a href="#" class="col-md-6 nav-link">Mentions légales</a>
            </div>
        </div>
    </body>
</html>