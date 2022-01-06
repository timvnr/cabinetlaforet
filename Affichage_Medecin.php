<?php 
require('verif.php'); //il faut executer avant le fichier verif.php qui se connecte lui même à la base de donnée et vérifie si l'utilisateur est connecté
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Page d'affichage des médecins </title>
        <link rel="stylesheet" type="text/css" href="style.css"/>
        <meta charset="utf-8"/> 
	</head>
	<body>

        <?php include('header.php'); //on inclue le header dans la page actuelle?>

		<h2 class="bleu">Affichage des médecins</h2>

        <?php
            
            //Requête pour accéder à toutes les valeurs de la table "medecin" de la base de données
            $res = $linkpdo->query("SELECT * FROM medecin");  

            //Affichage d'un tableau vide avec différentes colonnes (ici Civilité/Nom/Prénom) 
            echo "<table border='1' width=32% class='table'>
                <tr bgcolor='grey'>
                    <th>Civilité</th>
                    
                    <th>Nom</th>
					
                    <th>Prénom</th>
					
                    <th>Modifier</th>
					
                    <th>Supprimer</th>
                </tr>";

                //Remplissage de chaque ligne du tableau avec pour chaque ligne les informations d'un médecin (Civilité/Nom/Prénom)
                while ($data = $res->fetch()) {
                    echo "<tr><td>".$data[1]."</td><td>".$data[2]."</td><td>".$data[3]."</td><td> <a href='Modification_Medecins.php?idM=$data[0]'>Modifier</a></td><td> <a href='Page_Suppression.php?idM=$data[0]'>Supprimer</a></td></tr>";
                }

            echo "</table>";

            //Si l'utilisateur appuie sur le bouton nommé "menu"...
            if(isset($_POST['menu'])) {

                //Redirection vers le menu du site 
                header('Location: bienvenue.php');
            }

            //Si l'utilisateur appuie sur le bouton nommé "ajout" (dans ce cas pour ajouter un médecin)...
            if(isset($_POST['ajout'])) {

                //Redirection vers la page pour ajouter un médecin
                header('Location: Ajout_Medecin.php');
            }
                    
        ?>

        <!--Formulaire pour afficher les 2 boutons : ajout / menu (pour ajouter un médecin ou revenir au menu)-->
        <form action="Affichage_Medecin.php" method="post">
            <br></br>
            <p><input class="survolVert" type="submit" value="Ajouter un médecins" name="ajout" /> <input class="survolBleu" type="submit" value="Retour au menu" name="menu"> </p>
        </form>
    </body>

    <?php include('footer.php');    //On inclue le footer dans la page actuelle en appelant le fichier "footer.php"?>
</html>
