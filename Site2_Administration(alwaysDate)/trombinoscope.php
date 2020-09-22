<?php
	session_start();
	if(empty($_SESSION['mail'])){
		header('Location: index.php');
	}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8"/>
	<title> Trombinoscope </title>
	<link rel="stylesheet" type="text/css" href="reset.css" media="screen"/>
	<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="reset.css" media="print"/>
	<link rel="stylesheet" type="text/css" href="impression.css" media="print"/>
	<script src="./fonction.inc.js"></script>
</head>
<body>
	<header>
		<div id="imageHeader">
			<a href="deconnexion.php" ><img src="assets/logoCY.png" alt="error" height="100"/></a>
		</div>
		<div id="titreHeader">
			<h1 id="titreH1Header"> Trombinoscope </h1>
		</div>
		<div id="boutonDroiteHeader">
			<button type='button' onclick="document.location.href = 'deconnexion.php'" style="margin-top: 17px;" class='boutonCo' id='boutonHeader' > D&#233;connexion </button>
		</div>
	</header>
<div id="infoTrombi">
	<form method="post" action="trombinoscope.php" id="formTrombi">
		<?php
		$jsonData = file_get_contents("https://thibault-beleguic.yo.fr/ProjetWeb2/filiere.json");
		$json = json_decode("$jsonData",true);
		echo("<div class='divInsCon'>");
			echo("<div class='divRowIns'>");
				echo("<div class='divColoneIns'>");
					echo("<label class='inscripInfo' for='SelectFiliere'> Fili&#232;re </label>");
					echo("<select id='SelectFiliere' name='filiere' size='1' onchange='setGroupe()'>");
						echo("<option class = 'form_ville'> --- Fili&#232;re --- </option>");
						for ($i=0; $i < 5; $i++) { 
							$filiere = $json['listeFilieres'][$i]['nomFiliere'];
							echo("<option class = 'form_ville' value='$filiere'> $filiere </option>");
						}
					echo("</select>");
				echo("</div>");
				echo("<div class='divColoneIns' id='decal'>");
					echo("<label class='inscripInfo' for='SelectGroupe'> Groupe </label>");
					echo("<select id='SelectGroupe' name='groupe' size='1' >");
						echo("<option class = 'form_ville'> Tous les groupes </option>");
					echo("</select>");
					?>
				</div>

			</div>
			<input type="button" value="Envoyer" onclick="checkOpTrombi();"/>
		</div>
	</form>
	<p id="errorFiliere" class="ErrorIns"></p>
