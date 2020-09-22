<?php
	session_start();
	include "fonction.inc.php";

	$table = $_POST;
	$liste = array('adresseMail','motDePasse');

	$set = verifSet($table,$liste);
	if($set == true){
		$key = searchKeyJson($table,$liste);
		if($key == false){
			header("location: admin.php?error=4&b=2");
		}
		else{
			header("location: admin.php?key=".$key."&b=2");
		}
	}
	else{
		header("location: admin.php?error=5&b=2");
	}

	
?>	