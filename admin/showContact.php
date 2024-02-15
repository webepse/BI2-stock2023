<?php 
    session_start();
    if(!isset($_SESSION['login']))
    {
        header("LOCATION:../403.php");
    }

    // vérifier ce que je dois afficher 
    if(isset($_GET['id']))
    {
        // protection d'une donnée qui vient de  l'extérieur 
        $id = htmlspecialchars($_GET['id']);
    }else{
        header("LOCATION:contact.php");
    }

    // vérifier et récup les info de ce que je dois afficher
    require "../connexion.php";
    $req = $bdd->prepare("SELECT id,nom,sujet,email,message, DATE_FORMAT(date,'%d/%m/%Y %hh%i' ) AS mydate FROM contact WHERE id=?");
    $req->execute([$id]);
    $don = $req->fetch();
    if(!$don)
    {
        $req->closeCursor();
        header("LOCATION:contact.php");
    }
    $req->closeCursor();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <title>Admin - contact de <?= $don['nom'] ?></title>
</head>
<body>
    <?php 
        // insertion du header
        include("partials/header.php");
    ?>
    <div class="container">
        <h2>Message de <?= $don['nom'] ?></h2>
        <h5>Envoyé le <?= $don['mydate'] ?></h5>
    </div>
    <?php 
        // insertion du footer
        include("partials/footer.php");
    ?>
</body>
</html>