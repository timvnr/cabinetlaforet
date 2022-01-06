<?php
    //il faut executer avant le fichier verif.php qui se connecte lui même à la base de donnée et vérifie si l'utilisateur est connecté
    require('verif.php');
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Page de modification des usagers </title>
        <link rel="stylesheet" type="text/css" href="style.css"/>
        <meta charset="utf-8"/>
	</head>
	<body>

        <?php

            include('header.php'); //on inclue le fichier header.php pour pouvoir avoir le header directement en haut de la page

            if(!isset($_POST['Modifier'])) {

                //On stocke dans une variable l'id du patient (son idU)
                $tab = $_GET['idU'];

                //Requête pour accéder à toutes les information d'un patient à partir de son identifiant (idU)
                $res = $linkpdo->prepare("SELECT * FROM usager WHERE idU = :tab");
								$res -> execute(array('tab' => $tab));

                while ($data = $res->fetch()) {
                    $id_usager = $data[0];
                    $civilite = $data[1];
                    $nom = $data[2];
                    $prenom = $data[3];
                    $adresse = $data[4];
                    $codeP = $data[5];
                    $dateN = $data[6];
                    $lieuN = $data[7];
                    $numS = $data[8];
                    $idM = $data[9]; //idM médecin

                    //Recherche du nom du médecin à partir de son idM
                    $res2 = $linkpdo->prepare("SELECT medecin.nom FROM medecin WHERE idM =:idM");
										$res2 -> execute(array('idM' => $idM));
                    $data2 = $res2->fetch();
                    $nomM = $data2[0];
                }
            } else {

                //On stocke dans des variables les valeurs saisies par l'utilisateur dans le formulaire (si il n'a pas modifié un champ par exemple on prendra la valeur déjà pré-remplit du début)
                $id_usager = $_POST['id_usager'];
                $civilite = $_POST['civilite'];
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $adresse = $_POST['adresse'];
                $codeP = $_POST['code'];
                $dateN = $_POST['dateN'];
                $lieuN = $_POST['lieuN'];
                $numS = $_POST['numS'];
                $nomM = $_POST['nomM'];

                //recherche de l'idM du médecin à partir de son nom
                $res2 = $linkpdo->prepare("SELECT medecin.idM FROM medecin WHERE nom =:nomM");
								$res2 -> execute(array('nomM' => $nomM));
                $data2 = $res2->fetch();
                $idM = $data2[0];

                //requete pour mettre à jour la table et prendre en compte les modifs de l'utilisateur
                $res3 = $linkpdo->prepare("UPDATE usager SET civilite=:civilite, nom=:nom, prenom=:prenom, adresse=:adresse, codeP=:codeP, dateN=:dateN, lieuN=:lieuN, numS=:numS, idM=:idM where idU=:id_usager");
								$res3 -> execute(array('civilite' => $civilite, 'nom' => $nom, 'prenom' => $prenom, 'adresse' => $adresse, 'codeP' = $codeP, 'dateN' => $dateN, 'lieuN' => $lieuN, 'numS' => $numS, 'idM' => $idM, 'id_usager' => $id_usager));
                header('Location: Affichage_Usagers.php');
            }

            //Si l'utilisateur appuie sur le bouton nommé "Annuler"...
            if(isset($_POST['Annuler'])) {

                //Redirection vers la page d'affichage des patients / usagers
                header('Location: Affichage_Usagers.php');
            }
        ?>

        <div class="aligne">
            <h2>Modification d'un usager</h2>

            <!--Affichage d'un formulaire avec les différents champs pré-remplit avec les informations du patient choisi que l'on veut modifier-->
            <form action="Modification_Usagers.php" method="post">
                <p><input type="hidden" name="id_usager" value="<?php echo $id_usager?>"/></p>
                <p>Civilité         <input type="text" name="civilite" value="<?php echo $civilite?>"/></p>
                <p>Nom         <input type="text" name="nom" value="<?php echo $nom?>"/></p>
                <p>Prénom      <input type="text" name="prenom" value="<?php echo $prenom?>"/></p>
                <p>Adresse      <input type="text" name="adresse" value="<?php echo $adresse?>"/></p>
                <p>Code postal  <input type="number" name="code" value="<?php echo $codeP?>"/></p>
                <p>Date de naissance        <input type="date" name="dateN" value="<?php echo $dateN?>"/></p>
                <p>Lieu de naissance    <input type="text" name="lieuN" value="<?php echo $lieuN?>"/></p>
                <p>Numéro de sécurité social    <input type="text" name="numS" value="<?php echo $numS?>"/></p>
                <p>Médecin référent   <input type="text" name="nomM" value="<?php echo $nomM?>"/></p>

                <input class="survolVert" type="submit" value="Modifier" name="Modifier">
                <input class="survolRouge" type="submit" value="Annuler" name="Annuler">

            </form>
        </div>
        <?php include('footer.php'); //on inclue le fichier footer.php pour avoir le footer directement en bas de la page?>

    </body>
</html>
