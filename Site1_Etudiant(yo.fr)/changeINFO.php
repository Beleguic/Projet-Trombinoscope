<?php
	session_start();
	include "fonction.inc.php";

	$table = $_POST;
	$image = $_FILES;
	$liste = array('nom','prenom','adresseMail','telephone','adressePostale','filiere','groupe');
	$change = traiteInfo($table,$liste);
	$pointV = checkInfoPV($liste,$table);
	if(!($pointV)){
		$event = "Un des champs renseigné contient un \";\"";
		getLog($event,$table['mail2']);
		header("location: compte.php?error=11&b=1");
	}
	else{
		if($change[2] == "y"){
			$mailFormat = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";
			$mail = checkFormat($mailFormat,$table[$liste[2]]);
		}
		else{
			$mail = true;
		}
		if(!($mail)){
			$event = "Le mail ne respecte pas la norme ou est déjà utilisé";
			getLog($event,$table['mail2']);
			header("location: compte.php?error=12&b=1");
		}
		else{
			if($change[3] == "y"){					
				$telFormat = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";
				$tel = checkFormat($telFormat,$table[$liste[3]]);
			}
			else{
				$tel = true;
			}
			if(!($tel)){
				$event = "Le numéro de téléphone ne respecte pas la norme ou est deja utilisé";
				getLog($event,$table['mail2']);
				header("location: compte.php?error=13&b=1");
			}
			else{
				$pwd = checkPwd($table);
				if(!($pwd)){
					$event = "Le mot de passe a un problème";
					getLog($event,$table['mail2']);
					header("location: compte.php?error=14&b=1");
				}
				else{
					if($image['image']['tmp_name'] != ""){
						$img = verifImage($image);
					}
					else{
						$img = true;
					}
					if(!($img)){
						$event = "La nouvelle image n'est pas conforme";
						getLog($event,$table['mail2']);
						header("location: compte.php?error=15&b=1");
					}
					else{
						changeInfo($table,$change,$liste,"./info/info.csv",$image);
						header("location: compte.php");
					}
				}
			}
		}
	}
	

?>