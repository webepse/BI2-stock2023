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

    if(!empty($_FILES['image']['tmp_name']))
    {
         // vérifier le nouveau fichier
        // ok - traitement du ou des fichier(s)
        $dossier = "../images/"; // ../images/monfichier.jpg
        $fichier = basename($_FILES['image']['name']);
        $taille_maxi = 2000000;
        $taille = filesize($_FILES['image']['tmp_name']);
        $extensions = ['.png','.jpg','.jpeg', '.gif'];
        $extension = strrchr($_FILES['image']['name'],'.');
        $err= 0;
        if(!in_array($extension, $extensions))
        {
            $err = 2;
        }
        
        if($taille>$taille_maxi){
            $err = 3;
        }

        if($err == 0)
        {
            $fichier = strtr($fichier, 
            'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
            'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
            $fichier = preg_replace('/([^.a-z0-9]+)/i','-',$fichier); 
            $fichiercptl = rand().$fichier; 

            if(move_uploaded_file($_FILES['image']['tmp_name'], $dossier.$fichiercptl))
            {
                $insert = $bdd->prepare("INSERT INTO images(fichier, id_produit) VALUES(:img, :prod)");
                $insert->execute([
                    ":img"=> $fichiercptl,
                    ":prod"=> $idProduct
                ]);
                $insert->closeCursor();
                header("LOCATION:updateProduct.php?id=".$idProduct."&add=success");
            }else{
                header("LOCATION:addGalimg.php?id=".$idProduct."&error=4");
            }

           

        }else{
            header("LOCATION:addGalimg.php?id=".$idProduct."&error=".$err);
        }

    }else{
        header("LOCATION:addGalimg.php?id=".$idProduct."&error=1");
    }
?>