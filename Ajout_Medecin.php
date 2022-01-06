<?php
require('verif.php'); //il faut executer avant le fichier verif.php qui se connecte lui même à la base de donnée et vérifie si l'utilisateur est connecté
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Page d'ajout d'un médecin </title>
        <link rel="stylesheet" type="text/css" href="style.css"/>
        <meta charset="utf-8"/>
	</head>
	<body>

    <?php

		//On inclue le header dans la page actuelle
		require('header.php');

		//Dans le cas ou l'utilisateur appuie sur le bouton nommé "Ajouter"
		//Donc s'il veut ajouter un nouveau médecin
		if(isset($_POST['Ajouter'])) {

			//Stockage des valeurs saisies par l'utilisateur dans le formulaire dans des variables
			$id = $_POST['id_medecin'];
			$civilite = $_POST['civilite'];
			$nom = $_POST['nom'];
			$prenom = $_POST['prenom'];

			//Requête pour rechercher l'id d'un médecin (idM) à partir de son nom et de son prénom
			$res2 = $linkpdo->prepare("SELECT idM FROM medecin WHERE nom=:nom and prenom=:prenom");
			$res2 -> execute(array('nom' => $nom, 'prenom' => $prenom));
			$data = $res2->fetch();
			echo "$data['idM']";

			//Si le médecin n'existe pas dans la base de données, on l'ajoute avec la requete ci-dessous
			if($data['idM']==null) {

				//Requête pour ajouter un médecin dans la base de données à partir des informations saisies par l'utilisateur
				$res = $linkpdo->prepare("INSERT INTO medecin(idM, civilite, nom, prenom) VALUES('$id', '$civilite', '$nom', '$prenom')");
				$res -> execute(array('id' => $id, 'civilite' => $civilite,'nom' => $nom, 'prenom' => $prenom));
				var_dump($res);
				//Redirection vers la page d'affichage des médecins
				header('Location: Affichage_Medecin.php');
			}
		}

		//Si l'utilisateur appuie sur le bouton nommé "Annuler"
		if(isset($_POST['Annuler'])) {

			//Redirection vers la page d'affichage des médecins
			header('Location: Affichage_Medecin.php');
		}

    ?>

	<div class="aligne">
		<h2>Page ajout médecin</h2>

		<!--Affichage du formulaire d'ajout d'un médecin-->
		<form action="Ajout_Medecin.php" method="post">
				<p><input type="hidden" name="id_medecin"/></p>
				<p>Civilité         <input type="text" name="civilite"/></p>
				<p>Nom         <input type="text" name="nom"/></p>
				<p>Prénom      <input type="text" name="prenom"/></p>

				<p><input class="survolVert" type="submit" value="Ajouter" name="Ajouter"> <input class="survolRouge" type="submit" value="Annuler" name="Annuler"></p>
		</form>
	</div>

	<?php
		//On inclue le footer dans la page en appelant le fichier "footer.php"
		require('footer.php');
	?>

	</body>
</html>
