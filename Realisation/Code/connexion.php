<?php
session_start();

require_once 'classes/Logic/Compte.php';
require_once 'classes/Dao/CompteDao.php';

// Si l'utilisateur est déjà connecté
if(isset($_SESSION['username'])){
    Header("Location: accueil.php");
    exit();
}

// Script de connexion
if(isset($_POST['username']) && isset($_POST['password'])){
    $compte = new Compte();

    $header = $compte->connexion($_POST['username'], $_POST['password']);

    if($header){
        $_SESSION['username'] = $compte->getUsername();
        if(!$compte->getEstAdmin()){
            Header('Location: accueil.php');
            exit();
        }
        else{
            Header('Location:admin.php');
            exit();
        }
    }
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
            </div>
    
    
            <div class="container">
                <form action="connexion.php" method="POST">
                    <div class="container col-md-9">
                        <div class="row bleu red-border justify-content-around">
                            <h1 class="text-center my-4"> SE CONNECTER</h1>
                            <div class="col-md-3">
                                <label for="username" class="form-label">Identifiant : </label>
                                <input type="text" name="username" class="form-control blue-border" placeholder="Identifiant" class="form-control blue-border" required="required">
                                <label for="password" class="form-label">Mot de passe : </label>
                                <input type="password" name="password" class="form-control blue-border" placeholder="**********" required="required"><br>
                            </div>
                            <div class="row justify-content-around">
                                <input type="submit" class="form-control btn btn-primary my-3" id="submitButtonConnexion" value="VALIDER">
                                <h6 class="text-center my-4"> <a href="inscription.php" style="color:#FF0000">Pas de compte ?</a></h6>
                            </div>
                        </div>
                    </div>
                </form>
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
        </div>
    </body>
</html>