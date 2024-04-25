<?php 
    session_start();
    if(!isset($_SESSION['login']))
    {
        header("LOCATION:../403.php");
    }

    require "../connexion.php";

    if(isset($_GET['deco']))
    {
        session_destroy();
        header("LOCATION:index.php?deco=success");
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
    <div class="container-fluid h100">
    <div class="row my-5">
        <div class="col-md-4 offset-md-4">
            <h1>Logo du site</h1>
        </div>
    </div>

     <div class="row">
        <div class="col-md-4 text-center bg-dark text-white">
            <div class="row">
                <div class="col-12">Nombre de produits</div>
                <div class="col-12">
                    <?php
                        $prod = $bdd->query("SELECT id FROM products");
                        $countProd = $prod->rowCount();
                        $prod->closeCursor();
                        echo $countProd;
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-center bg-warning text-white">
            <div class="row">
                <div class="col-12">Nombre de message</div>
                <div class="col-12">
                    <?php
                        $contact = $bdd->query("SELECT id FROM contact");
                        $countContact = $contact->rowCount();
                        $contact->closeCursor();
                        echo $countContact;
                    ?>
                </div>
            </div>
        </div>
     </div>
    </div>
    <?php include('partials/footer.php'); ?>
</body>
</html>