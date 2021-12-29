<?php
session_start();

require_once('classes' . DIRECTORY_SEPARATOR . 'Logic'. DIRECTORY_SEPARATOR .'ConnBdd.php');
require_once('classes' . DIRECTORY_SEPARATOR . 'Logic'. DIRECTORY_SEPARATOR .'Compte.php');
require_once ( "classes" . DIRECTORY_SEPARATOR . "Logic" . DIRECTORY_SEPARATOR . "Joueur.php");
require_once ( "classes" . DIRECTORY_SEPARATOR . "Dao" . DIRECTORY_SEPARATOR . "ChallengeDao.php");
require_once ( "classes" . DIRECTORY_SEPARATOR . "Dao" . DIRECTORY_SEPARATOR . "CompteDao.php");
require_once ( "classes" . DIRECTORY_SEPARATOR . "Logic" . DIRECTORY_SEPARATOR . "Tentative.php");
require_once ( "classes" . DIRECTORY_SEPARATOR . "Dao" . DIRECTORY_SEPARATOR . "EssayerDao.php");
require_once ( "classes" . DIRECTORY_SEPARATOR . "Logic" . DIRECTORY_SEPARATOR . "Reponse.php");


// Set du username
$compteDao = new CompteDao();
$compte = new Joueur();
$compte->setUsername($_SESSION['username']);

// Challenge courant
$challengeDao = new ChallengeDao();
$curChallenge = $challengeDao->Read(htmlentities($_GET['chal']));

// Si un utilisateur veut accéder à la page sans être connecté
if(!isset($_SESSION['username'])) {
    header('Location: connexion.php');
    exit();
}

// Tentative
if(isset($_POST["code"])){
    $adv = $compteDao->DirtyRead($_GET['adv']);
    $code = intval(htmlentities($_POST["n0"]) . htmlentities($_POST["n1"]) . htmlentities($_POST["n2"]) . htmlentities($_POST["n3"]) . htmlentities($_POST["n4"]) . htmlentities($_POST["n5"]));
    $tent = new Tentative($code,$compte,$adv,$curChallenge);
    $reponse = $tent->Tenter();
    $strRep = $reponse->getRep();
    $b=false;
    if(substr_count($strRep, "C")==6){
        $b=true;
    }
    $essaiDao = new EssayerDao();
    $essai = $essaiDao->Create($compte, $adv, $code, $curChallenge,$b);
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

                <h1 class="col-md-2 bleu nav-red-border text-center align-self-center py-2"><?= $curChallenge->ToString() ?></h1>

                <h1 class="col-md-2 bleu nav-red-border text-center align-self-center py-2 pts-ico"><?= $compte->getNbPoints() ?></h1>

                <?php if($curChallenge->getTimeStampRestant() > 0){ ?>
                    <h1 class="col-md-2 bleu text-center align-self-center time-ico"><?= $curChallenge->getTpsRestant()->format('d') . "j, " . $curChallenge->getTpsRestant()->format('H') . "h" . $curChallenge->getTpsRestant()->format('i') ?></h1>
                <?php } else { $url = "resultat.php?chal={$curChallenge->ToString()}"; Header("Location: $url"); exit(); }?>

                <a href="accueil.php" class="col-md-2 text-center align-self-center py-2">
                        <button class="btn btn-danger" ><h3>Revenir à l'accueil</h3></button>
                </a>
            </div>

            <div class="row my-3 justify-content-around">

            <?php if(isset($_GET['adv'])){ ?> 
                <?php
                $essayerDao = new EssayerDao();
                $adve = $compteDao->DirtyRead($_GET['adv']);

                $tentatives = $essayerDao->ListAll($compte, $adve, $curChallenge);
                ?>
                <div class="col-md-5 red-border mx-3">
                    <div class="tab-content" id="v-pills-tabContent">
                            <h2 class="rouge text-center mt-2"><?= htmlentities($_GET['adv']) ?></h2>

                            <hr class="red-hr">

                            
                <?php
                foreach($tentatives as $tentative){
                    $reponse = $tentative->Tenter();
                    $strRep = $reponse->getRep();
                    $code = str_split($tentative->getCode(), 1);
                ?>               
                            <div class="row justify-content-around mb-4">
                                    <h4 class="col-md-2 bleu blue-dot"><?= substr_count($strRep, "C")?></h4>
                                    <h4 class="col-md-2 rouge red-dot"><?= substr_count($strRep, "B") ?></h4>

                                    <h4 class="col-md-1 blue-border blue-border-xs bleu text-center"><?= $code[0] ?></h4>
                                    <h4 class="col-md-1 blue-border blue-border-xs bleu text-center"><?= $code[1] ?></h4>
                                    <h4 class="col-md-1 blue-border blue-border-xs bleu text-center"><?= $code[2] ?></h4>
                                    <h4 class="col-md-1 blue-border blue-border-xs bleu text-center"><?= $code[3] ?></h4>
                                    <h4 class="col-md-1 blue-border blue-border-xs bleu text-center"><?= $code[4] ?></h4>
                                    <h4 class="col-md-1 blue-border blue-border-xs bleu text-center"><?= $code[5] ?></h4>
                            </div>
                <?php if(substr_count($strRep, "C") == 6) {$gagne = true; echo "<p class='bleu'>Bravo vous avez trouvé le code de {$adve->getUsername()}</p>";}?>
                <?php } ?>
                    </div>
                </div>
            <?php } ?>

                <div class="col-md-5 mx-3 adv">
                    <div class="row red-border">
                        <h2 class="bleu text-center mt-2">Adversaires</h2>

                        <div class="row justify-content-around">
                            <hr class="red-hr">
                        </div>

                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <?php
                            $participants = $challengeDao->ListParticipants($_GET["chal"]);
                            $essaiDAO = new EssayerDao();
                            foreach($participants as $participant){
                                if(($participant->getUsername() != $_SESSION["username"])&&(!$essaiDAO->Trouve($compte,$participant))){
                                    $name = $participant->getUsername();
                                    $url = "partie.php?chal=". htmlentities($_GET["chal"]) ."&adv=". htmlentities($name);

                                    echo "<a href='$url' class='nav-link text-center'>$name</a>";



                                    echo "<div class='row justify-content-around'>
                                            <hr class='md-size'>
                                        </div>";
                                }


                            }

                            ?>                   
                        </div>
                    </div>
                    <?php if(isset(htmlentities($_GET['adv']))){ ?> 
                        <div class="row red-border my-3 px-5 py-3">
                            <form action="<?=  "partie.php?chal=". htmlentities($_GET["chal"]) ."&adv=". htmlentities($_GET['adv']) ?>" method="POST">
                                <div class="row justify-content-around form-group">
                                    <input class="col-md-1 blue-border" type="number" min="1" max="9" name="n0" required>
                                    <input class="col-md-1 blue-border" type="number" min="1" max="9" name="n1" required>
                                    <input class="col-md-1 blue-border" type="number" min="1" max="9" name="n2" required>
                                    <input class="col-md-1 blue-border" type="number" min="1" max="9" name="n3" required>
                                    <input class="col-md-1 blue-border" type="number" min="1" max="9" name="n4" required>
                                    <input class="col-md-1 blue-border" type="number" min="1" max="9" name="n5" required>
                                </div>
                                <div class="row justify-content-center px-5 pt-3">
                                    <input class="btn btn-primary" type="submit" value="Valider" name="code">
                                </div>
                            </form>
                        </div>
                    <?php } ?>
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

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>  
    </body>
</html>