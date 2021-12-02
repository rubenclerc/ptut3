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

                <h2 class="col-md-1"><a href="#" class="nav-link text-center nav-red-border">Quitter</a></h2>
            </div>
    
            <div class="container">
                <form action="inscription_traitement.php" method="POST" >
                    <div class="container col-md-9">
                        <div class="row bleu red-border justify-content-around">
                            <h1 class="text-center my-4">S'INSCRIRE</h1>
                            <div class="col-md-3">
                                
                                <label for="Identifiant" class="form-label">Identifiant :</label>
                                <input type="text" class="form-control blue-border" name="Identifiant" required="required">
                            
                                <label for="MdP" class="form-label">Mot de passe :</label>
                                <input type="password"  class="form-control blue-border" name="MdP" required="required">
                            
                                <label for="verifMdP" class="form-label">Confirmez mot de passe :</label>
                                <input type="password"  class="form-control blue-border" name="verifMdP" required="required"><br>
                                
                            </div>
                            <div class="row justify-content-around">
                                <input type="submit" class="form-control blue-border my-3" id="submitButtonInscription" value="VALIDER">
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