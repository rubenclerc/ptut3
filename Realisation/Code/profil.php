<?php
session_start();
require_once ( "classes" . DIRECTORY_SEPARATOR . "Logic" . DIRECTORY_SEPARATOR . "Joueur.php");
require_once ( "classes" . DIRECTORY_SEPARATOR . "Dao" . DIRECTORY_SEPARATOR . "CompteDao.php");

// Si un utilisateur veut accéder à la page sans être connecté
if(!isset($_SESSION['username'])) {
    header('Location: connexion.php');
    exit();
}

// Initialisation
$compteDao = new CompteDao();
$compte = $compteDao->DirtyRead($_SESSION['username']);

if(isset($_POST['modifier'])){
    $compte->setUsername( htmlentities($_POST['username']));
    $compte->setPassHash( htmlentities($_POST['password']));

    $compteDao->update($compte);

    $reussi = true;
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
                <a href="connexion.php" class="col-md-2 text-center align-self-center py-2">
                    <button class="btn btn-danger"><h3>Revenir à l'acceuil</h3></button>
                </a>
            </div>
        
        <div class="container">
                <form action="profil.php" method="POST">
                    <div class="container col-md-9">
                        <div class="row bleu red-border justify-content-around">
                            <h3 class="text-center my-4">PROFIL</h3>
                            <div class="col-md-3">
                            <?php
                                    if(isset($reussi) && $reussi){
                                        echo '<div class="alert alert-success px-5">
                                                Enregistrement réussi !
                                            </div>';
                                    }
                                ?>

                                <div class="form-group">
                                    <label for="username" class="form-label">Identifiant :</label>
                                    <input name="username" type="text" class="form-control blue-border" placeholder="Identifiant" required="required" value="<?= $compte->getUsername() ?>">
                                    <a class="form-text text-muted">Changer son identifiant</a>                                
                                </div>
                                <div class="form-group">
                                    <label for="password" class="form-label">Mot de passe :</label>
                                    <input type="password" name="password" class="form-control blue-border" placeholder="********" required="required">
                                    <a class="form-text text-muted">Changer son mot de passe</a>
                                </div>

                                <div class="form-group">
                                    <input type="submit" name="modifier" class="btn btn-primary form-control mt-3" value="Modifier les informations">
                                </div>
                            </div>
                            <p>
                            <hr>
                            <h3 class="text-center my-4">STATISTIQUES</h3>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="NbPartie">Nombre de parties :</label>
                                    <input type="text"  class="form-control blue-border" id="NbPartie" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="NbPoints">Nombre de points :</label>
                                    <input type="text"  class="form-control blue-border" id="NbPoints" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="NbVictoires">Nombre de Victoires : </label>
                                    <input type="text"  class="form-control blue-border" id="NbVictoires" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="Nbdcouvertes">Nombre de decouvertes :</label>
                                    <input type="text"  class="form-control blue-border" id="Nbdcouvertes" disabled>
                                </div>
                            </div>
                            <p>
                        </div>
                    </div>
                    <p>
                </form>
        </div>
        <div>                
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