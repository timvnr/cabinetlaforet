<?php 
require('verif.php'); //il faut executer avant le fichier verif.php qui se connecte lui même à la base de donnée et vérifie si l'utilisateur est connecté
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Page d'affichage des usagers </title>
        <link rel="stylesheet" type="text/css" href="style.css"/>
        <meta charset="utf-8"/>
    </head>
	<body>
        
        <?php include('header.php');    //on inclue le header dans la page actuelle?>

		<h2 class="bleu">Affichage des patients</h2>

        <?php

            //Requête pour accéder à toutes les valeurs de la table "usager" de la base de données
            $res = $linkpdo->query("SELECT * FROM usager");  

            //Affichage d'un tableau vide avec différentes colonnes (ici Civilité/Nom/Prénom/Adresse/...)
            echo "<table border='1' width=80% class='table'>
                <tr bgcolor='grey'>
                    <th>Civilité</th>
                    
                    <th>Nom</th>
					
                    <th>Prénom</th>
					
                    <th>Adresse</th>
					
                    <th>Code Postal</th>
					              
                    <th>Date de naissance</th>
					
                    <th>Lieu de naissance</th>
					
                    <th>Numéro de sécurité social</th>

                    <th>Nom médecin référent</th>
					
                    <th>Modifier</th>
					
                    <th>Supprimer</th>
                </tr>";

                //Remplissage de chaque ligne du tableau avec pour chaque ligne les informations d'un patient (Civilité/Nom/Prénom/Adresse/Code Postal/...)
                while ($data = $res->fetch()) {
                    $idM = $data[9];
                    $res2 = $linkpdo->query("SELECT medecin.nom FROM medecin WHERE idM ='$idM'");
                    $data2 = $res2->fetch();
                    echo "<tr><td>".$data[1]."</td><td>".$data[2]."</td><td>".$data[3]."</td><td>".$data[4]."</td><td>".$data[5]."</td><td>".$data[6]."</td><td>".$data[7]."</td><td>".$data[8]."</td><td>".$data2[0]."</td><td> <a href='Modification_Usagers.php?idU=$data[0]'>Modifier</a></td><td> <a href='Page_Suppression.php?idU=$data[0]'>Supprimer</a></td></tr>";
                }

            echo "</table>";

            //Si l'utilisateur appuie sur le bouton nommé "menu"...
            if(isset($_POST['menu'])) {

                //Redirection vers le menu du site 
                header('Location: bienvenue.php');
            }

            //Si l'utilisateur appuie sur le bouton nommé "ajout" (dans ce cas pour ajouter un patient)...
            if(isset($_POST['ajout'])) {

                //Redirection vers la page pour ajouter un patient
                header('Location: Ajout_Usagers.php');
            }
                    
        ?>

        <!--Formulaire pour afficher les 2 boutons : ajout / menu (pour ajouter un patient ou revenir au menu)-->
        <form action="Affichage_Usagers.php" method="post">
            <br></br>
            <p><input class="survolVert" type="submit" value="Ajouter un patient" name="ajout" /> <input class="survolBleu" type="submit" value="Retour au menu" name="menu"/></p>
        </form>

        <?php include('footer.php');    //On inclue le footer dans la page actuelle en appelant le fichier "footer.php"?>
    </body>
</html>
