<?php
session_start();

require_once ("classes" . DIRECTORY_SEPARATOR . "Logic" . DIRECTORY_SEPARATOR . "ConnBdd.php");
require_once ( "classes" . DIRECTORY_SEPARATOR . "Logic" . DIRECTORY_SEPARATOR . "Compte.php");
require_once ( "classes" . DIRECTORY_SEPARATOR . "Dao" . DIRECTORY_SEPARATOR . "ChallengeDao.php");

// Si un utilisateur veut accéder à la page sans être connecté
if(!isset($_SESSION['username'])) {
    header('Location: connexion.php');
    exit();
}

// Set du username
$compte = new Compte();
$compte->setUsername($_SESSION['username']);

$challengeDao = new ChallengeDao();

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
        <style>
.divScroll {
overflow-y:scroll;
height:500px;

}
</style>
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
                
                <h1 class="col-md-2 bleu nav-red-border text-center align-self-center py-2"> <a class="bleu nav-link" href="profil.php"><?= $compte->getUsername() ?></a></h1>

                <a href="connexion.php" class="col-md-2 text-center align-self-center py-2">
                    <form action="accueil.php" method="POST">
                            <button type="submit" class="btn btn-danger" name="deconnexion"><h3> Se déconnecter </h3></button>
                    </form>
                </a>
            </div>
            
            <div class="container-fluid">
                <div class="row red-border "><div class="divScroll">
                    <table class="table table-hover rouge" >
                        <thead>
                          <tr class="bleu text-center align-self-center">
                            <th scope="col">Challenge</th>
                            <th scope="col">Difficulté</th>
                            <th scope="col">Participants</th>
                            <th scope="col">Jour</th>
                            <th scope="col">Heure</th>
                            <th scope="col">Temps restant</th>
                            <th scope="col">Inscription</th>
                          </tr>
                        </thead>
                        <tbody >
                            
                          <?php
                            $challenges = $challengeDao->ListAll();

                            foreach($challenges as $challenge)
                            {
                                $nbParti = $challengeDao->CountParticipants($challenge->ToString());

                                if($nbParti == null)
                                {
                                    $nbParti = 0;
                                }

                                echo '<tr class="text-center align-self-center">';
                                echo '<td>'. $challenge->ToString() .'</td>';
                                echo '<td>'. $challenge->getDifficulte() .'</td>';
                                echo '<td>'. $nbParti ."/" . $challenge->getNbPlaces() .'</td>';
                                echo '<td>'. $challenge->getDateDebut()->format('D d M') .'</td>';
                                echo '<td>'. $challenge->getDateDebut()->format('H') . "h". $challenge->getDateDebut()->format('m') . '</td>';
                                echo '<td>'.$challenge->getTpsRestant()->format('d') . "j, " . $challenge->getTpsRestant()->format('H') . "h" . $challenge->getTpsRestant()->format('i').'</td>';
                                $now = new DateTime();

                                if($now > $challenge->getDateDebut())
                                {
                                

                                    if($challenge->getTimeStampRestant() <= 0){
                                    echo '<td>
                                        <a href="resultat.php?chal='. $challenge->ToString() . '" class="btn btn-success">Résultat </a>
                                        </td>';
                                }else if ($challengeDao->isIn($_SESSION['username'],$challenge->ToString())&&($challenge->getTimeStampRestant() > 0)){
                                        echo '<td>
                                            <a href="code.php?chal='. $challenge->ToString() . '" class="btn btn-primary">Rejoins </a>
                                        </td>';
                                }
                                else if (($nbParti< $challenge->getNbPlaces())&&($challenge->getTimeStampRestant() > 0)){
                                    echo '<td>
                                                <a href="code.php?chal='. $challenge->ToString() . '" class="btn btn-primary">Rejoindre </a>
                                        </td>';
                                }
                                else{
                                    echo '<td>
                                        <a class="btn btn-secondary">Rejoindre </a>
                                    </td>';
                                }
                               }else{
                                echo '<td>
                                <a class="btn btn-secondary">Rejoindre </a>
                            </td>';
                               }
                                      
                                echo '</tr>';
                            }
                          ?>  
                                           
                        </tbody>
                      </table></div>
                    </div>
                </div>
            </div>

            <div class="footer my-3">                
                <div class="row justify-content-around text-center">
                    <div class="row justify-content-around">
                        <hr class="blue-hr">
                    </div>                    

                    <a href="CGU.PHP" class="col-md-6 nav-link">Conditions d'utilisations</a>
                    <a href="Mentions_legales.php" class="col-md-6 nav-link">Mentions légales</a>
                </div>
            </div>
        </div>        
    </body>
</html>