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
		<div class="divRow">
			<div id="imageHeader">
				<a href="index.php" ><img src="assets/logoCY.png" alt="error" height="100"/></a>
			</div>
			<div id="titreHeader">
				<h1> Authentification </h1>
			</div>
			<div id="boutonDroiteHeader">
				<?php 
					if(empty($_SESSION['mail'])){
						echo("<button style=\"margin-top: 17px;\" class='boutonCo' type='button' onclick=\"document.location.href = 'index.php'\"> Connexion</button>");
					}else{
						echo("<button style=\"margin-top: 17px;\" class='boutonCo' type='button'onclick=\"document.location.href = 'compte.php'\"> Mon profil </button>");
					}
				?>
				<button style="margin-top: 17px;" class='boutonCo' type='button' onclick="document.location.href = 'admin.php'"> Services </button>
			</div>
		</div>
	</header>
	<form enctype="multipart/form-data" action="scriptInscription.php" method="post" id="formulaire_inscription">
		<div class = "divInsCon">
			<h1 id="FormInscriptionText">Inscription</h1>
			<label class="inscripInfo" for="inscrip_nom"> Nom  </label>
			<input id='inscrip_nom' type="text" name="nom" placeholder="Nom" required="required" pattern="[A-Za-z]+"/>
			<label class="inscripInfo" for="inscrip_prenom"> Pr&#233;nom </label> 
			<input id='inscrip_prenom' type="text" name="prenom" placeholder="Pr&#233;nom" required="required" pattern="[A-Za-z]+"/>

			<label class="inscripInfo" for="inscrp_mail"> Adresse mail </label>
			<input id="inscrp_mail" type="email" name="adresseMail" placeholder="Adresse mail" pattern="^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$" required="required"/>
			<label class="inscripInfo" for="inscrp_telephone"> T&#233;l&#233;phone </label>
			<input id="inscrp_telephone" type="text" name="telephone" placeholder="T&#233;l&#233;phone" pattern="[0-9]{10}" required="required"/>
			<label class="inscripInfo" for="inscrp_adressePostale"> Adresse postale </label>
			<input id="inscrp_adressePostale" type="text" name="adressePostale" placeholder="adresse postale" required="required"/>
			<?php
				$jsonData = file_get_contents("filiere.json");
				$json = json_decode("$jsonData",true);
				echo("<label class='inscripInfo' for='SelectFiliere'> Fili&#232;re </label>");
				echo("<select id='SelectFiliere' name='filiere' size='1' onchange='setGroupe()'>");
					echo("<option class = 'form_ville'> --- Fili&#232;re --- </option>");
					for ($i=0; $i < 5; $i++) { 
						$filieres = $json['listeFilieres'][$i]['nomFiliere'];
						echo("<option class = 'form_ville' value='$filieres'> $filieres </option>");
					}
				echo("</select>");
				echo("<label class='inscripInfo' for='SelectGroupe'> Groupe </label>");
				echo("<select id='SelectGroupe' name='groupe' size='1' >");
					echo("<option class = 'form_ville'> --- Groupe --- </option>");
				echo("</select>");
			?>

			<label class="inscripInfo" for="inscrp_pass1"> Mot de passe* </label>
			<input id="inscrp_pass1" type="password" name="motDePasse" placeholder="Mot de passe" required="required"/>

			<label class="inscripInfo" for="inscrp_pass2"> Confirmation du mot de passe* </label>
			<input id="inscrp_pass2" type="password" name="motDePasse2" placeholder="Mot de passe" required="required"/>

			<label class="inscripInfo" for="ImageInsc"> Image </label>
			<input id="ImageInsc" type="file" name="image" accept=".jpg, .jpeg, .png" required="required"/>

			<input type="button" value="Inscription" onclick="checkIncripIns();"/>
			<a class="lien" href="index.php"> J'ai d&#233;ja un compte </a>
			<p class="InfoForm" >* 8 caract&#232;res minimum</p>

			<p id = "Error;" class="ErrorIns"></p>
			<p id = "ErrorChamp" class="ErrorIns"></p>
			<p id = "ErrorTEL" class="ErrorIns"></p>
			<p id = "ErrorLOGIN" class="ErrorIns"></p>
			<p id = "ErrorLPWD" class="ErrorIns"></p>
			<p id = "ErrorMAIL" class="ErrorIns"></p>
			<p id = "ErrorEPWD" class="ErrorIns"></p>
			<p id = "ErrorSPWD" class="ErrorIns"></p>
				
		
			<?php
				$errorMAIL = isset($_GET['MAIL']) ? $_GET['MAIL'] : NULL;
				if($errorMAIL == true){
					echo("<p class='ErrorIns'> L'adresse mail est d&#233;j&#224; utilis&#233;e </p>");
				}
				$errorLOG = isset($_GET['TEL']) ? $_GET['TEL'] : NULL;
				if($errorLOG == true){
					echo("<p class='ErrorIns'> Le num&#233;ro de t&#233;l&#233;phone est d&#233;j&#224; utilis&#233; </p>");
				}
				$error = isset($_GET['error']) ? $_GET['error'] : NULL;
				if($error == 1){
					echo("<p class='ErrorIns'> Un ou plusieurs champs contiennent un \";\" </p>");
				}
				elseif ($error == 2) {
					echo("<p class='ErrorIns'> Un ou plusieurs champs sont vides </p>");
				}
				elseif ($error == 3) {
					echo("<p class='ErrorIns'> La photo doit avoir une dimension maximale de 512px par 512px et ne doit pas d&#233;passer 2MO </p>");
				}	
				else{

				}
			?>
		</div>
	</form>
	<footer>
			
		<p> Copyright 2020 - Thibault Beleguic - Universit&#233; de Cergy-Pontoise </p>

	</footer>
	

	<script>



		function setGroupe(){
			chargerGroupe( <?php echo($jsonData) ?> );

		}


	</script>

</body>
</html>