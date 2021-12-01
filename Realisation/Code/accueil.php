<?php
require_once 'classes/ConnBdd.php';
require_once 'classes/Compte.php';
session_start();

// Si un utilisateur veut accéder à la page sans être connecté
if(!isset($_SESSION['username'])) {
    header('Location: connexion.php');
    exit();
}

// Set du username
$compte = new Compte();
$compte->setUsername($_SESSION['username']);

// Accès à un challenge
if(isset($_POST['joinChall'])){
    
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
            <div class="row my-3 justify-content-between">
                <img class="col-md-2" src="pictures/logoEcrit.png" alt="Logo Mindmaster" id="navLogo">

                <h1 class="col-md-2 bleu nav-red-border text-center align-self-center py-2">Tutoriel</h1>
                
                <h1 class="col-md-2 bleu nav-red-border text-center align-self-center py-2"><?= $compte->toString() ?></h1>

                <a href="connexion.php" class="col-md-2 text-center align-self-center py-2">
                    <button class="btn btn-danger" onclick="<?php $compte->seDeconnecter() ?>"><h3>Se déconnecter</h3></button>
                </a>
            </div>



            
            <div class="container-fluid">
                <div class="row red-border">
                    <table class="table table-hover rouge">
                        <thead>
                          <tr class="bleu text-center align-self-center">
                            <th scope="col">Challenge</th>
                            <th scope="col">Difficulté</th>
                            <th scope="col">Participants</th>
                            <th scope="col">Jour</th>
                            <th scope="col">Heure</th>
                            <th scope="col">Durée</th>
                            <th scope="col">Inscription</th>
                          </tr>
                        </thead>
                        <tbody >
                          <?php
                          $db = Connexion();
                          $req = $db->prepare('SELECT * FROM challenge');
                          $req->execute();

                            while($res = $req->fetch(PDO::FETCH_ASSOC))
                            {
                                echo '<tr class="text-center align-self-center">';
                                echo '<td>'. $res["nomChallenge"] .'</td>';
                                echo '<td>'. $res["difficulte"] .'</td>';
                                echo '<td>'. $res["nbPartcipants"] .'</td>';
                                echo '<td>'. $res["dateDebut"] .'</td>';
                                echo '<td>'. $res["dateDebut"] .'</td>';
                                echo '<td>'. $res["dateDebut"] .'</td>';
                                echo '<td> <form action="accueil.php" method="POST">
                                              <input type="submit" name="joinChall" class="btn btn-primary" value="Rejoindre">
                                           </form> </td>';
                                echo '</tr>';
                            }
                          ?>                 
                        </tbody>
                      </table>
                    </div>
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
        </div>        
    </body>
</html>