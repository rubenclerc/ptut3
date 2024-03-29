<?PHP 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentions légales</title>

    <link rel="icon" href="pictures/logo.png">

        <!-- CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="styles/styles.css">

    </head>

    <body>
        <div class="container-fluid">
            <div class="row my-3 justify-content-between">
                <img class="col-md-2" src="pictures/logoEcrit.png" alt="Logo Mindmaster" id="navLogo">

                <a href="connexion.php" class="col-md-2 text-center align-self-center py-2">
                    <form action="accueil.php" method="POST">
                            <button type="submit" class="btn btn-danger" name="deconnexion"><h3> Se déconnecter </h3></button>
                    </form>
                </a>
            </div>
            
            <div class="container-fluid">
        <h2>Mentions légales</h2>
            <p>En vertu de l'article 6 de la loi n° 2004-575 du 21 juin 2004 pour la confiance dans l'économie numérique, il est précisé aux utilisateurs du site internet <a href="https://www.MindMaster.com">https://www.MindMaster.com</a> l'identité des différents intervenants dans le cadre de sa réalisation et de son suivi:
            </p><p><strong>Propriétaire</strong> :  SARL Koala Prod Capital social de 0€  – 7 Bd Dr Petitjean 21078 Dijon<br>                       
            <strong>Responsable publication</strong> : Koala Prod – 06 00 00 00 00<br>
            Le responsable publication est une personne physique ou une personne morale.<br>
            <strong>Webmaster</strong> : Alexis NICOLAS – 0600000000<br>
            <strong>Hébergeur</strong> : Gemalin – 12-14 Rond Point des Champs Elysées 75008 Paris 0 811 88 77 66<br>
            <strong>Délégué à la protection des données</strong> : Koala Prod – Koala_Prod@Gemalin.com<br>
            </p>
            </div>
    </body>
</html>