</div>
<?php

			
	function getElement($table,$liste){
	
		for ($i=0; $i < sizeof($liste); $i++) { 
			$nom = explode(" ",$table["nom"]);
			$nom1 = $nom[0];
			$retour = array(
				'nom' => $nom1,
				'prenom' => $table["prenom"],
				'mail' => $table["mail"],
				'tel' => $table["tel"],
				'adressePostale' => $table["adressePostale"],
				'image' => $table["image"],
				 );
		}
		return $retour;
	}

	function getCookie($fi,$gr){
		$cookie = $fi."/".$gr;
		return $cookie;
	}
	

	if(!(empty($_POST))){
		$post = $_POST;
		$filiere = $post['filiere'];
		$groupe = $post['groupe'];
		$prefCookie = getCookie($filiere,$groupe);
		setcookie('pref',$prefCookie);
		$firstRecherche = false;
	}
	elseif (isset($_COOKIE['pref'])) {
		$cookie = explode("/", $_COOKIE['pref']);
		$filiere = $cookie[0];
		$groupe = $cookie[1];
		$firstRecherche = false;
	}
	else{
		$firstRecherche = true;
	}
	
	if($firstRecherche == true){
		echo("<h1 style='margin-bottom: 40px; margin-top: 20px;'> Faire une premi&#232;re recherche </h1>"); 
	}
	else{


		if($groupe == "Tous les groupes"){
			$jsonText = file_get_contents("https://thibault-beleguic.yo.fr/ProjetWeb2/api.php?apiKey=c591aa1cd1790d738126de4f544ffd&choix=1&filiere=".$filiere);
			
		}
		else{
			$jsonText = file_get_contents("https://thibault-beleguic.yo.fr/ProjetWeb2/api.php?apiKey=c591aa1cd1790d738126de4f544ffd&choix=2&filiere=".$filiere."&groupe=".$groupe);
		}
		
		$table = json_decode($jsonText,True);
		if(isset($table['error'])){
			$error = $table['error'];
			echo("<h1 id='errorAPI'> $error </h1>");
		}
		else{
			$listeGroupe = array();
			if($groupe == "Tous les groupes"){
				for ($z=0; $z < sizeof($json["listeFilieres"]); $z++) { 
					if($filiere == $json["listeFilieres"]["$z"]["nomFiliere"]){
						$l = $z;
					}
				}
				for ($b=0; $b < sizeof($json["listeFilieres"]["$l"]["groupes"]); $b++) { 
					$listeGroupe["$b"] = $json["listeFilieres"]["$l"]["groupes"]["$b"];
				}		
			}
			else{
				$listeGroupe["0"] = $groupe;
			}
			$cpt = 0;
			echo("<div id='BoutonImpression'>");
				echo("<input class=\"boutonCo\" type=\"button\" onclick=\"window.print();\" value=\"Imprimer le trombinoscope\" />");
			echo("</div>");
			for ($x=0; $x < sizeof($listeGroupe); $x++) { 
				$groupeChoix = $listeGroupe["$x"];
				$temoin = 0;
				$longueur = sizeof($table["$filiere"]["$groupeChoix"]);
				$liste = array('nom','prenom','mail','tel','image');
				echo("<div class='divTitre'>");
					echo("<h1> $filiere - groupe : ".$listeGroupe["$x"]." </h1>");
				echo("</div>");
				echo("<div class='mosaique'>");
				for ($i=0; $i < $longueur; $i++) {
					$cpt ++;
					$temoin ++;
					$info = getElement($table["$filiere"]["$groupeChoix"]["$i"],$liste);
					echo("<div class='divEleve'>");
						echo("<img class='image' src=\"http://thibault-beleguic.yo.fr/ProjetWeb2/image/".$info["image"]."\" onerror=\"this.onerror=null;this.src='http://thibault-beleguic.yo.fr/ProjetWeb2/image/account.png';\" alt='Error' onclick=\"showInfo($cpt)\" />");
						echo("<div class='nomPrenom'>");
							echo("<p class='paraPrint'>".$info["nom"]."</p>"); 
							echo("<p class='paraPrint'>".$info["prenom"]."</p>");
						echo("</div>");
						echo("<div style=\"display: none;\">");
							echo("<p class=\"$cpt\">".$info["nom"]."</p>"); 
							echo("<p class=\"$cpt\">".$info["prenom"]."</p>");
							echo("<p class=\"$cpt\">".$info['mail']."</p>");
							echo("<p class=\"$cpt\">".$info['tel']."</p>");
							echo("<p class=\"$cpt\">".$info['adressePostale']."</p>");
							echo("<p class=\"$cpt\">https://thibault-beleguic.yo.fr/ProjetWeb2/image/".$info['image']."</p>");
						echo("</div>");
					echo("</div>");
					if($temoin == 32){
						$temoin = 0;
						echo("<div class='cacher'>");
						echo("</div>");
					}
				}
				echo("</div>");
			}
		}
		?>
		<div id="divInfoEleve2">
			<div id="divInfoEleve">
				<div class="divRow">
					<?php
					echo("<img class=\"infoStud\" style=\"margin-top: 5px;\" id ='6' src=\"http://thibault-beleguic.yo.fr/ProjetWeb2/image/account.png\" onerror=\"this.onerror=null;this.src='http://thibault-beleguic.yo.fr/ProjetWeb2/image/account.png';\" width=\"180\" height=\"180\" alt=\"Error\"/>");
					?>
					<div class="divColone">
						<div class="divRow">
							<div class="divColone">
								<p class="infoStud" id='1'></p>
								<p class="infoStud" id='2'></p>
							</div>
							<div class="divColone">
								<p class="infoStud" id='3'></p>
								<p class="infoStud" id='4'></p>
							</div>
						</div>
						<div class="divRow">
							<p class="infoStud" id='5'></p>
						</div>
					</div>
				</div>
				
			
			</div>
		</div>
		<?php
		}
		?>
	<footer>
			
		<p id="paramFooter"> Copyright 2020 - Thibault Beleguic - Universit&#233; de Cergy-Pontoise </p>

	</footer>

	<script>
		function setGroupe(){
			chargerGroupe( <?php echo($jsonData) ?> );
				//	
		}

	</script>

</body>
</html>



