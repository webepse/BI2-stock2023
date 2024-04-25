<?php 
    session_start();
    // sécurité
    if(!isset($_SESSION['login']))
    {
        header("LOCATION:../403.php");
    }

    // connexion à la bdd
    require "../connexion.php";

    if(isset($_GET['delete']))
    {
        // vérifier si l'id correspond bien 
        $verif = $bdd->prepare("SELECT * FROM contact WHERE id=?");
        $verif->execute([$_GET['delete']]);
        $donVerif = $verif->fetch();
        $verif->closeCursor();
        if(!$donVerif)
        {
            header('LOCATION:contact.php?delerror='.$_GET['delete']);
        }else{
            // je peux supprimer le message 
            $delete = $bdd->prepare("DELETE FROM contact WHERE id=?");
            $delete->execute([$_GET['delete']]);
            $delete->closeCursor();
            header("LOCATION:contact.php?delsuccess=".$_GET['delete']);
        }
   


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
    <title>Administration - Contact</title>
</head>
<body>
    <?php
        include("partials/header.php");
    ?>
    <div class="container-fluid h100">
     <h2>Gestion des contact</h2>
    <?php
        if(isset($_GET['delerror']))
        {
            echo "<div class='alert alert-danger'>Une erreur est survenue lors de la suppression de l'id: ".$_GET['delerror']."</div>";
        }

        if(isset($_GET['delsuccess']))
        {
            echo "<div class='alert alert-success'>le message id n°".$_GET['delsuccess']." a bien été supprimé</div>";
        }



    ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $contacts = $bdd->query("SELECT id, nom, email, DATE_FORMAT(date, '%d/%m/%Y %hh%i') AS mydate FROM contact ORDER BY date DESC");
                while($donContact = $contacts->fetch())
                {
                    echo "<tr>";
                        echo "<td>".$donContact['id']."</td>";
                        echo "<td>".$donContact['nom']."</td>";
                        echo "<td>".$donContact['email']."</td>";
                        echo "<td>".$donContact['mydate']."</td>";
                        echo "<td>";
                            echo "<a href='showContact.php?id=".$donContact['id']."' class='btn btn-success'>Afficher</a>";
                            echo "<a href='contact.php?delete=".$donContact['id']."' class='btn btn-danger ms-2'>Supprimer</a>";
                        echo "</td>";
                    echo "</tr>";
                }
                $contacts->closeCursor();
            ?>
        </tbody>
    </table>


    </div>
    <?php 
        include("partials/footer.php");
    ?>
</body>
</html>