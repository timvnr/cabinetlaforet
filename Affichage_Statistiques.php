<?php
require('verif.php'); //il faut executer avant le fichier "verif.php" qui se connecte lui même à la base de donnée et vérifie si l'utilisateur est connecté (l'utilisateur a entré un login / mot de passe)
?>
<!DOCTYPE HTML>
	<html>
		<head>
			<title>statistiques</title>
			<link rel="stylesheet" type="text/css" href="style.css"/>
        	<meta charset="utf-8"/>
		</head>
		<body>
				<?php
					//On inclue le header dans la page actuelle en appelant le fichier "header.php"
					include('header.php');
				?>

				<h2 class="bleu">Statistiques </h2>

				<!--Première partie qui est à propos des patients-->
				<h3>A propos des patients </h3>

				<?php
					$pass = 0;
					$libelle = "erreur";
				?>

				<!-- creation du tableau -->
				<table border='1' width=30% class='table'>
					<tr bgcolor='grey'>
						<th> Tranche d'age </th>
						<th> Nombre d'hommes </th>
						<th> Nombre de femmes </th>
					</tr>

					<?php
						// boucle pour les 3 lignes du tableau
						while($pass != 3){

							//affichage des moins de 25ans
							if ($pass == 0){
								//requete qui retourne le nombre d'usager de sexe M ou F de moins de 25 ans
								$res = $linkpdo->query("SELECT count(idU) from usager where datediff(curdate(), usager.dateN)/365.25 < 25 and civilite = 'M' group by civilite");
								$result = $linkpdo->query("SELECT count(idU) from usager where datediff(curdate(), usager.dateN)/365.25 < 25 and civilite = 'F' group by civilite");
								if ($res == false || $result == false){
									echo 'il y a probleme methode query 1';
								}
								$libelle = "Moins de 25 ans";

							//affichage des usagers entre 25 et 50ans
							}elseif ($pass == 1) {
								//requete qui retourne le nombre d'usager de sexe M ou F entre 25 et 50 ans
								$res = $linkpdo->query("SELECT count(usager.idU) from usager where datediff(curdate(), usager.dateN)/365.25 > 25 and datediff(curdate(), usager.dateN)/365.25 < 50 and usager.civilite = 'M' group by usager.civilite");
								$result = $linkpdo->query("SELECT count(usager.idU) from usager where datediff(curdate(), usager.dateN)/365.25 > 25 and datediff(curdate(), usager.dateN)/365.25 < 50 and usager.civilite = 'F' group by usager.civilite");
								if ($res == false || $result == false){
									echo 'il y a probleme methode query 2';
								}
								$libelle = "Entre 25 et 50 ans";

							//affichage des plus de 50ans
							}elseif ($pass == 2) {
								//requete qui retourne le nombre d'usager de sexe M ou F de plus de 50 ans
								$res = $linkpdo->query("SELECT count(usager.idU) from usager where datediff(curdate(), usager.dateN)/365.25 > 50 and usager.civilite like 'M' group by usager.civilite");
								$result = $linkpdo->query("SELECT count(usager.idU) from usager where datediff(curdate(), usager.dateN)/365.25 > 50 and usager.civilite like 'F' group by usager.civilite");
								if ($res == false || $result ==false){
									echo 'il y a probleme methode query';
								}
								$libelle = "Plus de 50 ans";
							}

							//Affichage des hommes dans les différentes tranches d'ages
							while ($data = $res->fetch()) {
								echo '<tr><td>'.$libelle.'</td><td>'.$data[0].'</td>';
							}
							//Affichage des femmes dans les différentes tranches d'age
							while ($data2 = $result->fetch()) {
								echo '<td>'.$data2[0].'</td></tr>';
							}

							//compteur pour effectuer toutes les tranches d'ages
							$pass += 1;
						}


						// duree totale des consulations effectuee par chaque medecin
					?>

				</table >

				<br></br>
				<h3>Nombre d'heures par médecin</h3>
				<table border='1' width=30% class='table'>
					<tr bgcolor='grey'>
						<th> Nom du medecin </th>
						<th> Nombres d'heures effectuées </th>
					</tr>

					<?php
						//requete qui retourne la somme des durees des rendez-vous par medecin
						$res = $linkpdo->query("SELECT distinct medecin.nom, sum(time_to_sec(rendezvous.duree)) from rendezvous, medecin where rendezvous.idM = medecin.idM group by medecin.nom");
						if ($res == false){
							echo 'il y a probleme methode query medecin';
						}
						//boucle pour afficher le resulat et le convertir au prealable
						while ($data = $res->fetch()) {
							$tmp = ($data[1]/3600);
							echo '<tr><td>'.$data[0].'</td><td>'.$tmp.'</td></tr>';
						}
					?>
				</table>

				<?php
	 				///Fermeture du curseur d'analyse des résultats
	 				$res->closeCursor();
	 			?>

				<!--Formulaire pour afficher un bouton pour revenir au menu-->
				<form action="bienvenue.php" method="post">
            		<br></br>
            		<input class="survolBleu" type="submit" value="Retour au menu" name="menu" />
        		</form>

				<?php
					//On inclue le footer dans la page en appelant le fichier "footer.php"
					include('footer.php');
				?>
		</body>
</html>
