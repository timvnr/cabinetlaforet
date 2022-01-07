<?php
require('verif.php'); //il faut executer avant le fichier verif.php qui se connecte lui même à la base de donnée et vérifie si l'utilisateur est identifié
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Page d'ajout d'une consultation </title>
        <link rel="stylesheet" type="text/css" href="style.css"/>
        <meta charset="utf-8"/>
	</head>
	<body>

    <?php

        //on inclue le header dans la page
        require('header.php');

        //si on appuie sur le bouton nommé "Ajouter"
		if(isset($_POST['Ajouter'])) {

            //on stocke dans des variables les valeurs entrées dans le formulaire
            $dateR = $_POST['dateR'];
            $HeureR = $_POST['HeureR'];
            $Duree = $_POST['Duree'];
            $nomM = $_POST['nomM'];
            $nomU = $_POST['nomU'];
            $prenomU = $_POST['prenomU'];

            //requete pour récuperer l'idU donc l'id du patient à partir de son nom et prénom
            $idU = $linkpdo->prepare("SELECT idU from usager where nom=:nomU and prenom=:prenomU");
		$idU -> execute(array('nomU' => $nomU, 'prenomU' => $prenomU));
            $data = $idU->fetch();

            //requete pour récuperer l'idM donc l'id du médecin à partir de son nom
            $idM = $linkpdo->prepare("SELECT idM from medecin where nom=:nomM");
		$idM -> execute(array('nomM' => $nomM));
            $data1 = $idM->fetch();

						//requete de vérification du non-chevauchement du rendez-vous à ajouter
						$res = $linkpdo->prepare("SELECT count(*)
										from rendezvous
										where rendezvous.dateR = :dateR
										and rendezvous.HeureR = :HeureR
										and rendezvous.idU = :idU
										and :Heure between rendezvous.HeureR and addtime(rendezvous.HeureR,rendezvous.duree)
										or addtime(:Heure1,:Duree) between rendezvous.HeureR and addtime(rendezvous.HeureR,rendezvous.duree)
										group by rendezvous.idU");

						$res -> execute(array('dateR' => $dateR, 'HeureR' => $HeureR, 'idU' => $data[0], 'heure' => $heureR, 'heure1' => $HeureR, 'duree' => $Duree));

						// si on a au moins 1 ligne de retour dans le resulat de la requete alors on ajoute pas le rendez-vous
						$cond = $res->fetch();
						if($cond[0] == 0) {
							$res2 = $linkpdo->prepare("INSERT INTO rendezvous(dateR, HeureR, duree, idU, idM) VALUES(:dateR, :HeureR, :Duree, :idU, :idM)");
							$res2 -> execute(array('dateR' => $dateR, 'HeureR' => $HeureR, 'Duree' => $Duree, 'idU' => $data[0],'idM' => $data1[0]));
							header('Location: Affichage_consultation.php');

						} else {
                            header('Location: Affichage_consultation.php');
						}

        }

        //si on appuie sur le bouton annuler
		if(isset($_POST['Annuler'])) {
			header('Location: Affichage_consultation.php'); //redirection vers la page d'affichage de consultation
		}

    ?>

    <div class="aligne">
        <h2>Page ajout consultation</h2>

        <!--Affichage du formulaire-->
        <form action="Ajout_Consultation.php" method="post">
                <p>Nom médecin <input type="text" name="nomM"/></p>
                <p>Nom patient      <input type="text" name="nomU"/></p>
                <p>Prénom patient     <input type="text" name="prenomU"/></p>
                <p>Date consultation     <input type="date" name="dateR"/></p>
                <p>Heure consultation     <input type="time" name="HeureR"/></p>
                <p>Durée consultation     <input type="time" name="Duree" value="<?php echo '00:30:00'?>"/></p>

                <p><input class="survolVert" type="submit" value="Ajouter" name="Ajouter"> <input class="survolRouge" type="submit" value="Annuler" name="Annuler"></p>
        </form>
    </div>

    <!--On inclue dans la page le footer-->
    <?php require('footer.php');?>

	</body>
</html>
