<?php 

if(isset($_POST['nom']))
{

    // vérifier les données
    $err=0;
    if(empty($_POST['nom']))
    {
        $err=1;
    }else{
        $nom = htmlspecialchars($_POST['nom']);
    }

    if(empty($_POST['email']))
    {
        $err=2;
    }else{
        $email = htmlspecialchars($_POST['email']);
    }

    if(empty($_POST['sujet']))
    {
        $err=3;
    }else{
        $sujet = htmlspecialchars($_POST['sujet']);
    }

    if(empty($_POST['message']))
    {
        $err=4;
    }else{
        $message = htmlspecialchars($_POST['message']);
    }

    if($err==0)
    {
        require "connexion.php";
        $insert = $bdd->prepare("INSERT INTO contact(nom,email,sujet,message,date) VALUES(:nom,:email,:sujet,:message,NOW())");
        $insert->execute([
            ":nom" => $nom,
            ":email" => $email,
            ":sujet" => $sujet,
            ":message" => $message
        ]);
        $insert->closeCursor();
        header("LOCATION:index.php?message=success");
    }else{
        header("LOCATION:index.php?error=".$err);
    }


}else{
    header("LOCATION:index.php");
}


?>