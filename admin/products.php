<?php 
    session_start();
    if(!isset($_SESSION['login']))
    {
        header("LOCATION:../403.php");
    }

    require "../connexion.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <title>Document</title>
</head>
<body>
    <?php
        include("partials/header.php");
    ?>
    <div class="container-fluid">
     <h2>Gestion des produits</h2>
     <a href="addProduct.php" class="btn btn-primary">Ajouter un produit</a>
     <?php 
        if(isset($_GET['add']))
        {
            echo "<div class='alert alert-success'>Vous avez bien ajouté un produit à votre base de données</div>";
        }
    ?>
     <table class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nom</th>
                <th>Catégorie</th>
                <th>Prix</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $req = $bdd->query("SELECT * FROM products");
                while($don = $req->fetch())
                {
                    echo "<tr>";
                        echo "<td>".$don['id']."</td>";
                        echo "<td>".$don['nom']."</td>";
                        echo "<td>".$don['categorie']."</td>";
                        echo "<td>".$don['prix']."</td>";
                        echo "<td>";
                            echo "<a href='#' class='btn btn-warning'>Modifier</a>";
                            echo "<a href='#' class='btn btn-danger'>Supprimer</a>";
                        echo "</td>";
                    echo "</tr>";
                }
                $req->closeCursor();
            ?>
        </tbody>
     </table>
    </div>
    <?php include('partials/footer.php'); ?>
</body>
</html>