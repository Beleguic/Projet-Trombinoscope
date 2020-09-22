<?php
	session_start();

	if(empty($_SESSION["name"])){
		header("Location: index.php");
	}
	else{
		$mail = $_SESSION["mail"];
		$fichier = fopen("./info/info.csv", "r");
		while(!feof($fichier)){
			$info = fgets($fichier);
			if($info != ""){
				$info2 = substr($info,0,-2);
				$ligne = explode(";",$info2);
				if($mail == $ligne[2]){
					$nom = $ligne[0];
					$prenom = $ligne[1];
					$mail = $ligne[2];
					$telephone = $ligne[3];
					$adressePostale = $ligne[4];
					$filiere = $ligne[5];
					$groupe = $ligne[6];
					$image = $ligne[7];
					break;
				}
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<title> Compte </title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="reset.css"/>
	<link rel="stylesheet" type="text/css" href="style.css"/>
	<script src="./fonction.inc.js"></script>
</head>
<body <?php if(isset($_GET['b'])){ ?> onload="setDivi()" <?php } ?> >
	<header>
		<div class="divRow">
			<div id="imageHeader">
				<a href="index.php" ><img src="assets/logoCY.png" alt="error" height="100"/></a>
			</div>
			<div id="titreHeader">
				<h1> Compte &#233;tudiant </h1>
			</div>
			<div id="boutonDroiteHeader">
				<?php 
					if(empty($_SESSION['mail'])){
						echo("<button style=\"margin-top: 17px;\" class='boutonCo' type='button' onclick=\"document.location.href = 'index.php'\"> Connexion</button>");
					}else{
						echo("<button style=\"margin-top: 17px;\" class='boutonCo' type='button' onclick=\"document.location.href = 'compte.php'\"> Mon profil </button>");
					}
				?>
				<button style="margin-top: 17px;" class='boutonCo' type='button' onclick="document.location.href = 'admin.php'"> Services </button>
			</div>
		</div>
	</header>
	<h1>Profil de <?php echo($prenom);?> <?php echo($nom);?></h1>
	<div class="divRow" id="divInfo">
		<div id="divImage">
			<img src="./image/<?php echo($image); ?>" onerror="this.onerror=null;this.src='http://thibault-beleguic.yo.fr/ProjetWeb2/image/account.png';" alt="Error" height="450" width="450"/>
		</div>
		<div id="divInfotxt">
			<p> Nom : <?php echo($nom); ?> </p>
			<p> Pr&#233;nom : <?php echo($prenom); ?> </p>
			<p> Adresse mail : <?php echo($mail); ?> </p>
			<p> T&#233;l&#233;phone : <?php echo($telephone); ?> </p>
			<p> Adresse postale : <?php echo($adressePostale); ?> </p>
			<p> Fili&#232;re : <?php echo($filiere); ?> </p>
			<p> Groupe : <?php echo($groupe); ?> </p>
		</div>
	</div>
	<div id="DivChangeCompte">
		<div class="divRow" id="divBouton">
			<button class="boutonCo" type="button" onclick="changeDiv1()"> 
			Modifier les informations </button>
			<button class="boutonCo" type="button" onclick="changeDiv2()" > Modifier le mot de passe </button>
			<button class="boutonCo" type="button" onclick="document.location.href = 'deconnexion.php'"> D&#233;connexion </button>
		</div>
	</div>

	<div id="formulaireChangeDiv1">
		<h1 id="FormInscriptionText">Modifier les informations du compte</h1>
		<form enctype="multipart/form-data" action="changeINFO.php" method="post" id="formulaireModifInfo">
			<div class = "divInsCon">
				<div class="divRow">
					<div class="divColone"> 
						<label class="inscripInfo" for="modif_nom"> Nom  </label>
						<input id="modif_nom" type="text" name="nom" placeholder="<?php echo($nom); ?>"/>
						<label class="inscripInfo" for="modif_prenom"> Pr&#233;nom </label> 
						<input id="modif_prenom" type="text" name="prenom" placeholder="<?php echo($prenom); ?>"/>
					</div>
					<div class="divColone"> 
						<label class="inscripInfo" for="modif_mail"> Adresse mail </label>
						<input id="modif_mail" type="email" name="adresseMail" placeholder="<?php echo($mail); ?>"/>
						<label class="inscripInfo" for="modif_telephone"> T&#233;l&#233;phone </label>
						<input id="modif_telephone" type="text" name="telephone" placeholder="<?php echo($telephone); ?>"/>
						</div>
				</div>
				
				<?php
					$jsonData = file_get_contents("filiere.json");
					$json = json_decode("$jsonData",true);
					echo("<div class='divRow'>");
						echo("<div class='divColone'>");
							echo("<label class='inscripInfo' for='SelectFiliere'> Fili&#232;re </label>");
							echo("<select id='SelectFiliere' name='filiere' size='1' onchange='setGroupe()'>");
								echo("<option class = 'form_ville'> $filiere </option>");
								for ($i=0; $i < 5; $i++) { 
									$filieres = $json['listeFilieres'][$i]['nomFiliere'];
									echo("<option class = 'form_ville' value='$filieres'> $filieres </option>");
								}
							echo("</select>");
						echo("</div>");
						echo("<div class='divColone'>");
							echo("<label class='inscripInfo' for='SelectGroupe'> Groupe </label>");
							echo("<select id='SelectGroupe' name='groupe' size='1' >");
								echo("<option class = 'form_ville'> $groupe </option>");
							echo("</select>");
						echo("</div>");
					echo("</div>");
				?>
				
				<div class="divColone" style="width: 100%;">
					<label class="inscripInfo" for="modif_adressePostale"> Adresse Postale </label>
					<input id="modif_adressePostale" type="text" name="adressePostale" placeholder="<?php echo($adressePostale); ?>"/>
					<label class="inscripInfo" for="image"> Image </label>
					<input id="image" type="file" name="image" accept=".jpg, .jpeg, .png"/>
				</div>
				<p class="InfoForm"> Saisir les mots de passe actuels pour faire le changement </p>
				<div class="divRow">
					<div class="divColone">
						<label class="inscripInfo" for="modif_pass1"> Mot de passe* </label>
						<input id="modif_pass1" type="password" name="motDePasse" placeholder="Mot de passe"/>
					</div>
					<div class="divColone">
						<label class="inscripInfo" for="modif_pass2"> Confirmation du mot de passe* </label>
						<input id="modif_pass2" type="password" name="motDePasse2" placeholder="Mot de passe"/>
					</div>
				</div>
				<div class="divRow">
					<div class="divColone" style="width: 100%;">
						<input id="mailHidden" type="hidden" name="mail2" value="<?php echo($mail); ?>"/>
						<input type="button" value="Modifier les informations" onclick="checkIncripCompte()"/>
						<p class="InfoForm">* 8 caract&#232;res minimum</p>
					</div>
				</div>
				<div class="divColone" style="width: 100%;">
					<p id = "Error;1" class="ErrorIns"></p>
					<p id = "ErrorChamp1" class="ErrorIns"></p>
					<p id = "ErrorLOGIN1" class="ErrorIns"></p>
					<p id = "ErrorLPWD1" class="ErrorIns"></p>
					<p id = "ErrorMAIL1" class="ErrorIns"></p>
					<p id = "ErrorEPWD1" class="ErrorIns"></p>
					<p id = "ErrorSPWD1" class="ErrorIns"></p>
					<p id = "ErrorTEL1" class="ErrorIns"></p>
				</div>
			</div>
			
			<?php
				$error = isset($_GET['error']) ? $_GET['error'] : NULL;
				if($error == 11){
					echo("<p class='ErrorIns'> Un ou plusieurs champs contiennent un \";\" </p>");
				}
				elseif ($error == 12) {
					echo("<p class='ErrorIns'> Le mail est d&#233;j&#224; utilis&#233; </p>");
				}
				elseif ($error == 13) {
					echo("<p class='ErrorIns'> Le t&#233;l&#233;phone est d&#233;j&#224; utilis&#233; </p>");
				}	
				elseif ($error == 14) {
					echo("<p class='ErrorIns'> Le mot de passe est incorrect </p>");
				}
				elseif ($error == 15) {
					echo("<p class='ErrorIns'> la photo doit avoir une dimension maximale de 512px par 512px et ne doit pas d&#233;passer 2MO </p>");
				}
			?>
			
		</form>
	</div>

	<div id="formulaireChangeDiv2">
		<h1 id="infoChangePwd"> Changer le mot de passe </h1>
		<form action="changePWD.php" method="post" id="formChangePwd">
			<div class = "divChangePwd">
				<div class="divRow2">
					<div class="divColone" style="width: 100%;">
						<label class="inscripInfo" for="change_mail"> Adresse Mail </label>
						<input id="change_mail" type="email" name="mail" placeholder="Adresse Mail"/>
						<label class="inscripInfo" for="change_passOld"> Ancien mot de passe </label>
						<input id="change_passOld" type="password" name="oldPwd" placeholder="Ancien mot de passe"/>
					</div>
					<div class="divColone" style="width: 100%;">
						<label class="inscripInfo" for="change_pass1"> Nouveau mot de passe* </label>
						<input id="change_pass1" type="password" name="newPwd1" placeholder="Nouveau mot de passe"/>
						<label class="inscripInfo" for="change_pass2"> Confirmation du nouveau mot de passe* </label>
						<input id="change_pass2" type="password" name="newPwd2" placeholder="Confirmation du nouveau mot de passe"/>
					</div>
				</div>
				<div class="divRow2">
					<div class="divColone" style="width: 100%;">
						<input type="button" value="Changer le mot de passe" onclick="checkNewPwd()"/>
						<p class="InfoForm">* 8 caract&#232;res minimum</p>
					</div>
				</div>
				<div class="divColone" style="width: 100%;">
					<p id = "ErrorLPWD" class="ErrorIns"></p>
					<p id = "ErrorMAIL" class="ErrorIns"></p>
					<p id = "ErrorEPWD" class="ErrorIns"></p>
					<p id = "ErrorSPWD" class="ErrorIns"></p>
					<?php
						$error = isset($_GET["error"]) ? $_GET["error"] : NULL;
						if($error == 1){
							echo("<p class='ErrorIns'> L'ancien mot de passe n'est pas bon ! </p>");
						}
						if($error == 2){
							echo("<p class='ErrorIns'> Le mail n'est pas bon ! </p>");
						}
						if($error == 3){
							echo("<p class='ErrorIns'> L'ancien mot de passe et le nouveau mot de passe sont &#233;gaux ! </p>");
						}
						if($error == 4){
							echo("<p class='ErrorIns'> Le nouveau mot de passe doit contenir au moins 1 majuscule, 1 minuscule, 1 chiffre et 1 caract&#233;re sp&#233;cial </p>");
						}
						if($error == 5){
							echo("<p class='ErrorIns'> Les deux nouveaux mots de passe ne sont pas &#233;gaux </p>");
						}
						?>
				</div>
			</div>
		</form>
	</div>
	<footer>
			
		<p> Copyright 2020 - Thibault Beleguic - Universit&#233; de Cergy-Pontoise </p>

	</footer>

	<script>

		function setDivi(){
			var b = <?php if(isset($_GET['b'])){ echo($_GET['b']); }else{ echo ("0");}  ?>;
			if(typeof b != undefined){
				if(b == 1){
					changeDiv1();
				}
				if(b == 2){
					changeDiv2();	
				}
			}
		}
		

		function setGroupe(){
			chargerGroupe( <?php echo($jsonData) ?> );

		}

	</script>

</body>
</html>