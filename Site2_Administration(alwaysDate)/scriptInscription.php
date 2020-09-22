<?php
	session_start();
	
	include "fonction.inc.php";

	$liste = array('nom','prenom','adresseMail','motDePasse');
	$table = $_POST;
	$image = "";

	$mail = $table[$liste[2]];
	$sortie1 = verifSet($table,$liste);
	if($sortie1 == true){
		$sortie2 = verifDonnee($table,$liste);
		if($sortie2 == true){
			$sortie3 = verifDoublons($table);
			if($sortie3['etat'] == true){
				$insCheck = inscription($table,$liste,"./info/info.csv",$image);
				if($insCheck == true){
					$retour = connexion($table,"./info/info.csv");
					if($retour['connexion'] == "true"){
						$_SESSION['mail'] = $retour['mail'];
						$_SESSION['name'] = $retour['nom'];
						header("location: trombinoscope.php");
					}
				}
				exit();
			}
			else{
				$IncTEL = $sortie3["ErrTEL"];
				$IncMail = $sortie3["ErrMail"];

				if ($IncTEL == true && $IncMail == true) {
					header("location: inscription.php?MAIL=true&TEL=true");
				exit();
				}
				if ($IncTEL == true && $IncMail == false) {
					header("location: inscription.php?TEL=true");
				exit();	
				}
				if ($IncTEL == false && $IncMail == true) {
					header("location: inscription.php?MAIL=true");
				exit();
				}
			}
		}
		else{
			header("location: inscription.php?error=1");
		}
	}
	else{
		header("location: inscription.php?error=2");
	}


?>

