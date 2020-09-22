<?php
	session_start();
	include "fonction.inc.php";

	$liste = array('nom','prenom','adresseMail','telephone','adressePostale','filiere','groupe','motDePasse');
	$table = $_POST;
	$image = $_FILES;

	$mail = $table[$liste[2]];
	$sortie1 = verifSet($table,$liste);
	if($sortie1 == true){
		$sortie2 = verifDonnee($table,$liste);
		if($sortie2 == true){
			$sortie3 = verifImage($image);
			if($sortie3 == true){
				$sortie4 = verifDoublons($table);
				if($sortie4 == true){
					$insCheck = inscription($table,$liste,"./info/info.csv",$image);
					if($insCheck == true){
						$event = "le compte de $mail a été cree"; 
						getlog($event,$mail);
						$retour = connexion($table,"./info/info.csv");
						if($retour['connexion'] == "true"){
							$_SESSION['mail'] = $retour['mail'];
							$_SESSION['name'] = $retour['nom'];
							$event =  "Connexion automatique réussie";
							getlog($event,$table['adresseMail']);
						}
					}
					header('location: compte.php');
					exit();
				}
				else{
					$incTel = $err["ErrTEL"];
					$incMail = $err["ErrMail"];

					if ($IncTEL == true && $IncMail == true) {
					$event = "Le compte de $mail n'a pas été crée car le numéro de téléphone et l'adresse mail sont déjà associés à un autre compte"; 
					getlog($event,$mail);	
					header("location: inscription.php?MAIL=true&TEL=true");
					exit();
					}
					if ($IncTEL == true && $IncMail == false) {
					$event = "Le compte de $mail n'a pas été crée car le numéro de téléphone est déjà associé à un autre compte"; 
					getlog($event,$mail);
					header("location: inscription.php?TEL=true");
					exit();	
					}
					if ($IncTEL == false && $IncMail == true) {
					$event = "Le compte de $mail n'a pas été crée car l'adresse mail est déjà associée à un autre compte"; 
					getlog($event,$mail);
					header("location: inscription.php?MAIL=true");
					exit();
					}
				}
			}
			else{
				$event = "Le compte de $mail n'a pas été crée car la photo n'était pas valide"; 
				getlog($event,$mail);
				header("location: inscription.php?error=3");
			}
		}
		else{
			$event = "Le compte de $mail n'a pas été crée car une ou plusieurs informations contiennent un point virgule "; 
			getlog($event,$mail);
			header("location: inscription.php?error=1");
		}
	}
	else{
		$event = "Le compte de $mail n'a pas été crée car une ou plusieurs informations étaient vides"; 
		getlog($event,$mail);
		header("location: inscription.php?error=2");
	}


?>

