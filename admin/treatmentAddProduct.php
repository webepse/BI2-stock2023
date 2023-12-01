<?php
     session_start();
     if(!isset($_SESSION['login']))
     {
         header("LOCATION:../403.php");
     }
 
    //  require "../connexion.php";

    // test si le formulaire a été envoyé
    if(isset($_POST['nom']))
    {
        // traitement de mon formulaire
        $error = 0;
        if(empty($_POST['nom']))
        {
            $error = 1;
        }else{
            $nom = htmlspecialchars($_POST['nom']);
        }

        if(empty($_POST['categorie']))
        {
            $error = 2;
        }else{
            $categorie = htmlspecialchars($_POST['categorie']);
        }

        if(empty($_POST['description']))
        {
            $error = 3;
        }else{
            $description = htmlspecialchars($_POST['description']);
        }

        if(empty($_POST['date']))
        {
            $error = 4;
        }else{
            $date = htmlspecialchars($_POST['date']);
        }

        if(empty($_POST['fichier']))
        {
            $error = 5;
        }else{
            $fichier = htmlspecialchars($_POST['fichier']);
        }

        if(empty($_POST['prix']))
        {
            $error = 6;
        }else{
            $prix = htmlspecialchars($_POST['prix']);
        }


        if($error==0)
        {
            // insertion dans la bdd
        }else{
            // redirection vers le formulaire en indiquant l'erreur
        }


    }else{
        // redirection vers products.php car il n'y a pas de formulaire envoyé
        header("LOCATION:products.php");
    }



?>