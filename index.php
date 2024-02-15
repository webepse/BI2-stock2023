<?php 
    require "connexion.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Document</title>
</head>
<body>
    <div class="container-fluid">
        <h1>hello world</h1>
        
        <div class="row">
            <?php
                $req = $bdd->query("SELECT * FROM products");
                while($don = $req->fetch())
                {
                     echo "<div class='col-md-3'>";
                        echo "<img src='images/".$don['fichier']."' class='img-fluid' />";
                        echo "<div class='title'>".$don['nom']."</div>";
                     echo "</div>";
                }
                $req->closeCursor();

            ?>
        </div>
        <div class="row">
                <div class="col-6 offset-3">
                    <form action="traitement.php" method="POST">
                        <div class="form-group my-3">
                            <label for="nom">Nom: </label>
                            <input type="text" id="nom" name="nom" class="form-control">
                        </div>
                        <div class="form-group my-3">
                            <label for="email">Adresse E-mail: </label>
                            <input type="email" name="email" id="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="sujet">Sujet</label>
                            <select name="sujet" id="sujet" class="form-control">
                                <option value="sujet 1">Sujet 1</option>
                                <option value="sujet 2">Sujet 2</option>
                                <option value="sujet 3">Sujet 3</option>
                                <option value="sujet 4">Sujet 4</option>
                            </select>
                        </div>
                        <div class="form-group my-3">
                            <label for="message">Message: </label>
                            <textarea name="message" id="message" class="form-control"></textarea>
                        </div>
                        <div class="form-group my-3">
                            <input type="submit" value="Envoyer" class="btn btn-success">
                        </div>
                    </form>
                </div>
        </div>

    </div>

</body>
</html>