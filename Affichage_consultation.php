<?php
require('verif.php'); //avant que la page s'affiche, il faut executer avant le fichier verif.php qui se connecte lui même à la base de donnée
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Page des rendez-vous </title> <!--Nom de la page-->
        <link rel="stylesheet" type="text/css" href="style.css"/>
        <meta charset="utf-8"/>
    </head>
	<body>

        <!--On inclue le header dans la page-->
        <?php require('header.php'); ?>

        <!-- Première partie, affichage de toutes les consultations -->
        <div class="div1">
            <h2 class="bleu">Liste de toutes les consultations</h2>
            <?php
                //requete pour avoir toutes les informations sur les consultations et pour pouvoir les afficher dans un tableau
                $res2 = $linkpdo->query("SELECT usager.idU, medecin.nom, usager.nom, usager.prenom, rendezvous.dateR, rendezvous.HeureR, rendezvous.duree
                from medecin, usager, rendezvous
                where rendezvous.idM = medecin.idM
                and rendezvous.idU = usager.idU
                order by rendezvous.dateR desc, HeureR desc");

                //Création et affichage du tableau des consultations avec le nom des différentes colonnes
                echo "<table border='1' width=70% class='table'>
                    <tr bgcolor='grey'>
                        <th>Nom médecin</th>

                        <th>Nom patient</th>

                        <th>Prénom patient</th>

                        <th>Date Rendez-vous</th>

                        <th>Heure Rendez-vous</th>

                        <th>Durée Rendez-vous</th>

                        <th>Modifier</th>

                        <th>Supprimer</th>
                    </tr>";

                    //boucle qui permet de remplir le tableau des consultations
                    while ($data = $res2->fetch()) {
                        echo "<tr><td>".$data[1]."</td><td>".$data[2]."</td><td>".$data[3]."</td><td>".$data[4]."</td><td>".$data[5]."</td><td>".$data[6]."</td><td> <a href='Modification_Consultation.php?idU=$data[0]&dateR=$data[4]&heureR=$data[5]'>Modifier</a></td><td> <a href='Page_Suppression.php?idU=$data[0]&dateR=$data[4]&heureR=$data[5]'>Supprimer</a></td></tr>";
                    }

                echo "</table>";
            ?>

            <!--Affichage d'un formulaire avec 2 boutons-->
            <form action="Affichage_consultation.php" method="post">
                <p>
                    <br></br>
                    <input type="submit" value="Ajouter un rendez-vous" name="ajout" class="survolVert" />
                    <input type="submit" value="Retour menu" name="menu" class="survolBleu" />
                </p>
            </form>
        </div>

        <?php
            //si l'utilisateur appuie sur le bouton "ajout" donc pour ajouter une consultation, on entre dans le if
            if(isset($_POST['ajout'])) {
                header('Location: Ajout_Consultation.php');
            }
            //si l'utilisateur appuie sur le bouton "menu" donc pour retourner au menu, celan entrera dans ce if
            if(isset($_POST['menu'])) {
                header('Location: bienvenue.php');
            }
        ?>

        <!-- Deuxième partie, recherche consultation pour un patient et un médecin saisie-->
        <br></br>
        <div class="div1">
            <h2 class="bleu">Rechercher les consultations d'un patient avec un médecin</h2>

            <!--
                Si on appuie sur le bouton nommé "recherche1" et que le nom et le prenom du patient est renseigné alors on entre dans le if
                Ou si on appuie juste sur le bouton nommé "recherche" on entre dans le if
                Le bouton "recherche1" corespond au bouton qui recherche le medecin réphérent à partir du nom et du prénom du patient
                Le bouton "recherche" corespond au bouton qui affiche le tableau des consultations à partir d'un nom, prénom de patient et d'un nom de médecin
            -->
            <?php if(isset($_POST['recherche1']) && $_POST['nom'] && $_POST['prenom'] || isset($_POST['recherche']) ): ?>
                <form action="Affichage_consultation.php" method="post">
                    <b>Nom Patient         <input type="text" name="nom" value="<?php if(isset($_POST['recherche1']) || isset($_POST['recherche'])){ echo $_POST['nom'];}  ?>"/></b>
                    <b>Prenom Patient         <input type="text" name="prenom" value="<?php if(isset($_POST['recherche1']) || isset($_POST['recherche'])){ echo $_POST['prenom'];}  ?>"/></b>
                    <b>Nom médecin         <input type="text" name="medecinR" value="<?php $nom = $_POST['nom'] ; $prenom = $_POST['prenom']; $nomMedecin = $linkpdo->prepare("SELECT medecin.nom from medecin, usager where medecin.idM = usager.idM and usager.nom = :nom
											and usager.prenom = '$prenom'"); $nomMedecin -> execute(array('nom' => $nom)); $data = $nomMedecin->fetch(); if(isset($_POST['recherche'])) {echo $_POST['medecinR'];}else{ echo $data[0]; }?>"></b>
                    <input type="submit" value="Rechercher" name="recherche" class="survolBleu" />
                </form>
            <?php else : ?> <!--Si une des conditions ci-dessus n'est pas respecter alors on entre dans ce else et on affiche le formulaire ci-dessous-->
                <form action="Affichage_consultation.php" method="post">
                    <p>
                        <b>Nom Patient         <input type="text" name="nom" value="<?php if(isset($_POST['recherche1'])){ echo $_POST['nom'];}  ?>"/></b>
                        <b>Prenom Patient         <input type="text" name="prenom" value="<?php if(isset($_POST['recherche1'])){ echo $_POST['prenom'];}  ?>"/></b>
                        <input type="submit" value="Rechercher Médecin référent" name="recherche1" class="survolBleu" />
                    </p>
                </form>
            <?php endif; ?>

            <?php

                //Si on appuie sur le bouton "recherche" on va effectuer les instructions à l'intérieur de ce if
                if(isset($_POST['recherche'])) {

                    //stockage dans des variables des valeurs saisie par l'utilisateur dans le formulaire
                    $med = $_POST['medecinR'];
                    $nomU = $_POST['nom'];
                    $prenomU = $_POST['prenom'];

                    //requete pour rechercher l'idU donc l'id d'un patient à partir de son nom et de son prénom
                    $idU = $linkpdo->prepare("SELECT idU from usager where nom=:nomU and prenom=:prenomU");
										$idU -> execute(array('nomU' => $nomU, 'prenomU' => $prenomU));
                    $data = $idU->fetch();
                    $_SESSION['idU'] = $data[0];

                    //requete qui va permettre l'affichage du tableau des consultations à partir d'un nom et prénom de patient et d'un nom de médecin
                    $res = $linkpdo->prepare("SELECT usager.idU, rendezvous.dateR, rendezvous.HeureR, rendezvous.duree
                    from medecin, usager, rendezvous
                    where medecin.idM = rendezvous.idM
                    and usager.idU = rendezvous.idU
                    and medecin.nom = '$med'
                    and usager.nom = '$nomU'
                    and usager.prenom = '$prenomU'
                    order by rendezvous.dateR desc, HeureR desc"); //cette order by permet de classer les consultations de manière à mettre la consultation la plus ancienne en bas du tableau

										$res -> execute(array('med' => $med, 'nomU' => $nomU, 'prenomU' => $prenomU));

                    //Création et affichage du tableau avec le nom des différentes colonnes
                    echo "<br></br>";
                    echo "<table border='1' width=50% class='table'>
                        <tr bgcolor='grey'>

                            <th>Date Rendez-vous</th>

                            <th>Heure Rendez-vous</th>

                            <th>Durée Rendez-vous</th>

                            <th>Modifier</th>

                            <th>Supprimer</th>
                        </tr>";

                        //boucle qui permet de remplir les lignes du tableau avec les différentes valeurs de la base de donnée
                        while ($data = $res->fetch()) {
                            echo "<tr><td>".$data[1]."</td><td>".$data[2]."</td><td>".$data[3]."</td><td> <a href='Modification_Consultation.php?idU=$data[0]&dateR=$data[1]&heureR=$data[2]'>Modifier</a></td><td> <a href='Page_Suppression.php?idU=$data[0]&dateR=$data[1]&heureR=$data[2]'>Supprimer</a></td></tr>";
                        }

                    echo "</table>";
                }
            ?>
            <br></br>
        </div>






        <!-- Troisième partie, elle permet de rechercher les consultations enregistré pour un médecin donné avec une liste déroulante-->
        <br></br>
        <div class="divSpecial">
            <h2 class="bleu">Rechercher les consultations d'un médecin</h2>

            <!--Affichage formulaire-->
            <form action="Affichage_consultation.php" method="post">
                <label><b>Nom médecin</b></label>

                <!--Affichage de la liste déroulante avec tous les médecins enregistrés-->
                <select name="nomM">
                    <option>-Select médecin-</option>
                    <?php
                        $res = $linkpdo->query("SELECT medecin.nom from medecin");
                        while($data = $res->fetch()){
                            echo '<option value="'.$data[0].'"> '.$data[0].'</option>';
                        }
                    ?>
                </select>
                <input type="submit" value="Rechercher" name="recherche2" class="survolBleu"/>
            </form>

            <?php

                //si l'utilisateur appuie sur le bouton nommé "recherche2"
                if(isset($_POST['recherche2'])) {

                    $nomM = $_POST['nomM'];

                    //requete qui permet d'afficher le tableau à partir du nom du médecin
                    $res = $linkpdo->query("SELECT usager.idU, rendezvous.dateR, rendezvous.HeureR, rendezvous.duree
                    from medecin, usager, rendezvous
                    where medecin.idM = rendezvous.idM
                    and usager.idU = rendezvous.idU
                    and medecin.nom = '$nomM'
                    order by rendezvous.dateR desc, HeureR desc");

                    //Création et affichage du tableau avec le nom des différentes colonnes
                    echo "<br></br>";
                    echo "<table border='1' width=50% class='table' margin-bottom='100px'>
                        <tr bgcolor='grey'>

                            <th>Date Rendez-vous</th>

                            <th>Heure Rendez-vous</th>

                            <th>Durée Rendez-vous</th>

                            <th>Modifier</th>

                            <th>Supprimer</th>
                        </tr>";

                        //boucle pour remplir le tableau avec les données de la requête
                        while ($data = $res->fetch()) {
                            echo "<tr><td>".$data[1]."</td><td>".$data[2]."</td><td>".$data[3]."</td><td> <a href='Modification_Consultation.php?idU=$data[0]&dateR=$data[1]&heureR=$data[2]'>Modifier</a></td><td> <a href='Page_Suppression.php?idU=$data[0]&dateR=$data[1]&heureR=$data[2]'>Supprimer</a></td></tr>";
                        }

                    echo "</table>";
                }
            ?>
        </div>

        <!--Affichage du footer-->
        <div class="footerSpecial">
            <?php require('footer.php');?>
        </div>
	</body>
</html>
