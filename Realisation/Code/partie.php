<?php
session_start();

require_once('classes' . DIRECTORY_SEPARATOR . 'Logic'. DIRECTORY_SEPARATOR .'ConnBdd.php');
require_once('classes' . DIRECTORY_SEPARATOR . 'Logic'. DIRECTORY_SEPARATOR .'Compte.php');
require_once ( "classes" . DIRECTORY_SEPARATOR . "Logic" . DIRECTORY_SEPARATOR . "Joueur.php");
require_once ( "classes" . DIRECTORY_SEPARATOR . "Dao" . DIRECTORY_SEPARATOR . "ChallengeDao.php");


// Set du username
$compte = new Joueur();
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
            <div class="row my-3 justify-content-between">
                <img class="col-md-2" src="pictures/logoEcrit.png" alt="Logo Mindmaster" id="navLogo">

                <h1 class="col-md-2 bleu nav-red-border text-center align-self-center py-2"><?= htmlspecialchars($_GET["chal"]) ?></h1>

                <h1 class="col-md-2 bleu nav-red-border text-center align-self-center py-2 pts-ico">5000</h1>

                <h1 class="col-md-2 bleu text-center align-self-center time-ico">5:32</h1>

                <a href="connexion.php" class="col-md-2 text-center align-self-center py-2">
                    <form action="accueil.php" method="POST">
                            <button type="submit" class="btn btn-danger" name="deconnexion"><h3> Se déconnecter </h3></button>
                    </form>
                </a>
            </div>

            <div class="row my-3 justify-content-around">
                <div class="col-md-5 red-border mx-3">
                    <h2 class="rouge text-center mt-2">Adversaire 2</h2>

                    <hr class="red-hr">

                    <div class="row justify-content-around mb-4">
                            <h4 class="col-md-2 bleu blue-dot">2</h4>
                            <h4 class="col-md-2 rouge red-dot">2</h4>

                            <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                            <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                            <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                            <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                            <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                            <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                    </div>

                    <div class="row justify-content-around mb-4">
                        <h4 class="col-md-2 bleu blue-dot">2</h4>
                        <h4 class="col-md-2 rouge red-dot">2</h4>

                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                    </div>

                    <div class="row justify-content-around mb-4">
                        <h4 class="col-md-2 bleu blue-dot">2</h4>
                        <h4 class="col-md-2 rouge red-dot">2</h4>

                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                    </div>

                    <div class="row justify-content-around mb-4">
                        <h4 class="col-md-2 bleu blue-dot">2</h4>
                        <h4 class="col-md-2 rouge red-dot">2</h4>

                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                    </div>

                    <div class="row justify-content-around mb-4">
                        <h4 class="col-md-2 bleu blue-dot">2</h4>
                        <h4 class="col-md-2 rouge red-dot">2</h4>

                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                    </div>

                    <div class="row justify-content-around mb-4">
                        <h4 class="col-md-2 bleu blue-dot">2</h4>
                        <h4 class="col-md-2 rouge red-dot">2</h4>

                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                    </div>

                    <div class="row justify-content-around mb-4">
                        <h4 class="col-md-2 bleu blue-dot">2</h4>
                        <h4 class="col-md-2 rouge red-dot">2</h4>

                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                        <h4 class="col-md-1 blue-border blue-border-xs bleu text-center">A</h4>
                    </div>

                </div>

                <div class="col-md-5 mx-3 adv">
                    <div class="row red-border">
                        <h2 class="bleu text-center mt-2">Adversaires</h2>

                        <div class="row justify-content-around">
                            <hr class="red-hr">
                        </div>

                        <div class="text-center">
                            <?php
                            $challengeDao = new ChallengeDao();
                            $participants = $challengeDao->ListParticipants($_GET["chal"]);

                            foreach($participants as $participant){

                                if($participant->getUsername() != $_SESSION["username"]){
                                    echo "<h4 class='bleu'>{$participant->getUsername()}</h4>";

                                    echo "<div class='row justify-content-around'>
                                            <hr class='md-size'>
                                        </div>";
                                }


                            }

                            ?>                   
                        </div>

                    </div>

                    <div class="row red-border my-3 px-5 py-3">
                        <form action="">
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