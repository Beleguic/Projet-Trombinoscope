<?php
	session_start();

	include "fonction.inc.php";
	$table = $_POST;
	$liste = array('adresseMail','motDePasse');
	$deco = verifSet($table,$liste);
	if($deco == true){
		$retour = connexion($table,"./info/info.csv");
		if($retour['connexion'] == "true"){
			$_SESSION['mail'] = $retour['mail'];
			$_SESSION['name'] = $retour['nom'];
			$event =  "Connexion réussie";
			getlog($event,$table['adresseMail']);
			header('location:compte.php');
			exit();
		}
		else{
			$_SESSION=array();
			session_destroy();	
			$event = "Connexion échouée";
			getlog($event,$table['adresseMail']);
			header("location: index.php?error=2");
			exit();
		}
	}
	else{
		$_SESSION=array();
		session_destroy();
		header('location:index.php?error=1');
		exit();
	}
?>	