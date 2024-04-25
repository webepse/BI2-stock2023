<?php 
    session_start();
    require "../connexion.php";

    // user Friendly
    if(isset($_SESSION['login']))
    {
        header("LOCATION:dashboard.php");
    }

    // tester si le formulaire a été envoyé (si non, je fais rien donc pas de else)
    if(isset($_POST['login']))
    {
        // tester si le formulaire est bien complet 
        if(empty($_POST['login']) OR empty($_POST['password']))
        {
            // erreur si un des champs est vide 
            $error = "Veuillez remplir le formulaire";
        }else{
            // le formulaire est complet
            // sécurisation des données (ici le login)
            $login = htmlspecialchars($_POST['login']);
            // req à la bdd
            // selectionne tout de la table admin où le login est égal à [ma variable $login]
            $req = $bdd->prepare("SELECT * FROM admin WHERE login=?");
            // execute la req avec la variable login qui va remplacer le ?
            $req->execute([$login]);
            // donne moi la donnée (1 donnée seulement)
            $don = $req->fetch();
            // test si j'ai une donnée ou non 
            if($don)
            {
                // le login existe dans ma bdd 
                // test du password
                if(password_verify($_POST['password'], $don['password']))
                {
                    // tout est bon 
                    // créer une variable de session login qui va me permettre de savoir dans les autres pages si je suis connecté ou non
                    $_SESSION['login']=$login;
                    header("LOCATION:dashboard.php");
                }else{
                    // mot de passe faux 
                    $error = "Votre mot de passe ne correspond pas";
                }
            }else{
                // le login n'existe pas dans la base de données
                $error = "Votre login n'existe pas";
            }
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
    <title>Document</title>
</head>
<body>
    <div class="container-fluid h100">
       <h1>Admin</h1>
       <div class="col-6 offset-3 bg-light p-5">
            <?php
                if(isset($_GET['deco']))
                {
                    echo "<div class='alert alert-success'>Vous êtes bien déconnecté</div>";
                }
            ?>
            <h1>Connexion administration</h1>
            <form action="index.php" method="POST">
                <?php
                    if(isset($error))
                    {
                        echo "<div class='alert alert-danger'>".$error."</div>";
                    }
                ?>
                <div class="form-group my-3">
                    <label for="Login">Login</label>
                    <input type="text" name="login" id="login" class="form-control">
                </div>
                <div class="form-group my-3">
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div class="form-group my-3">
                    <input type="submit" value="Connexion" class="btn btn-primary">
                </div>
            </form>
       </div>
    </div>

</body>
</html>