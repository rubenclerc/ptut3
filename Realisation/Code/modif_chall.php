<?php 
session_start();

require_once ("classes" . DIRECTORY_SEPARATOR . "Logic" . DIRECTORY_SEPARATOR . "ConnBdd.php");
require_once ( "classes" . DIRECTORY_SEPARATOR . "Logic" . DIRECTORY_SEPARATOR . "Admin.php");
require_once ( "classes" . DIRECTORY_SEPARATOR . "Dao" . DIRECTORY_SEPARATOR . "ChallengeDao.php");

if(!isset($_GET['chal'])){
    header('Location:admin.php');
    exit;
}

// Si un utilisateur veut accéder à la page sans être connecté
if(!isset($_SESSION['username'])) {
    header('Location: connexion.php');
    exit();
  }
  
  // Set du username et init challengeDAO
  $compte = new Admin();
  $compte->setUsername($_SESSION['username']);
  $url = "modif_chall.php?chal=".$_GET['chal'];

  $challengeDao = new ChallengeDao();
  $challenge = $challengeDao->ReadId($_GET['chal']);
  $difficultes = array(1=>'Très facile',
  2=>'Facile',
  3=>'Moyen',
  4=>'Difficile',
  5=>'Très difficile',
  6=>'Impossible');

  if (isset($_POST['submit'])){
    $name=$_POST['name'];
    $dif=$_POST['challenge-difficulty'];
    $dd = new DateTime($_POST['dateD']);
    $df = new DateTime($_POST['dateF']);
    $nb=$_POST['nbp'];
    $challenge= new Challenge($name,$dif,$dd,$df,$nb);
    $id=$_GET['chal'];
    $challengeDao->Update($challenge,$id);
    header('Location: admin.php');
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
                <a href="admin.php" class="col-md-2 text-center align-self-center py-2">
                    <form action="admin.php" method="POST">
                            <button type="submit" class="btn btn-danger" name="Quitter"><h3> Quitter </h3></button>
                    </form>
                </a>
               <!-- <h2 class="col-md-1 align-self-center"><a href="#" class="nav-link text-center nav-red-border">Quitter</a></h2>-->
            </div>

            <div class="container">
                <form action="<?php echo $url; ?>" method="POST">
                    <div class="row bleu red-border justify-content-around">
                        <h1 class="text-center my-4">MODIFIER UN CHALLENGE</h1>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="challenge-name">NOM:</label>
                                <input type="text" class="form-control blue-border" id="challenge-name" name="name" value="<?php echo $challenge->toString()?>" required="required">
                            </div>

                            <div class="form-group">
                                <label for="challenge-difficulty">DIFFICULTÉ:</label>
                                <select name="challenge-difficulty" class="form-control blue-border">
                                    <?php foreach($difficultes as $var => $diff) : ?>
                                        <option value="<?php echo $var ?>"<?php if ($var == $challenge->getDifficulte()): ?> selected="selected"<?php endif; ?>><?php echo $diff?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="challenge-date">JOUR debut:</label>
                                <input type="date" class="form-control blue-border" id="challenge-date" name="dateD" value="<?php echo $challenge->getDateDebut()->format('Y-m-d') ?>" required="required">
                            </div>
                            <!--<div class="col-md-3">
                             <div class="form-group">
                                <label for="challenge-date">JOUR fin:</label>
                                <input type="time" class="form-control blue-border" id="challenge-date" name="timeD" required="required">
                                </div>
                                </div>-->
                        </div>

                        <div class="col-md-3">
                             <!--<div class="form-group">
                                <label for="challenge-date">JOUR fin:</label>
                                <input type="time" class="form-control blue-border" id="challenge-date" name="timeF" required="required">
                            </div>-->
                            <div class="form-group">
                                <label for="challenge-date">JOUR fin:</label>
                                <input type="date" class="form-control blue-border" id="challenge-date" name="dateF"  value="<?php echo $challenge->getDateFin()->format('Y-m-d') ?>" required="required">
                            </div>

                            <div class="form-group">
                                <label for="challenge-no">PARTICIPANTS:</label>
                                <input type="number" min="2" class="form-control blue-border" id="challenge-no" name="nbp" value="<?php echo $challenge->getNbPlaces(); ?>" required="required">
                            </div>
                        </div>

                        <div class="row justify-content-around">
                            <input type="submit" class="form-control blue-border my-3" id="submitButton" value="VALIDER" name="submit">
                        </div>
                    </div>
                </form>

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
        </div>
    </body>