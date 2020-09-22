<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<title> Connexion </title>
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
			<button type='button' onclick="document.location.href = 'inscription.php'" style="margin-top: 17px;" class='boutonCo' id='boutonHeader' > Inscription </button>
		</div>
	</header>
<form action="scriptConnexion.php" method="post" id="formulaire_connexion">
		<div class="divInsCon">
			<h1 id="FormConnexionText">Connexion</h1>
			<label class="inscripInfo" for="co_LOGIN"> Adresse mail </label>
			<input id = "co_LOGIN" type="email" name="adresseMail" placeholder="Adresse mail"/>
			<label class="inscripInfo" for="co_LOGIN"> Mot de passe </label>
			<input id = "co_MDP" type="password" name="motDePasse" placeholder="Mot de passe"/>
			<input type="button" value="Connexion" onclick="checkCo();"/>
			<a class="lien" href="inscription.php"> Pas encore inscrit ? </a>
		</div>
	</form>
	<p id="ErrorLONG" class="ErrorIns"></p>
	<?php
		if(isset($_GET['error'])){
			if($_GET['error'] == 1){
				echo("<p class='ErrorIns'> tous les champs ne sont pas remplis </p>");
			}
			if($_GET['error'] == 2){
				echo("<p class='ErrorIns'> le mail et/ou le mot de passe est incorrect </p>");
			}
		}
	?>

	<footer>
			
		<p id="paramFooter"> Copyright 2020 - Thibault Beleguic - Universit&#233; de Cergy-Pontoise </p>

	</footer>


</body>
</html>