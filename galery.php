<?php 
    require "connexion.php";
    $mycategories = ["categorie1","categorie2","categorie3"];

    if(isset($_GET['category']))
    {
        if(in_array($_GET['category'],$mycategories))
        {
           $choice = htmlspecialchars($_GET['category']);
        }else{
            $choice = "all";
        }
    }else{
        $choice = "all";
    }


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
        <h1>Galerie</h1>
        <a href="index.php" class="btn btn-secondary my-3">Retour</a>
        <a href="galery.php" class="btn btn-primary mx-2">Tout</a>
        <a href="galery.php?category=categorie1" class="btn btn-primary mx-2">Catégorie 1</a>
        <a href="galery.php?category=categorie2" class="btn btn-primary mx-2">Catégorie 2</a>
        <a href="galery.php?category=categorie3" class="btn btn-primary mx-2">Catégorie 3</a>


        <?php
            if($choice == "all")
            {
                echo "<h1>Toutes les catégories</h1>";
            }else{
                echo "<h1>".$choice."</h1>";
            }

        ?>
        <div class="row">
            <?php
                if($choice == "all")
                {
                    $req = $bdd->query("SELECT * FROM products ORDER BY date DESC");
                    while($don = $req->fetch())
                    {
                        echo "<div class='col-md-3'>";
                            echo "<img src='images/".$don['fichier']."' class='img-fluid' />";
                            echo "<div class='title'>".$don['nom']."</div>";
                            echo "<a href='show.php?id=".$don['id']."' class='btn btn-primary'>Voir plus</a>";
                        echo "</div>";
                    }
                    $req->closeCursor();
                }else{
                    $req = $bdd->prepare("SELECT * FROM products WHERE categorie=? ORDER BY date DESC");
                    $req->execute([$choice]);
                    $count = $req->rowCount();
                    if($count > 0)
                    {
                        while($don = $req->fetch())
                        {
                            echo "<div class='col-md-3'>";
                                echo "<img src='images/".$don['fichier']."' class='img-fluid' />";
                                echo "<div class='title'>".$don['nom']."</div>";
                                echo "<a href='show.php?id=".$don['id']."' class='btn btn-primary'>Voir plus</a>";
                            echo "</div>";
                        }
                        $req->closeCursor();
                    }else{
                        $req->closeCursor();
                        echo "Aucun produit pour cette catégorie";
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>