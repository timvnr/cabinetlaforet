<?php 
require('verif.php'); //il faut executer avant le fichier verif.php qui se connecte lui même à la base de donnée et vérifie si l'utilisateur est connecté
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Page d'accueil</title> <!--Nom de la page-->
        <link rel="stylesheet" type="text/css" href="style.css"/>
        <meta charset="utf-8"/>
    </head>
	<body>
		
        <?php 
            include('header.php'); //on inclue le fichier header.php pour pouvoir avoir le header directement en haut de la page

            //si on appuie sur le bouton déconnexion nommmé "déco"
            if(isset($_POST['déco'])) {

                //on supprime les variables $_SESSION
                unset($_SESSION['login']);
                unset($_SESSION['mdp']);

                //redirection vers la page d'authentification
                header('Location: index.php');
            }
        ?>
        
        <div class="aligne"> 
            <h2>Bienvenue sur le menu</h2>
            <br></br>
            <!--Affichage du formulaire-->
            <form action="bienvenue.php" method="post">
                <br></br>
                <input class="Btndeco" type="submit" value="Déconnexion" name="déco">
            </form>
        </div>

        <?php include('footer.php'); //on inclue le fichier footer.php pour avoir le footer directement en bas de la page?>

	</body>
</html>
