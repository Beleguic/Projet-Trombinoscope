<?php
	session_start();
	include "fonction.inc.php";
 
	$id = $_SESSION['name'];
	$post = $_POST;
	$mail = checkMail($post['mail'],$id,"./info/info.csv");
	
	if (!($mail)){
			$event = "Echec du changement de mot de passe : le mail renseigné n'est pas celui du compte";
			getLog($event,$post['mail']);
			header('Location: compte.php?error=2&b=2');
		}
	else{
		$EPwd = checkEgalePassword($post['newPwd1'],$post['newPwd2']);
		if (!($EPwd)){
			$event = "Echec du changement de mot de passe : les deux nouveaux mots de passe ne sont pas égaux";
			getLog($event,$post['mail']);
			header('Location: compte.php?error=5&b=2');
		}
		else{
			$patPwd = "/^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)([^;]).*$/";
			$FPwd = checkFormat($patPwd,$post['newPwd1']);
			if (!($FPwd)){
				$event = "Echec du changement de mot de passe : le nouveau mot de passe ne respecte pas le format des mots de passe";
				getLog($event,$post['mail']);
				header('Location: compte.php?error=4&b=2');
			}
			else{
				$SamePwd = checkSamePassword($post['oldPwd'],$post['newPwd1']);
				if (!($SamePwd)){
					$event = "Echec du changement de mot de passe : le nouveau mot de passe renseigné est le même que l'ancien";
					getLog($event,$post['mail']);
					header('Location: compte.php?error=3&b=2');
				}
				else{
					$pwd = checkPassword($post['oldPwd'],$post['mail'],"./info/info.csv");
					if (!($pwd)){
						$event = "Echec du changement de mot de passe : l'ancien mot de passe renseigné n'est pas le même que le mot de passe dans le fichier info.csv";
						getLog($event,$post['mail']);
						header('Location: compte.php?error=1&b=2');
						}
					else{
						changePassword($post['newPwd1'],$post['mail'],"./info/info.csv");
						$event = "Changement de mot de passe effectué avec succès";
						getLog($event,$mail);

						header("Location: compte.php");
					}
				}
			}
		}
	}
?>