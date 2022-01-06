<?php 
require('verif.php'); //il faut executer avant le fichier verif.php qui se connecte lui même à la base de donnée et vérifie si l'utilisateur est connecté
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Page d'ajout d'un usagers </title>
		<link rel="stylesheet" type="text/css" href="style.css"/>
        <meta charset="utf-8"/>
	</head>
	<body>
		
    <?php 
		
		//on inclue le header dans la page 
		require('header.php');
		
		//si l'utilisateur appuie sur le bouton nommé "Ajouter"
		if(isset($_POST['Ajouter'])) {
			
			//on stocke dans des variables les valeurs entrées dans le formulaire par l'utilisateur
			$id = $_POST['id_usager'];
			$civilite = $_POST['civilite'];
			$nom = $_POST['nom'];
			$prenom = $_POST['prenom'];
			$adresse = $_POST['adresse'];
			$code = $_POST['code'];
			$dateN = $_POST['dateN'];
			$lieuN = $_POST['lieuN'];
			$numS = $_POST['numS'];
			$nomM = $_POST['nom_medecin'];
			
			//récupérer l'id du médecin à partir de son nom (récupération de l'idM)
			$res3 = $linkpdo->query("SELECT idM FROM medecin WHERE nom='$nomM'");
			var_dump($res3);
			$data1 = $res3->fetch();
			$idM = $data1['idM'];

			//requete pour avoir l'idU (id du patient) à partir de son nom et prénom
			$res2 = $linkpdo->query("SELECT idU FROM usager WHERE nom='$nom' and prenom='$prenom'");
			var_dump($res2);
			$data = $res2->fetch();
			
			if($data['idU']==null) {
				$res = $linkpdo->exec("INSERT INTO usager(idU, civilite, nom, prenom, adresse, codeP, dateN, lieuN, numS, idM) VALUES('$id', '$civilite', '$nom', '$prenom', '$adresse', '$code', '$dateN', '$lieuN', '$numS', '$idM')");
				var_dump($res);
			}

			//redirection vers la page d'affichage des patients (usagers)
			//header('Location: Affichage_Usagers.php');
			
		} 

		//Si l'utilisateur appuie sur le bouton "Annuler"...
		if(isset($_POST['Annuler'])) {

			//Redirection vers la page d'affichage des patients / usagers
			header('Location: Affichage_Usagers.php');
		}
		 
    ?> 

	<div class="aligneSpecial">
		<h2>Page ajout usager</h2>

		<!--Affichage du formulaire d'ajout d'un patient-->
		<form action="Ajout_Usagers.php" method="post">
				<p><input type="hidden" name="id_usager"/></p>
				<p>Civilité         <input type="text" name="civilite"/></p>
				<p>Nom         <input type="text" name="nom"/></p>
				<p>Prénom      <input type="text" name="prenom"/></p>
				<p>Adresse      <input type="text" name="adresse"/></p>
				<p>Code postal  <input type="number" name="code"/></p>
				<p>Date de naissance        <input type="date" name="dateN"/></p>
				<p>Lieu de naissance    <input type="text" name="lieuN"/></p>
				<p>Numéro de sécurité social    <input type="text" name="numS"/></p>
				<p>Nom médecin référent   <input type="text" name="nom_medecin"/></p>
				
				<p><input class="survolVert" type="submit" value="Ajouter" name="Ajouter"> <input class="survolRouge" type="submit" value="Annuler" name="Annuler"></p>
		</form>
	</div>

	<?php require('footer.php');	//On inclue le footer dans la page actuelle en appelant le fichier "footer.php"?>

	</body>
</html>
