<?php 
    session_start();
    // sécurité
    if(!isset($_SESSION['login']))
    {
        header("LOCATION:../403.php");
    }

    // connexion à la bdd
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
    <title>Administration - Contact</title>
</head>
<body>
    <?php
        include("partials/header.php");
    ?>
    <div class="container-fluid">
     <h2>Gestion des produits</h2>
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
                            echo "<a href='#' class='btn btn-danger ms-2'>Supprimer</a>";
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