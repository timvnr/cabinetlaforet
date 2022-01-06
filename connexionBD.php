<?php
	//Démarrage d'une session
	session_start();

	//On stocke dans des variables les différentes informations nécessaire à la connexion à la base de données
    $server= "localhost";
	$login = "root";
	$mdp = "najHu8-jitpog-tomtow";
	$db = "id18235240_cabinetlaforet";

	///Connexion au serveur MySQL
	try {
		$linkpdo = new PDO("mysql:host=$server;dbname=$db", $login, $mdp);
	}
		catch (Exception $e) {
		die('Erreur : ' . $e->getMessage());
	}
?>
