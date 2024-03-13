<?php
    session_start();
    if(!isset($_SESSION['login']))
    {
        header("LOCATION:../403.php");
    }

      // vérifier à qui je dois ajouter une image
      if(isset($_GET['id']))
      {
          // protection d'une donnée qui vient de  l'extérieur 
          $idProduct = htmlspecialchars($_GET['id']);
      }else{
          header("LOCATION:products.php");
      }

      // vérifier et récup les info de ce que je dois afficher
        require "../connexion.php";
        $req = $bdd->prepare("SELECT * FROM products WHERE id=?");
        $req->execute([$idProduct]);
        $don = $req->fetch();
        if(!$don)
        {
            $req->closeCursor();
            header("LOCATION:products.php");
        }
        $req->closeCursor();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <title>Admin - Ajouter une image à <?= $don['nom'] ?></title>
</head>
<body>
    <?php
        include("partials/header.php");
    ?>
    <div class="container slide">
        <h1>Ajouter une image à <?= $don['nom'] ?></h1>
        <?php 
            if(isset($_GET['error']))
            {
                echo "<div class='alert alert-danger'>Une erreur est survenue (code erreur: ".$_GET['error']." )</div>";
            }
        ?>
        <form action="treatmentAddImg.php?id=<?= $idProduct ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="image">Ajouter une image:</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>
            <div class="form-group">
                <input type="submit" value="Ajouter" class="btn btn-primary my-3">
            </div>
        </form>

    </div>
    <?php include('partials/footer.php'); ?>
  
</body>
</html>