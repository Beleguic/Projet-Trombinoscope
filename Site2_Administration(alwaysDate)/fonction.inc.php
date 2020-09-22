<?php

	function getlog($event,$id){
		$date = date('d/m/o - H:i:s -');
		$data = $date.";".$id.";".$event."\n";
		file_put_contents("./info/logs.csv",$data,FILE_APPEND | LOCK_EX);	
	}

	function verifSet($table,$liste){
		for ($i=0; $i < sizeof($liste); $i++){ 
			if (!isset($table[$liste[$i]]) || $table[$liste[$i]] == ""){
				return false;
			}
		}
		return true;
	}

	function fhashPwd($alea,$pwd){

		$mdpAlea = $pwd.$alea;
		$mdpAlea = hash('sha256',$mdpAlea);
		return $mdpAlea;
	}

	function connexion($table,$fichier){

		$retour = array();

		$mail = $table['adresseMail']; 
		$mdp = $table['motDePasse'];
		
		$fichier = fopen("$fichier", "r");

		$connexion = "false";

		while(!feof($fichier)){
			$info = fgets($fichier);
			if($info != ""){
				$info2 = substr($info,0,-2);
				$ligne = explode(";",$info2);
				$long = sizeof($ligne)-1;
				$alea = $ligne[$long];
				$mdpAlea = fhashPwd($alea,$mdp);
				if($mail == $ligne[2]){
					if($mdpAlea == $ligne[$long-1]){
						$connexion = "true";
						$nom = $ligne[0];
					}
					else{
						$connexion = "false";
						$nom = "";
					}
				}
				else{
					$connexion = "false";
					$nom = "";
				}
			}
		}
		$retour['connexion'] = $connexion;
		$retour['nom'] = $nom; 
		$retour['mail'] = $mail;
		return $retour;
	}

	function checkFormat($pattern,$check){
		if(preg_match($pattern, $check)){
			return true;
		}
		else{
			return false;
		}
	}

	function verifDonnee($table,$liste){

		$patMail = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";
		$patTel = "/^\d{10}$/";
		$patPWD = "/^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)([^;]).*$/";
		$patPV = "/^[^;]*$/";

		$mail = $table['adresseMail'];
		if (isset($table['telephone'])) {
			$tel = $table['telephone'];
		}
		else{
			$tel = "1425369870";
		}
		$mdp = $table['motDePasse'];


		$errMail = checkFormat($patMail,$mail);
		if($errMail){
			$errTel = checkFormat($patTel,$tel);
			if($errTel){
				$errPWD = checkFormat($patPWD,$mdp);
				if($errPWD){
					$suite = true;
				}
				else{
					$suite = false;
				}
			}
			else{
				$suite = false;
			}
		}
		else{
			$suite = false;
		}

		if($suite = true){
			for ($i=0; $i < sizeof($liste); $i++){ 
				if(checkFormat($patPV,$table[$liste[$i]])){
					$errPv = true;
				}
				else{
					return false;
				}
			}
		}
		else{
			return false;
		}
		if($errPv == true){
			return true;
		}
	}
	
	function verifDoublons($table){
		
		$fichier = fopen("./info/info.csv", "r");

		$err = array();
		$err["etat"] = "";
		$err["ErrTEL"] = "";
		$err["ErrMail"] = "";

		while(!feof($fichier)){
			$info = fgets($fichier);
			if($info != ""){
				$info2 = substr($info,0,-2);
				$ligne = explode(";",$info2);

				if($table['adresseMail'] == $ligne[2]){
					$incMail = true;
				}
				else{
					$incMail = false;
				}
				if(isset($table['telephone'])){
					if($table['telephone'] == $ligne[3]){
						$incTel = true;
					}
					else{
						$incTel = false;
					}
				}
				else{
					$incTel = false;
				}

				if($incMail == true || $incTel == true){
				$err["ErrTEL"] = $incTel;
				$err["ErrMail"] = $incMail;
				$err["etat"] = false;
				return $err;
				}
			}
		}
		$err["ErrTEL"] = false;
		$err["ErrMail"] = false;
		$err["etat"] = true;
		return $err;	
	}



	function inscription($table,$liste,$fichier,$image){

		if($image != ""){
			$nom_image = $table['adresseMail'].".png";
			$image_tmp_name=$image['image']['tmp_name'];
			move_uploaded_file($image_tmp_name, "image/$nom_image");
		}

		$data = "";

		for ($i=0; $i < sizeof($liste); $i++){ 
			if($liste[$i] == "motDePasse"){
				$alea = hash('sha256',uniqid($table['nom']));
				$pwd = fhashPwd($alea, $table[$liste[$i]]);
				$data = $data.$pwd.";";
			}
			elseif ($liste[$i] == "groupe") {
				$data = $data.$table[$liste[$i]].";";
				$data = $data.$table['adresseMail'].".png".";";
			}
			else{
				$data = $data.$table[$liste[$i]].";";
			}
		}
		$data = $data.$alea.";"."\n";
		$fichier = fopen("$fichier", "a");
		fputs($fichier,$data);
		fclose($fichier);
		return true;
	}

	function verifImage($image){

		$type_image = $image['image']['type'];
		$taille_image = $image['image']['size'];
		$error = $image['image']['error'];
		$infoImage = getimagesize($image['image']['tmp_name']);
		if($error == 0){
			if($infoImage[0] <= 512 && $infoImage[1] <= 512){
				if($taille_image <= 2000000){
					if($type_image == "image/png" || $type_image == "image/jpeg"|| $type_image == "image/jpg"){
						return true;
					}
					else{
						return false;
					}
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}

	function checkEgalePassword($pass1,$pass2){
		if($pass1 == $pass2){
			return true;
		}
		else{
			return false;
		}

	}

	function checkSamePassword($oldPassword,$newPassword){
		if($oldPassword != $newPassword){
			return true;
		}
		else{
			return false;
		}
	}

	function checkPassword($oldPassword,$mail,$fichierL){

		$fichier = fopen($fichierL, 'r');

		while (!feof($fichier)){
			$line = fgets($fichier);
			if($line != ""){
				$password2 = substr($line,0,-2);
				$password = explode(';', $password2);
				$long = sizeof($password)-1;
				$alea = $password[$long];
				$passAlea = fhashPwd($alea,$oldPassword);
				$name = $password[2];
				$password = $password[$long-1];
				if ($passAlea == $password){
					if ($mail == $name) {
						return true;
					}
				}
			}
		}
		return false;
	}

	function checkMail($mail,$id,$fichierL){
		$fichier = fopen($fichierL, 'r');

		while (!feof($fichier)){
			$line = fgets($fichier);
			if($line != ""){
				$checkmail = explode(';', $line);
				$name = rtrim($checkmail[0]);
				$checkmail = rtrim($checkmail[2]);
				if ($mail == $checkmail && $id == $name){
					return true;
				}
			}
		}
		return false;
	}

	function changePassword($new,$mail,$fichierL){
		

		$id = $_SESSION['name'];

		$fichier = fopen($fichierL, 'r');

		$newFichier = array();
		
		while ($info = fgets($fichier)){
			if($info != ""){
				$info2 = substr($info,0,-2);
				$line = explode(';', $info2);
			
				$alea = $line[9];


				if ($id == $line[0] && $mail == $line[2]){
					$passwd = $new.$alea;
					$passwdalea = hash('sha256', $passwd);
					$chaine = rtrim($id) . ";" . rtrim($line[1]) . ";" . rtrim($mail) . ";" . rtrim($line[3]) . ";" . rtrim($line[4]) .";" . rtrim($line[5]) .";" . rtrim($line[6]) . ";" . rtrim($line[7]) . ";" . rtrim($passwdalea) . ";" . rtrim($line[9]) . ";";
					array_push($newFichier, $chaine);
				}
				else{
					$chaine = rtrim($line[0]) . ";" . rtrim($line[1]) . ";" . rtrim($line[2]) . ";" . rtrim($line[3]) . ";" . rtrim($line[4]) . ";" . rtrim($line[5]) . ";" . rtrim($line[6]) . ";" . rtrim($line[7]) . ";" . rtrim($line[8]) . ";". rtrim($line[9]) . ";";
					array_push($newFichier, $chaine);
				}
			}
		}
		fclose($fichier);
		$fichier = fopen('./info/info.csv', 'w');
		for ($k = 0; $k < sizeof($newFichier); $k++){
			fputs($fichier, $newFichier[$k] . "\n");
		}
		fclose($fichier);
	}

	function changeInfo($table,$change,$liste,$fichierL,$image){
		$new = $table['motDePasse'];
		$id = $_SESSION['name'];

		$fichier = fopen($fichierL, 'r');

		$newFichier = array();
		$chaine = "";
		$mailacc = $table['mail2'];

		while ($info = fgets($fichier)){
			if($info != ""){
				$info2 = substr($info,0,-2);
				$line = explode(';', $info2);
				
				$alea = $line[9];
				$passwdalea = fhashPwd($alea,$new);

				if ($id == $line[0] && $passwdalea == $line[8] && $mailacc == $line[2]){
					for ($j=0; $j < sizeof($liste); $j++){ 
						if($change[$j] == "y"){

							$chaine = $chaine . rtrim($table[$liste[$j]]) . ";";
							if($liste[$j] == "adresseMail"){
								$_SESSION['mail'] = $table['adresseMail'];
							}
							if($liste[$j] == "nom"){
								$_SESSION['name'] = $table['nom'];
							}
						}
						else{
							$chaine = $chaine . rtrim($line[$j]) . ";";
						}
					}
					if($change[2] == "z"){
						$chaine = $chaine . rtrim($line[7]) . ";";
					}
					else{
						$img = $table['adresseMail'].".png";
						$chaine = $chaine . rtrim($img) . ";";
					}
					$chaine = $chaine . rtrim($line[8]) . ";". rtrim($line[9]) . ";";
					array_push($newFichier, $chaine);
					$chaine = "";
					

				}
				else{
					$chaine = rtrim($line[0]) . ";" . rtrim($line[1]) . ";" . rtrim($line[2]) . ";" . rtrim($line[3]) . ";" . rtrim($line[4]) . ";" . rtrim($line[5]) . ";" . rtrim($line[6]) . ";" . rtrim($line[7]) . ";" . rtrim($line[8]) . ";" . rtrim($line[9]) . ";";
					array_push($newFichier, $chaine);
					$chaine = "";
				}
			}
		}
		fclose($fichier);
		$fichier = fopen($fichierL, 'w');
		for ($k = 0; $k < sizeof($newFichier); $k++){
			fputs($fichier, $newFichier[$k] . "\n");
		}
		fclose($fichier);

		if($image['image']['tmp_name'] != ""){
			if($change[2] == "z"){
				$nom_image = $_SESSION['mail'].".png";
			}
			else{
				$nomAI = $mailacc.".png";
				unlink("image/$nomAI");
				$nom_image = $table["adresseMail"].".png";
				
			}
			$image_tmp_name=$image['image']['tmp_name'];
			move_uploaded_file($image_tmp_name, "./image/$nom_image");
		}
		else{
			if($change[2] == "y"){
				$oldIMG = $mailacc.".png"; 
				$newIMG = $_SESSION['mail'].".png";
				rename("image/$oldIMG", "image/$newIMG");
			}
		}

		$event = getEventCI($change,$liste,$table);

		if($change[2] == "z"){
			$mail = $_SESSION['mail'];
		}
		else{
			$mail = $table[$liste[2]];
		}

		getLog($event,$mail);

	}

	function getEventCI($change,$liste,$table){

		$donner = "";
		for ($i=0; $i < sizeof($liste); $i++){
			if($change[$i] == "y"){
				$donner = $donner.$liste[$i]." , ";
			}
		}
		if($change[2] == "z"){
			$mail = $_SESSION['mail'];
			$event = "Modification des informations suivantes : ".$donner;
		}
		else{
			$mail2 = $table['mail2'];
			$mail = $table[$liste[2]];
			$event = "Modification des informations suivantes : ".$donner." , ancien mail = $mail2, nouveau mail = $mail";
		}

		return $event;
	}
	
	function traiteInfo($table,$liste){
		$change = "";
		for ($i=0; $i < sizeof($liste); $i++){ 
			if ($table[$liste[$i]] == ""){
				$change = $change.'z'.';';
			}
			else{
				$change = $change.'y'.';';
			}
		}
		$change = explode(';', $change);
		return $change;
	}



	function checkInfoPV($liste,$table){
		$NPPformat = "/^[^;]*$/"; 
		for ($i=0; $i < sizeof($liste); $i++){ 
			if ($table[$liste[$i]] != ""){
				if(!(checkFormat($NPPformat,$table[$liste[$i]]))){
					return false;
				}
			}
		}
		return true;
	}


	function checkPwd($table){
		
		$pass1 = $table['motDePasse'];
		$pass2 = $table['motDePasse2'];
		$patPWD = "/^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)([^;]).*$/";
		$format = checkFormat($patPWD,$pass1);
		$egale = checkEgalePassword($pass1,$pass2);
		if($egale == true && $format == true){
			return true;
		}
		else{
			return false;
		}
	}

	function searchKeyJson($table,$liste){

		$jsonText = file_get_contents("./info/apiKey.json");
		$json = json_decode($jsonText,true);

		$mail = $table[$liste[0]];
		$pwd = $table[$liste[1]];

		foreach ($json as $infos) {
			if($infos['mail'] == $mail){
				$alea = $infos['alea'];
				$pwdalea = fhashPwd($alea,$pwd);
				if($infos['pwd'] == $pwdalea){
					$key = $infos['key'];
					return $key;
				}
			}
		}
		return false;
	}

	function createAPIKey($table){
		$jsonText = file_get_contents("./info/apiKey.json");
		$json = json_decode($jsonText);
		$mail = $table['adresseMail'];
		$mailhash = hash('sha256', $mail);
		$key = substr($mailhash,0,30);
		$date = time();
		$uti = 0;
		$alea = hash('sha256', uniqid());
		$pwd = $table['motDePasse'];
		$mdpalea = fhashPwd($alea,$pwd);
		$json2 = array();
		$json2["key"] = $key;
		$json2["mail"] = $mail;
		$json2["pwd"] = $mdpalea;
		$json2["alea"] = $alea;
		$json2["date"] = $date;
		$json2["uti"] = $uti;
		$json[] = $json2;
		$jsonTextEncode = json_encode($json);
		$fichier = fopen("./info/apiKey.json", "w");
		fputs($fichier,$jsonTextEncode);
		fclose($fichier);
		return $key;
	} 

	function checkMailJson($table){
		$mail = $table['adresseMail'];
		$patMail = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";
		if(checkFormat($patMail,$mail)){
			$jsonText = file_get_contents("./info/apiKey.json");
			$json = json_decode($jsonText,true);

			$mailCheck = "false";

			foreach ($json as $infos) {
				if($infos['mail'] == $mail){
					$mailCheck = "false2";
					return $mailCheck;
				}
			}
			$mailCheck = "true";
		}
		else{
			$mailCheck = "false";
		}
		return $mailCheck;
	}
?>