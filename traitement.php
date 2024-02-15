<?php 
// mon formulaire a été envoyé ou non
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

    // s'il y a eu une erreur dans le formulaire -> oui ou non
    if($err==0)
    {
        // pas d'erreur -> insertion dans la base de données
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
        // redirige vers le formulaire avec l'erreur en GET
        header("LOCATION:index.php?error=".$err);
    }


}else{
    // tu ne viens pas de mon formulaire -> redirection
    header("LOCATION:index.php");
}


?>