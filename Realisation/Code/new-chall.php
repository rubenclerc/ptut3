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

                <h2 class="col-md-1 align-self-center"><a href="#" class="nav-link text-center nav-red-border">Quitter</a></h2>
            </div>

            <div class="container">
                <form action="">
                    <div class="row bleu red-border justify-content-around">
                        <h1 class="text-center my-4">CRÉER UN CHALLENGE</h1>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="challenge-name">NOM:</label>
                                <input type="text" class="form-control blue-border" id="challenge-name">
                            </div>

                            <div class="form-group">
                                <label for="challenge-difficulty">DIFFICULTÉ:</label>
                                <select name="challenge-difficulty" class="form-control blue-border">
                                    <option value="very-easy">Très facile</option>
                                    <option value="easy">Facile</option>
                                    <option value="average">Moyen</option>
                                    <option value="hard">Difficile</option>
                                    <option value="very-hard">Très difficile</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="challenge-date">JOUR:</label>
                                <input type="date" class="form-control blue-border" id="challenge-date">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="challenge-no">PARTICIPANTS:</label>
                                <input type="number" min="2" class="form-control blue-border" id="challenge-no">
                            </div>

                            <div class="form-group">
                                <label for="challenge-dur">DURÉE (EN HEURES):</label>
                                <input type="number" min="1" class="form-control blue-border" id="challenge-dur">
                            </div>

                            <div class="form-group">
                                <label for="challenge-hour">HEURE:</label>
                                <input type="time" class="form-control blue-border" id="challenge-hour">
                            </div>
                        </div>

                        <div class="row justify-content-around">
                            <input type="submit" class="form-control blue-border my-3" id="submitButton" value="VALIDER">
                        </div>
                    </div>
                </form>

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
        </div>
    </body>