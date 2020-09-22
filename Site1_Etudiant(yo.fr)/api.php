<?php
	include "fonction.inc.php";

	function trieFiliere($filiere){

		$fichier = fopen("./info/info.csv", "r");

		while(!feof($fichier)){
			$info = fgets($fichier);
			if($info != ""){
				$info2 = substr($info,0,-2);
				$ligne = explode(";",$info2);

				// trie par filliere
				if($ligne[5] == $filiere){
					$groupe = $ligne[6];
					$tableTMP = array();
					$tel = $ligne[3];

					if(strlen($ligne[3]) != 10){
						$tel = "0".$ligne[3];
					}
					else{
						$tel = $ligne[3];
					}
					$tableTMP["nom"] = $ligne[0];
					$tableTMP["prenom"] = $ligne[1];
					$tableTMP["mail"] = $ligne[2];
					$tableTMP["tel"] = $tel;
					$tableTMP["adressePostale"] = $ligne[4];
					$tableTMP["image"] = $ligne[7];
					$table["$filiere"]["$groupe"]["$ligne[0]"] = $tableTMP;
					asort($table[$filiere][$groupe]);
					sort($table[$filiere][$groupe]);
					
				}
			}
		}
		arsort($table[$filiere]);
		return $table;

	}

	function trieGroupe($filiere,$groupe){

		$fichier = fopen("./info/info.csv", "r");

		while(!feof($fichier)){
			$info = fgets($fichier);
			if($info != ""){
				$info2 = substr($info,0,-2);
				$ligne = explode(";",$info2);



				if($ligne[5] == $filiere){
					if($ligne[6] == $groupe){

						if(strlen($ligne[3]) != 10){
							$tel = "0".$ligne[3];
						}
						else{
							$tel = $ligne[3];
						}
						$tableTMP = array();
						$tableTMP["nom"] = $ligne[0];
						$tableTMP["prenom"] = $ligne[1];
						$tableTMP["mail"] = $ligne[2];
						$tableTMP["tel"] = $tel;
						$tableTMP["adressePostale"] = $ligne[4];
						$tableTMP["image"] = $ligne[7];
						$table["$filiere"]["$groupe"]["$ligne[0]"] = $tableTMP;
						asort($table[$filiere][$groupe]);
						sort($table[$filiere][$groupe]);
					}
				}	
			}
		}
		arsort($table[$filiere]);
		return $table;

	}

	function generateJSONLog($debut,$fin){

		$fichier = fopen("./info/logs.csv", "r");

		$table = array();
		$tmp = array();

		$debut = date('d/m/o - H:i:s -',strtotime($debut));
		$fin = date('d/m/o - H:i:s -',strtotime($fin));

		while(!feof($fichier)){
			$info = fgets($fichier);
			if($info != ""){
				$info2 = substr($info,0,-1);
				$ligne = explode(";",$info2);
				if($debut < $ligne[0] && $fin > $ligne[0]){
					$tmp['date'] = $ligne[0];
					$tmp['id'] = $ligne[1];
					$tmp['event'] = $ligne[2];
					$table[] = $tmp;
				}
			}
		}
		return $table;
	}

	function verifApiKey($apiKey){
		$jsonText = file_get_contents("./info/apiKey.json");
		$json = json_decode($jsonText,true);

		foreach ($json as $infos){
			if($infos['key'] == $apiKey){
				return true;
			}
		}
		return false;
	}

	function refreshCompteur($apiKey){
		$jsonText = file_get_contents("./info/apiKey.json");
		$json = json_decode($jsonText,true);

		foreach ($json as $infos) {
			if($infos['key'] == $apiKey){
				$dateJSON = date('d:H',$infos['date']);
				$dateActu = date('d:H',time());
				if($dateJSON != $dateActu){
					$infos['uti'] = 1;
					$infos['date'] = time();
				}
				else{
					$infos['uti'] += 1;
					$compteur = $infos['uti'];
				}
				$json2[] = $infos;
			}
			else{
				$json2[] = $infos;
			}
		}
		$jsonTextEncode = json_encode($json2,true);
		$fichier = fopen("./info/apiKey.json", "w");
		fputs($fichier,$jsonTextEncode);
		fclose($fichier);

		return $compteur;
	}

	function getEvent($choix,$filiere,$groupe){
		if($groupe == ""){

		}
		if($choix == 1){
			$event = "demande de la filière : $filiere";
		}
		if($choix == 2){
			$event = "demande du groupe : $groupe de la filière : $filiere";
		}
		return $event;
	}

	$table = array();
	if(!isset($_GET['apiKey'])){
		$apiKey = "pas de clé d'API spécifiée";
  	}
  	else{
		$apiKey = $_GET['apiKey'];
  	}
  	if(!isset($_GET['choix'])){
		$choix = "0";
  	}
  	else{
  		$choix = $_GET['choix'];
  	}

  	


  	if($choix == 1){
  		$filiere = $_GET['filiere'];
  	}
  	if($choix == 2){
  		$filiere = $_GET['filiere'];
		$groupe = $_GET['groupe'];
  	}

	$verif = verifApiKey($apiKey);
	if($verif == true){
		$compteur = refreshCompteur($apiKey);
		if($compteur < 61){
			if($choix == "1"){	
				$event = getEvent($choix,$filiere,"");
				getlog($event,$apiKey);
				$table = trieFiliere($filiere);
			}
			elseif ($choix == "2"){
				$event = getEvent($choix,$filiere,$groupe);
				getlog($event,$apiKey);
				$table = trieGroupe($filiere,$groupe);
			}
		}else{
			$event = "a fait une requête, sans succès. trop de requêtes dans l'heure";
			getlog($event,$apiKey);
			$table['error'] = "Erreur, il y a eu trop de requêtes avec la même clé dans l'heure.";
		}
	}
	else{
		$event = "a fait une requête, sans succès. n'est pas dans les clés d'API valides.";
		getlog($event,$apiKey);
		$table['error'] = "Erreur, la clé d'API n'est pas bonne.";
	}

	/*
	choix 1 = renvoie une filiere complete
	choix 2 = renvoie un groupe complet
	choix 3 = renvoie le fichier des logs
	choix x = nouveau besoin

	// utilisation de l'api, nombre de utilisation par cle d'api, comparer heure actuelle avec heure du json apiKey.json
	Si les heure sont differente -> uti = 0 et on met a jour le timestamp
	Sinon, uti += 1 et on change pas le timestamp
	uti max = 60 par heure.
	*/

  	$data = $table;
    $data = json_encode($data,true);
	header("Content-type: application/json");
	echo($data);

?>