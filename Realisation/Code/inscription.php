<?php
session_start();

    require_once "classes/Logic/Compte.php";
    require_once "classes/Logic/ConnBdd.php";
    require_once "classes/Dao/CompteDao.php";

    // Si l'utilisateur est déjà connecté
    if(isset($_SESSION['username'])){
        Header("Location: accueil.php");
        exit();
    }

    // Scipt d'inscritption
    if(isset($_POST['Identifiant']) && isset($_POST['MdP']) && isset($_POST['verifMdP'])){
        $isMdpGood = true;
        $mdp = htmlentities($_POST['MdP']);
        $verifMdp = htmlentities($_POST['verifMdP']);

        if(!($mdp == $verifMdp)){
            $isMdpGood = false;
        } else{
            $compte = new Compte();

            $inscriptionValidee = $compte->inscription($_POST["Identifiant"],$_POST["MdP"]);
    
            if($inscriptionValidee){
                $_SESSION['username'] = $compte->getUsername();
                Header("Location: accueil.php");
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
                <form action="inscription.php" method="POST" >
                    <div class="container col-md-9">
                        <div class="row bleu red-border justify-content-around">
                            <h1 class="text-center my-4">S'INSCRIRE</h1>
                            <div class="col-md-3">
                                <?php if(isset($isMdpGood) && !$isMdpGood){ echo "<div class='alert alert-danger text-center'>Rentrer les mêmes mots de passe</div>"; } ?>
                                <?php if(isset($inscriptionValidee) && !$inscriptionValidee){ echo "<div class='alert alert-danger text-center'>Utilisateur déjà existant</div>"; } ?>
                                <label for="Identifiant" class="form-label">Identifiant :</label>
                                <input type="text" class="form-control blue-border" name="Identifiant" placeholder="Identifiant" required="required">
                            
                                <label for="MdP" class="form-label">Mot de passe :</label>
                                <input type="password"  class="form-control blue-border" name="MdP" placeholder="*********" required="required">
                            
                                <label for="verifMdP" class="form-label">Confirmez mot de passe :</label>
                                <input type="password"  class="form-control blue-border" name="verifMdP" placeholder="*********" required="required"><br>
                                
                            </div>
                            <div class="row justify-content-around">
                                <input type="submit" class="form-control btn btn-primary" id="submitButtonInscription" value="VALIDER">
                                <h6 class="text-center my-4"> <a href="connexion.php" style="color:#FF0000">Déjà inscrit ?</a></h6>
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