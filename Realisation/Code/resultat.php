<?php
session_start();
require_once ( "classes" . DIRECTORY_SEPARATOR . "Dao" . DIRECTORY_SEPARATOR . "ChallengeDao.php");


// Challenge courant
$challengeDao = new ChallengeDao();
$curChallenge = $challengeDao->Read(htmlentities($_GET['chal']));

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

                <h1 class="col-md-2 bleu nav-red-border text-center align-self-center py-2"><?= $curChallenge->ToString() ?></h1>

                <a href="accueil.php" class="col-md-2 text-center align-self-center py-2">
                        <button class="btn btn-danger" ><h3>Revenir à l'accueil</h3></button>
                </a>
        </div>

    </body>

</html>