<?php
    //il faut executer avant le fichier verif.php qui se connecte lui même à la base de donnée et vérifie si l'utilisateur est connecté
    require('verif.php');
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Page de modification des médecins </title>
        <link rel="stylesheet" type="text/css" href="style.css"/>
        <meta charset="utf-8"/>
	</head>
	<body>

        <?php

            include('header.php'); //on inclue le fichier header.php pour pouvoir avoir le header directement en haut de la page

            if(!isset($_POST['Modifier'])) {

                //On stocke dans une variable l'id du médecin (son idM)
                $tab = $_GET['idM'];

                //Requête pour accéder à toutes les information d'un médecin à partir de son identifiant (idM)
                $res = $linkpdo->prepare("SELECT * FROM medecin WHERE idM = :tab");
								$res -> execute(array('tab' => $tab));

                while ($data = $res->fetch()) {
                    $id_medecin = $data[0];
                    $civilite = $data[1];
                    $nom = $data[2];
                    $prenom = $data[3];
                }
            } else {

                //Stockage dans des variables des nouvelles valeurs du formulaire
                $id_medecin = $_POST['id_medecin'];
                $civilite = $_POST['civilite'];
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];

                //Requête pour mettre à jour la table medecin
                $res2 = $linkpdo->prepare("UPDATE medecin SET civilite='$civilite', nom='$nom', prenom='$prenom' where idM='$id_medecin'");
								$res2 -> execute(array('civilite' => $nom, 'prenom' => $prenom, 'id_medecin' => $id_medecin));
                header('Location: Affichage_Medecin.php');
                exit();
            }

            //Si l'utilisateur appuie sur le bouton nommé "Annuler"...
            if(isset($_POST['Annuler'])) {

                //Redirection vers la page d'affichage des médecins
                header('Location: Affichage_Medecin.php');
            }
        ?>

        <div class="aligne">
            <h2>Modification d'un médecin</h2>

            <!--Affichage du formulaire avec les champs pré-remplit avec les informations du médecin choisie que l'on veut modifier-->
            <form action="Modification_Medecins.php" method="post">
                <p><input type="hidden" name="id_medecin" value="<?php echo $id_medecin?>"/></p>
                <p>Civilité         <input type="text" name="civilite" value="<?php echo $civilite?>"/></p>
                <p>Nom         <input type="text" name="nom" value="<?php echo $nom?>"/></p>
                <p>Prénom      <input type="text" name="prenom" value="<?php echo $prenom?>"/></p>
                <p><input class="survolVert" type="submit" value="Modifier" name="Modifier"> <input class="survolRouge" type="submit" value="Annuler" name="Annuler"></p>
            </form>
        </div>
        <?php include('footer.php'); //on inclue le fichier footer.php pour avoir le footer directement en bas de la page?>

    </body>
</html>
