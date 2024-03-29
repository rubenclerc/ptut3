<?php
session_start();

require_once 'classes/Logic/ConnBdd.php';
require_once 'classes/Logic/Compte.php';
require_once ( "classes" . DIRECTORY_SEPARATOR . "Dao" . DIRECTORY_SEPARATOR . "ChallengeDao.php");


// Init
$compte = new Compte();
$compte->setUsername($_SESSION['username']);

$challengeDao = new ChallengeDao();
$challenge = $challengeDao->Read($_GET['chal']);

// Si un utilisateur veut accéder à la page sans être connecté
if(!isset($_SESSION['username'])) {
    header('Location: connexion.php');
    exit();
}

// Teste si le joueur a déjà participé à ce challenge
if($challengeDao->isIn($compte->getUsername(), $challenge->ToString())){
    $url = "partie.php?chal=" . $_GET["chal"];
    Header("Location: $url");
    exit();
}

// Joindre la page de partie
if(isset($_POST["val"])){
    $warning = false;
    for($i=0;$i<$challenge->getDifficulte();$i++){
        
    if(!empty($_POST["n".$i])){

        $code .= intval(htmlentities($_POST["n".$i]));
        
    }else{
        $warning = true;
    }}
        $challengeDao->UpdateParticipants($challenge->ToString(), $compte->getUsername(), $code);
        echo $code;
        
        $url = "partie.php?chal=" . $_GET["chal"];
        Header("Location: $url");
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

                <h1 class="col-md-2 bleu nav-red-border text-center align-self-center py-2"><?= htmlspecialchars($_GET["chal"]) ?></h1>
                
                <h1 class="col-md-2 bleu nav-red-border text-center align-self-center py-2"><?= $compte->toString() ?></h1>

                <a href="accueil.php" class="col-md-2 text-center align-self-center py-2">
                        <button class="btn btn-danger" ><h3>Revenir à l'accueil</h3></button>
                </a>
                
            </div>
        </div>

        <div class="container">
                <div class="row red-border my-3 px-5 py-3">
                        <h1 class="rouge text-center">Rejoindre le challenge </h1>
                
                        <?php if(isset($warning) && $warning) { echo "<div class='alert alert-danger'>Completez tous les champs</div>"; } ?>

                        <form action="code.php?chal=<?= $_GET["chal"] ?>"  method="POST">
                            <div class="row justify-content-around form-group">
                            <?php 
                                        for ($i=0;$i<$challenge->getDifficulte();$i++){
                                            echo'<input class="col-md-1 blue-border" type="number" min="1" max="9" name="n'.$i.'" required>';
                                        }
                                    ?>
                            </div>
                            <div class="row justify-content-center px-5 pt-3">
                                <input class="btn btn-primary" name="val" type="submit" value="Valider">
                            </div>
                        </form>
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
    </body>
</html>