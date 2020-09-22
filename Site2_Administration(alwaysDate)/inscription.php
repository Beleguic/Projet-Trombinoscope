<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<title> Inscription </title>
		<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="reset.css"/>
	<link rel="stylesheet" type="text/css" href="style.css"/>
	<script src="./fonction.inc.js"></script>
</head>
<body>
	<header>
		<div id="imageHeader">
			<a href="deconnexion.php" ><img src="assets/logoCY.png" alt="error" height="100"/></a>
		</div>
		<div id="titreHeader">
			<h1 id="titreH1Header"> Authentification </h1>
		</div>
		<div id="boutonDroiteHeader">
			<button type='button' onclick="document.location.href = 'index.php'" style="margin-top: 17px;" class='boutonCo' id='boutonHeader' > Connexion </button>
		</div>
	</header>
	<form enctype="multipart/form-data" action="scriptInscription.php" method="post" id="formulaire_inscription">
		<div class = "divInsCon">
			<h1 id="FormInscriptionText">Inscription</h1>
			<div class="divRowIns">
				<div class="divColoneIns">
				<label class="inscripInfo" for="inscrip_nom"> Nom  </label>
				<input id='inscrip_nom' type="text" name="nom" placeholder="Nom"/>
				</div>
				<div class="divColoneIns" id="decal">
				<label class="inscripInfo" for="inscrip_prenom"> Pr&#233;nom </label> 
				<input id='inscrip_prenom' type="text" name="prenom" placeholder="Pr&#233;nom"/>
				</div>
			</div>
			<label class="inscripInfo" for="inscrp_mail"> Adresse mail </label>
			<input id="inscrp_mail" type="text" name="adresseMail" placeholder="Adresse mail"/>
			<label class="inscripInfo" for="inscrp_pass1"> Mot de passe* </label>
			<input id="inscrp_pass1" type="password" name="motDePasse" placeholder="Mot de passe"/>
			<label class="inscripInfo" for="inscrp_pass2"> Confirmation du mot de passe* </label>
			<input id="inscrp_pass2" type="password" name="motDePasse2" placeholder="Mot de passe"/>
			<input type="button" value="Inscription" onclick="checkIncrip();"/>
			<a class="lien" href="index.php"> J'ai d&#233;ja un compte</a>
			<p class="InfoForm" >* 8 caract&#232;res minimum</p>
		</div>
	</form>
			<div class="divColone">
				<p id = "Error;" class="ErrorIns"></p>
				<p id = "ErrorChamp" class="ErrorIns"></p>
				<p id = "ErrorLOGIN" class="ErrorIns"></p>
				<p id = "ErrorLPWD" class="ErrorIns"></p>
				<p id = "ErrorMAIL" class="ErrorIns"></p>
				<p id = "ErrorEPWD" class="ErrorIns"></p>
				<p id = "ErrorSPWD" class="ErrorIns"></p>
				<p id = "ErrorTEL" class="ErrorIns"></p>
			</div> 
		<?php
		//class row, colomn
			$errorMAIL = isset($_GET['MAIL']) ? $_GET['MAIL'] : NULL;
			if($errorMAIL == true){
				echo("<p class='ErrorIns'> L'adresse mail est d&#233;ja utilis&#233;e </p>");
			}
		?>

	<footer>
			
		<p id="paramFooter"> Copyright 2020 - Thibault Beleguic - Universit&#233; de Cergy-Pontoise </p>

	</footer>

</body>
</html>