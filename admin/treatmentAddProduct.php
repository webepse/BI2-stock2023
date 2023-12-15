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

        if(empty($_POST['prix']))
        {
            $error = 6;
        }else{
            $prix = htmlspecialchars($_POST['prix']);
        }


        if($error==0)
        {
              // ok - traitement du ou des fichier(s)
            $dossier = "../images/"; // ../images/monfichier.jpg
            $fichier = basename($_FILES['fichier']['name']);
            $taille_maxi = 2000000;
            $taille = filesize($_FILES['fichier']['tmp_name']);
            $extensions = ['.png','.jpg','.jpeg', '.gif'];
            $extension = strrchr($_FILES['fichier']['name'],'.');

            if(!in_array($extension, $extensions))
            {
                $error = 2;
            }
            
            if($taille>$taille_maxi){
                $error = 3;
            }

            // test si le fichier correspond à nos attentes
            if($error == 0)
            {
                $fichier = strtr($fichier, 
                'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
                'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                $fichier = preg_replace('/([^.a-z0-9]+)/i','-',$fichier); 
                $fichiercptl = rand().$fichier; 

                if(move_uploaded_file($_FILES['fichier']['tmp_name'], $dossier.$fichiercptl))
                {
                    // insertion dans la bdd
                    require "../connexion.php";
                    $insert = $bdd->prepare("INSERT INTO products(nom,categorie,fichier,description,date,prix) VALUES(?,?,?,?,?,?)");
                    $insert->execute([$nom,$categorie,$fichiercptl,$description,$date,$prix]);
                    $insert->closeCursor();
                    header("LOCATION:products.php?add=success");
                }else{
                    header("LOCATION:addProduct.php?errorimg=4");
                }

            }else{
                header("LOCATION:addProduct.php?errorimg=".$error);
            }


            
        }else{
            // redirection vers le formulaire en indiquant l'erreur
            header("LOCATION:addProduct.php?error=".$error);
        }


    }else{
        // redirection vers products.php car il n'y a pas de formulaire envoyé
        header("LOCATION:products.php");
    }



?>