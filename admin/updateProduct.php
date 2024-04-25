<?php 
    session_start();
    if(!isset($_SESSION['login']))
    {
        header("LOCATION:../403.php");
    }


    // vérifier ce que je dois modifier 
    if(isset($_GET['id']))
    {
        // protection d'une donnée qui vient de  l'extérieur 
        $id = htmlspecialchars($_GET['id']);
    }else{
        header("LOCATION:products.php");
    }

    // vérifier et récup les info de ce que je dois modifier
    require "../connexion.php";
    $req = $bdd->prepare("SELECT * FROM products WHERE id=?");
    $req->execute([$id]);
    $don = $req->fetch();
    if(!$don)
    {
        $req->closeCursor();
        header("LOCATION:products.php");
    }
    $req->closeCursor();

    // si il y a dans l'url delete
    if(isset($_GET['delete']))
    {
        $idImg= htmlspecialchars($_GET['delete']);
        // vérifier si l'id qu'on m'a donné existe vraiment 
        $reqdel = $bdd->prepare("SELECT * FROM images WHERE id=?");
        $reqdel->execute([$idImg]);
        if(!$dondel = $reqdel->fetch())
        {
            // fermer la requête
            $reqdel->closeCursor();
            // rediriger vers la page product sans delete
            header("LOCATION:updateProduct.php?id=".$id);
        }

        // il y a bien une correspondance donc on ferme la requête
        $reqdel->closeCursor();
        
        // supprimer l'image
        unlink("../images/".$dondel['fichier']);

        

        // supprimer le produit 
        $delete = $bdd->prepare("DELETE FROM images WHERE id=?");
        $delete->execute([$idImg]);
        $delete->closeCursor();
        header("LOCATION:updateProduct.php?id=".$id."&delsuccess=".$idImg);


    }
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
    <div class="container h100">
        <h2>Modifier: <?= $don['nom'] ?></h2>
        <a href="products.php" class='btn btn-secondary'>Retour</a>
        <?php
            if(isset($_GET['error']))
            {
                echo "<div class='alert alert-danger my-3'>Une erreur est survenue (code erreur: ".$_GET['error']." )</div>";
            }
        ?>
        <form action="treatmentUpdateProduct.php?id=<?= $don['id'] ?>" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group my-3">
                        <label for="nom">Nom du produit: </label>
                        
                        <input type="text" id="nom" name="nom" value="<?= $don['nom'];?>" class="form-control">
                    </div>
                    <div class="form-group my-3">
                        <label for="categorie">Catégorie: </label>
                        <select name="categorie" id="categorie" class="form-control">
                            <?php
                                if($don['categorie'] == "categorie1")
                                {
                                    echo '<option value="categorie1" selected>Catégorie 1</option>';
                                    echo '<option value="categorie2">Catégorie 2</option>';
                                    echo '<option value="categorie3">Catégorie 3</option>';
                                }else if($don['categorie'] == "categorie2")
                                {
                                    echo '<option value="categorie1">Catégorie 1</option>';
                                    echo '<option value="categorie2" selected>Catégorie 2</option>';
                                    echo '<option value="categorie3">Catégorie 3</option>';
                                }else{
                                    echo '<option value="categorie1">Catégorie 1</option>';
                                    echo '<option value="categorie2">Catégorie 2</option>';
                                    echo '<option value="categorie3" selected>Catégorie 3</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group my-3">
                        <label for="date">Date: </label>
                        <input type="date" name="date" id="date" class="form-control" value="<?= $don['date'] ?>">
                    </div>
                    <div class="form-group my-3">
                        <label for="description">Description: </label>
                        <textarea name="description" id="description" class="form-control"><?= $don['description'] ?></textarea>
                    </div> 
                </div>
                <div class="col-md-6">
                    <div class="form-group my-3">
                        <div class="col-4">
                            <img src="../images/<?= $don['fichier'] ?>" alt="image de <?= $don['nom'] ?>" class="img-fluid">
                        </div>
                        <label for="fichier">Fichier: </label>
                        <input type="file" name="fichier" id="fichier" class="form-control">
                    </div>
                    <div class="form-group my-3">
                        <label for="prix">Prix: </label>
                        <input type="number" name="prix" id="prix" step="0.01" class="form-control" value="<?= $don['prix'] ?>">
                    </div>
                    <div class="form-group my-3">
                        <input type="submit" value="Modifier" class="btn btn-warning">
                    </div>
                </div>
                <hr>
                <div class="col-md-12">
                    <h1>Galerie images</h1>
                    <?php
                        if(isset($_GET['add']))
                        {
                            echo "<div class='alert alert-success'>Vous avez bien ajouté une image à la galerie</div>";
                        }
                        if(isset($_GET['delsuccess']))
                        {
                            echo "<div class='alert alert-danger'>Vous avez bien supprimé l'image id: ".$_GET['delsuccess']."</div>";
                        }
                    ?>
                    <div class="row">
                        <a href="addGalimg.php?id=<?= $don['id'] ?>" class='btn btn-primary'>Ajouter une image</a>
                        <div class="col-md-8 offset-2">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $gal = $bdd->prepare("SELECT * FROM images WHERE id_produit=?");
                                        $gal->execute([$id]);
                                        // tester si j'ai des images ou non
                                        $count = $gal->rowCount();
                                        if($count > 0)
                                        {
                                            while($donGal = $gal->fetch())
                                            {
                                                echo "<tr>";
                                                    echo "<td>".$donGal['id']."</td>";
                                                    echo "<td><img src='../images/".$donGal['fichier']."' alt='image de galerie ".$don['nom']."' class='col-2 img-fluid'></td>";
                                                    echo "<td>";
                                                        echo "<a href='updateProduct.php?id=".$id."&delete=".$donGal['id']."' class='btn btn-danger'>Supprimer</a>";
                                                    echo "</td>";
                                                echo "</tr>";
                                            }
                                        }else{
                                            echo "<p>Aucune images associées</p>";
                                        }
                                        $gal->closeCursor();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 
        </form>
    </div>
    <?php include('partials/footer.php'); ?>
</body>
</html>





