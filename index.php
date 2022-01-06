<?php
require('connexionBD.php'); //connexion à la base de donnée grâce au fichier connexionBD.php
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Page d'authentification</title> <!--Titre de la page en question-->
        <link rel="stylesheet" type="text/css" href="style.css"/>
        <meta charset="utf-8"/>
	</head>
	<body>
        <?php

            require('header.php');

            //si l'utilisateur appuie sur le bouton nommé "connexion" on entre dans cette boucle
            if(isset($_POST['connexion'])) {

                //on vérifie que les 2 champs identifiant et mot de passe son bien renseigné
                //(même si on a mit le mot clé required dans les inputs qui oblige de les renseigner)
                if($_POST['id'] && $_POST['mdp']) {

                    //On stocke le login et le mot de passe entré par l'utilisateur dans des variables de session
                    $_SESSION['login'] = $_POST['id'];
                    $_SESSION['mdp'] = $_POST['mdp'];

                    //on stocke dans des variable l'id et le mot de passe renseigné par l'utilisateur
                    $id = $_POST['id'];
                    $mdp = $_POST['mdp'];

                    //on crypte le mot de passe entré par l'utilisateur en sha1 pour le comparer à celui de la base de donnée qui lui est crypter en sha1
                    $mdpHasher = sha1($mdp);

                    //requête qui trouve le mot de passe associé à un identifiant
                    $mdpR = $linkpdo->prepare("SELECT authentification.mdp from authentification where identifiant= :id ");
										$mdpR->execute(array('id' => $id));
                    $data = $mdpR->fetch();

                    //si le mot de passe entré une fois crypter en sha1 correspond à celui de la base de donnée de l'identifiant saisie on entre dans le if
                    if(strcmp($data[0], $mdpHasher)==0) {

                        //redirection vers la page de bienvenue sur le site
                        header('Location: bienvenue.php');

                    } else { //sinon ...

                        //Suppression des variables de session enregistrées
                        unset($_SESSION['login']);
                        unset($_SESSION['mdp']);

                        //On redirige vers la page d'erreur
                        header('Location: Erreur.php');
                    }
                } else {

                    //Suppression des variables de session enregistrées
                    unset($_SESSION['login']);
                    unset($_SESSION['mdp']);

                    //On redirige vers la page d'erreur
                    header('Location: Erreur.php');
                }
            }
        ?>

        <!--Affichage du formulaire de connexion-->
       <div class="form-accueil ">
            <form action="index.php" method="post">
                <h2 class="titre">Connexion</h2>
                <p class="champ"><input type="email" name="id" placeholder="Email" required/></p>
                <p class="champ"><input type="password" name="mdp" placeholder="Mot de passe" required/></p>
                <p class="champ2"><input class="survolBleu" type="submit" value="Se connecter" name="connexion"></p>
            </form>
        </div>

        <?php
            //On inclue le footer dans la page en appelant le fichier "footer.php"
            require('footer.php');
        ?>
	</body>
</html>
