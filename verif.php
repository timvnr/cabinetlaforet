<?php 
    require('connexionBD.php');   //connexion à la base de donnée grâce au fichier connexionBD.php

    //si les variable de session "login" et "mdp" ne sont pas initialisé cela veut dire que l'utilisateur n'est pas connecter...
    //...au site donc on va le rediriger vers la page de connexion (voir dans le if ci-dessous)
    if(!$_SESSION['login'] && !$_SESSION['mdp']) {

        //Redirection vers la page de connexion
        header('Location: index.php');
    }
?>

