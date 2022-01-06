<?php
    //il faut executer avant le fichier verif.php qui se connecte lui même à la base de donnée et vérifie si l'utilisateur est connecté
    require('verif.php');

    $pos = strpos($_SERVER['HTTP_REFERER'],"M");
    $url= substr($_SERVER['HTTP_REFERER'], $pos);
    $consult = "M3104/ProjetPHP/Affichage_consultation.php";
    $medecin = "M3104/ProjetPHP/Affichage_Medecin.php";
    $patient = "M3104/ProjetPHP/Affichage_Usagers.php";
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Page de suppression d'une consultation </title>
        <link rel="stylesheet" type="text/css" href="style.css"/>
        <meta charset="utf-8"/>
	</head>
	<body>

    <?php include('header.php');    //on inclue le fichier "header.php" pour pouvoir avoir le header directement en haut de la page?>

    <div class="decal">

        <!--Dans le cas ou l'utilisateur vient de la page Affichage_consultation.php-->
        <?php if(strcmp($url, $consult)==0) : ?>

            <!--Formulaire avec des champs cachés-->
            <form action="Page_Suppression.php" method="post">
                <p> <input type="hidden" value="<?php echo $_GET['idU'] ?>" name="idU"> </p>
                <p> <input type="hidden" value="<?php echo $_GET['dateR'] ?>" name="dateR"> </p>
                <p> <input type="hidden" value="<?php echo $_GET['heureR'] ?>" name="heureR"> </p>
                <p>
                    Etes vous vraiment sûre de vouloir supprimer cette consultation ?
                    <input class="survolVert" type="submit" value="Confirmer" name="Confirmer1"> <input class="survolRouge" type="submit" value="Annuler" name="Annuler1">
                </p>
            </form>
        <?php endif; ?>

        <!--Dans le cas ou l'utilisateur vient de la page Affichage_Medecin.php-->
        <?php if(strcmp($url, $medecin)==0) : ?>

            <!--Formulaire avec des champs cachés pour personnaliser l'affichage en fonction du médecin choisi-->
            <form action="Page_Suppression.php" method="post">
                <p> <input type="hidden" value="<?php echo $_GET['idM'] ?>" name="idM"> </p>
                <p>
                    Etes vous vraiment sûre de vouloir supprimer le/la médecin : <b><?php $idM=$_GET['idM']; $nomMedecin = $linkpdo->query("SELECT medecin.nom from medecin where medecin.idM = '$idM'"); $data = $nomMedecin->fetch(); echo $data[0];?></b> ?
                    <input class="survolVert" type="submit" value="Confirmer" name="Confirmer2"> <input class="survolRouge" type="submit" value="Annuler" name="Annuler2">
                </p>
            </form>
        <?php endif; ?>

        <!--Dans le cas ou l'utilisateur vient de la page Affichage_Usagers.php-->
        <?php if(strcmp($url, $patient)==0) : ?>

            <!--Formulaire avec des champs cachés pour personnaliser l'affichage en fonction du patient choisi-->
            <form action="Page_Suppression.php" method="post">
                <p> <input type="hidden" value="<?php echo $_GET['idU'] ?>" name="idU"> </p>
                <p>
                    Etes vous vraiment sûre de vouloir supprimer le/la patient(e) : <b><?php $idU=$_GET['idU']; $Patient = $linkpdo->query("SELECT usager.nom, usager.prenom from usager where usager.idU = '$idU'"); $data = $Patient->fetch(); echo $data[0]." "; echo $data[1];?></b> ?
                    <input class="survolVert" type="submit" value="Confirmer" name="Confirmer3"> <input class="survolRouge" type="submit" value="Annuler" name="Annuler3">
                </p>
            </form>
        <?php endif; ?>
    </div>


    <?php

        //Les cas si l'utilisateur appuie sur un des bouton confirmer

        //si l'utilisateur appuie sur le bouton confirmer1 donc dans le cas ou l'utilisateur vient de la page Affichage_consultation.php
        if(isset($_POST['Confirmer1'])) {

            //On stocke dans des variables les informations nécessaire à la suppression d'une consultation (rendez-vous)
            $idU = $_POST['idU'];
            $dateR = $_POST['dateR'];
            $heureR = $_POST['heureR'];

            //requete pour supprimer la consultation choisie à partir des informations enregistrées ci-dessus
            $res = $linkpdo->prepare("DELETE FROM rendezvous where idU = :idU and dateR= :dateR and HeureR= :heureR");
						$res -> execute(array('idU' => $idU, 'dateR' => $dateR, 'heureR' => $heureR));
            header('Location: Affichage_consultation.php');
        }

        //si l'utilisateur appuie sur le bouton confirmer2 donc dans le cas ou l'utilisateur vient de la page Affichage_Medecin.php
        if(isset($_POST['Confirmer2'])) {

            //On stocke dans une variable l'identifiant du médecin (c'est la seule information nécessaire pour pouvoir supprimer un médecin)
            $idM = $_POST['idM'];

            //requete pour supprimer le médecin choisi à partir de son identifiant (idM) stocker ci-dessus
            $res = $linkpdo->prepare("DELETE FROM medecin where idM = :idM");
						$res -> execute(array('idM' => $idM));
            header('Location: Affichage_Medecin.php');

        }

        //si l'utilisateur appuie sur le bouton confirmer3 donc dans le cas ou l'utilisateur vient de la page Affichage_Usager.php
        if(isset($_POST['Confirmer3'])) {

            //On stocke dans une variable l'identifiant du patient (c'est la seule information nécessaire pour pouvoir supprimer un patient)
            $idU = $_POST['idU'];

            //requete pour supprimer le patient choisi à partir de son identifiant (idU) stocker ci-dessus
            $res = $linkpdo->query("DELETE FROM usager where idU = :idU");
						$res -> execute(array('idU' => $idU));
            header('Location: Affichage_Usagers.php');
        }


        //Les cas si l'utilisateur appuie sur un des bouton annuler

        //si l'utilisateur appuie sur le bouton annuler1 donc dans le cas ou l'utilisateur vient de la page Affichage_consultation.php
        if(isset($_POST['Annuler1'])) {

            //Redirection vers la page d'affichage des consultations (rendez-vous)
            header('Location: Affichage_consultation.php');
        }

        //si l'utilisateur appuie sur le bouton annuler2 donc dans le cas ou l'utilisateur vient de la page Affichage_Medecin.php
        if(isset($_POST['Annuler2'])) {

            //Redirection vers la page d'affichage des médecins
            header('Location: Affichage_Medecin.php');
        }

        //si l'utilisateur appuie sur le bouton annuler3 donc dans le cas ou l'utilisateur vient de la page Affichage_Usagers.php
        if(isset($_POST['Annuler3'])) {

            //Redirection vers la page d'affichage des patients
            header('Location: Affichage_Usagers.php');
        }

        //on inclue le fichier footer.php pour avoir le footer directement en bas de la page actuelle
        require('footer.php');
    ?>

	</body>
</html>
