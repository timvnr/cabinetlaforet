<?php
    //il faut executer avant le fichier verif.php qui se connecte lui même à la base de donnée et vérifie si l'utilisateur est connecté
    require('verif.php');

    //Manipulation avec l'url de la page précédente pour la rendre universelle et enlever le nom de domaine qui se trouve avant (en locurence pour nous le "http://localhost")
    $pos = strpos($_SERVER['HTTP_REFERER'],"A");
    $url= substr($_SERVER['HTTP_REFERER'], $pos);
    $consult = "Affichage_consultation.php";
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Page de modification d'une consultation </title>
        <link rel="stylesheet" type="text/css" href="style.css"/>
        <meta charset="utf-8"/>
	</head>
	<body>

    <?php

        include('header.php');  //on inclue le fichier header.php pour pouvoir avoir le header directement en haut de la page

        if(strcmp($url,$consult)==0) {
            //récupération des paramètres de la page Affichage_consultation et stockage dans des variables
            $_SESSION['dateRdeBase'] = $_GET['dateR'];
            $_SESSION['heureRdeBase'] = $_GET['heureR'];
            $_SESSION['idUdeBase'] = $_GET['idU'];

            $dateRdeBase = $_SESSION['dateRdeBase'];
            $heureRdeBase = $_SESSION['heureRdeBase'];
            $idUdeBase = $_SESSION['idUdeBase'];

            //requete pour pouvoir avoir les valeurs nécessaires à l'affichage pré remplit du formulaire
            $Base = $linkpdo->prepare("SELECT medecin.nom, usager.nom, usager.prenom, rendezvous.duree FROM medecin, usager, rendezvous
            where medecin.idM = rendezvous.idM
            and usager.idU = rendezvous.idU
            and usager.idU = :idUdeBase
            and rendezvous.dateR = :dateRdeBase
            and rendezvous.HeureR = :heureRdeBase;");

						$Base -> execute(array('idUdeBase' => $idUdeBase, 'dateRdeBase' => $dateRdeBase,'heureRdeBase' => $heureRdebase));
            $data2 = $Base->fetch();

            //sauvegarde des valeurs nécessaire dans des variables
            $nomMdeBase = $data2[0];
            $nomUdeBase = $data2[1];
            $prenomUdeBase = $data2[2];
            $dureeDeBase = $data2[3];
        }



        //si l'utilisateur appuie sur le bouton modifier
		if(isset($_POST['Modifier'])) {
            //on enregistre dans des variables les nouvelles valeurs du formulaire
            $dateR = $_POST['dateR'];
            $HeureR = $_POST['HeureR'];
            $Duree = $_POST['Duree'];
            $nomM = $_POST['nomM'];
            $nomU = $_POST['nomU'];
            $prenomU = $_POST['prenomU'];

            //récupération variable pour trouver la ligne à modifier dans rendezvous
            $dateRdeBase = $_SESSION['dateRdeBase'];
            $heureRdeBase = $_SESSION['heureRdeBase'];
            $idUdeBase = $_SESSION['idUdeBase'];

            //requête pour chercher l'idU à partir du nom et du prénom du patient
            $idU = $linkpdo->prepare("SELECT idU from usager where nom=:nomU and prenom=:prenomU");
						$idU -> execute(array('nomU' => $nomU, 'prenomU' => $prenomU));
            $data = $idU->fetch();

            //requête pour chercher l'idM à partir du nom du médecin
            $idM = $linkpdo->prepare("SELECT idM from medecin where nom=:nomM");
						$idM -> execute(array('nomM' => $nomM));
            $data1 = $idM->fetch();

            //Requete pour modifier la table rendezvous
			$res = $linkpdo->prepare("UPDATE rendezvous SET dateR=:dateR, HeureR=:HeureR, duree=:Duree, idU=:idU, idM=:idM WHERE dateR=:dateRdeBase and HeureR=:heureRdeBase and idU=:idUdeBase");
			$res -> execute(array('dateR' => $dateR,'HeureR' => $HeureR,'Duree' => $Duree, 'idU' => $data[0], 'idM' => $data1[0], 'dateRdeBase' => $dateRdeBase, 'heureRdeBase' => $heureRdeBase, 'idUdeBase' =>$idUdeBase));

            //redirection vers la page affichage consultation
            header('Location: Affichage_consultation.php');
        }

        //si l'utilisateur appuie sur le bouton annuler
		if(isset($_POST['Annuler'])) {
            //redirection vers la page affichage consultation
			header('Location: Affichage_consultation.php');
		}

    ?>

    <div class="aligne">
	    <h2>Page modification consultation</h2>

        <!--Affichage d'un formulaire avec les différents champs pré-remplit avec les informations de la consultation choisie que l'on veut modifier-->
        <form action="Modification_Consultation.php" method="post">
                <p>Nom médecin <input type="text" name="nomM" value="<?php echo $nomMdeBase?>"/></p>
                <p>Nom patient      <input type="text" name="nomU" value="<?php echo $nomUdeBase?>"/></p>
                <p>Prénom patient     <input type="text" name="prenomU" value="<?php echo $prenomUdeBase?>"/></p>
                <p>Date consultation     <input type="date" name="dateR" value="<?php echo $dateRdeBase?>"/></p>
                <p>Heure consultation     <input type="time" name="HeureR" value="<?php echo $heureRdeBase?>"/></p>
                <p>Durée consultation     <input type="time" name="Duree" value="<?php echo $dureeDeBase?>"/></p>

                <p><input class="survolVert" type="submit" value="Modifier" name="Modifier"> <input class="survolRouge" type="submit" value="Annuler" name="Annuler"></p>
        </form>
    </div>
    <?php include('footer.php'); //on inclue le fichier footer.php pour avoir le footer directement en bas de la page?>

	</body>
</html>
