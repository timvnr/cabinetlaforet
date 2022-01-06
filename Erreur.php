<!DOCTYPE HTML>
<html>
	<head>
		<title>Page erreur de connexion</title> 		<!--Nom de la page-->
        <link rel="stylesheet" type="text/css" href="style.css"/> 	<!--Liaison au fichier css-->
        <meta charset="utf-8"/>						<!--Prendre en compte les accents-->
	</head>
	<body> 
	
	<?php 
		//On inclue le header dans la page en appelant le fichier "header.php"
		require('header.php');
	?>

	<div class="aligne">
		<h3>Identifiant ou mot de passe invalide !</h3>
		<p>Veuillez réessayer</p>

		<!--Formulaire avec un bouton pour retourner à la page d'authentification-->
		<form action="index.php" method="post">
			<input class="survolBleu" type="submit" value="Ok" name="ok">
		</form>
	</div>

	<?php 
		//On inclue le footer dans la page en appelant le fichier "footer.php"
		require('footer.php');	
	?>

	</body>
</html>
