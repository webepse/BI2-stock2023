<?php
    // vérifier si j'ai un id ou non
    if(isset($_GET['id']))
    {
        // protection
        $id = htmlspecialchars($_GET['id']);
    }else{
        header("LOCATION:404.php");
    }

    // vérifier que l'id existe bien dans ma bdd 
    require "connexion.php";
    $req = $bdd->prepare("SELECT * FROM products WHERE id=?");
    $req->execute([$id]);
    $don = $req->fetch();
    $req->closeCursor();
    if(!$don)
    {
        header("LOCATION:404.php");
    }
    
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <a href="index.php" class='btn btn-secondary my-3'>Retour</a>
        <h1><?= $don['nom'] ?></h1>
        <h4><?= $don['categorie'] ?></h4>
        <h5><?= $don['date'] ?></h5>
        <div class="col-4">
            <img src="images/<?= $don['fichier'] ?>" alt="image de <?= $don['nom'] ?>" class="img-fluid">
        </div>
        <h4>Description</h4>
        <div class="mb-3"><?= nl2br($don['description']) ?></div>
        <div><strong>Prix:</strong> <?= $don['prix'] ?>€</div>
        <h2 class="my-3">Galerie Image</h2>
        <div class="row">

        <div id="carouselExample" class="carousel slid">
            <div class="carousel-inner">
                <?php 
                    $gal = $bdd->prepare("SELECT * FROM images WHERE id_produit=?");
                    $gal->execute([$id]);
                    // tester si j'ai des images ou non
                    $count = $gal->rowCount();
                    if($count > 0)
                    {
                        while($donGal = $gal->fetch())
                        {
                            echo "<div class='carousel-item active'>";  
                                echo "<img src='images/".$donGal['fichier']."' alt='image de galerie ".$don['nom']."' class='d-block w-100'>";
                            echo "</div>";
                        }
                    }else{
                        echo "<p>Aucune images associées</p>";
                    }
                    $gal->closeCursor();

                ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
           
        </div>
    </div>
</body>
</html>