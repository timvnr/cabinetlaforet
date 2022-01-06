<?php
	//Démarrage d'une session
	session_start();

	//On stocke dans des variables les différentes informations nécessaire à la connexion à la base de données
    $server= "eu-cdbr-west-02.cleardb.net";
	$login = "b548aae8146e4d";
	$mdp = "f589b150";
	$db = "heroku_ff207826a0fbec5";

	///Connexion au serveur MySQL
	try {
		$linkpdo = new PDO("mysql:host=$server;dbname=$db", $login, $mdp);
	}
		catch (Exception $e) {
		die('Erreur : ' . $e->getMessage());
	}
?>
