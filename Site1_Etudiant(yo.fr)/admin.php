<?php 
	session_start();
 ?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<title> Administration </title>
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
				<h1> Services</h1>
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
	<div id="documentation">
		<h1> Documentation </h1>
		<h2> R&#233;cup&#233;ration des donn&#233;es du trombinoscope en JSON </h2>
		<p class="paraDoc"> Les donn&#233;es fournies par www.thibault-beleguic.yo.fr peuvent &#234;tre r&#233;cup&#233;r&#233;es au format JSON. </p>
		<h3> Configuration minimale </h3>
		<p class="paraDoc"> Les conditions requises sont de poss&#233;der un serveur muni de PHP 5.2.1 et sup&#233;rieur afin de supporter les fonctions json_decode() et file_get_contents(). </p>
		<p class="paraDoc"> L'utilisation de l'API se fait obligatoirement &#224; l'aide d'une cl&#233; d'API r&#233;cup&#233;rable via  http://thibault-beleguic.yo.fr/ProjetWeb2/admin.php#formulaireChangeDiv1 </p>
		<h3>R&#233;cup&#233;ration des donn&#233;es</h3>
		<p class="paraDoc">La r&#233;cup&#233;ration des donn&#233;es se fait simplement, cette m&#233;thode retournera un tableau associatif contenant les donn&#233;es.</p>
		<code>
			$jsonText = file_get_contents(&#39;CHEMIN_VERS_FICHIER_JSON&#39;);
		</code>
		<code> 
			$json = json_decode($jsonText, true); 
		</code>
		<h3> CHEMIN_VERS_FICHIER_JSON correspond ici &#224; : </h3>
		<pre>
			https://thibault-beleguic.yo.fr/ProjetWeb2/api.php?apiKey=[Cl&#233; d'API]&amp;choix=[Choix]&amp;filiere=[Fili&#232;re]&amp;groupe=[Groupe]
		</pre>
		<ul>
			<li> Cl&#233; d'API 
				<ul>
					<li> Correspond &#224; la <a class="lien" href=" https://thibault-beleguic.yo.fr/ProjetWeb2/admin.php#formulaireChangeDiv1"> cl&#233; d'API </a> , elle est n&#233;cessaire pour faire des demandes de trombinoscope</li>
				</ul>
			</li>
			<li> Choix 
				<ul>
					<li>1 : demander une fili&#232;re avec tous ces groupes, le param&#232;tre &#171; groupe &#187; est facultatif  </li>
					<li> 2 : demander une fili&#232;re avec un groupe sp&#233;cifique, le param&#232;tre &#171; groupe &#187; est obligatoire </li>
				</ul>
			</li>
			<li>Fili&#232;re
				<ul>
					<li> Correspond &#224; une <a class="lien" href="https://thibault-beleguic.yo.fr/ProjetWeb2/filiere.json"> fili&#232;re </a></li>
				</ul>
			</li>
			<li>Groupe
				<ul>
					<li> Correspond &#224; un <a class="lien" href="https://thibault-beleguic.yo.fr/ProjetWeb2/filiere.json"> groupe</a> ce param&#232;tre est facultatif si tous les groupe sont demand&#233;. </li>
				</ul>
			</li>
		</ul>
		<h3> Affichage des donn&#233;es </h3>
		<p class="paraDoc"> Si vous avez converti le fichier JSON sous forme d&#39;objets, les donn&#233;es doivent &#234;tre affich&#233;es de cette
		mani&#232;re. </p>
		<code> echo $json->filiere->groupe->0->nom; => (donnera le nom de l&#39;&#233;l&#232;ve)</code>
		<p class="paraDoc"> Si le fichier JSON est retourn&#233; sous forme de tableau associatif </p>
		<code> echo $json[&#39;filiere&#39;][&#39;groupe&#39;][&#39;0&#39;][&#39;nom&#39;]; => (donnera le nom de l&#39;&#233;l&#232;ve)</code>
		<h3> Liste des param&#232;tres retourn&#233;s par le flux JSON  </h3>
		<table>
			<tr>
				<th> Recuperation Fili&#232;re / Groupe </th>
				<td> JSON </td>
			</tr>
			<tr>
				<td>Fili&#232;re</td>
				<td> <code class="codeInTable">[filiere]</code> </td>
			</tr>
			<tr>
				<td>Groupe</td>
				<td> <code class="codeInTable">[filiere][groupe]</code> </td>
			</tr>
			<tr>
				<th>r&#233;cup&#233;ration d'un &#233;l&#232;ve:</th>
				<td> ... = [filiere][groupe]</td>
			</tr>	
			<tr>
				<td>premier &#233;l&#232;ve </td>
				<td><code class="codeInTable">...[0]</code></td>
			</tr>
			<tr>
				<td>deuxi&#232;me &#233;l&#232;ve</td>
				<td><code class="codeInTable">...[1]</code></td>
			</tr>
			<tr>
				<td> X &#233;l&#232;ve</td>
				<td><code class="codeInTable">...[x]</code></td>
			</tr>
			<tr>
				<th>Information &#233;l&#232;ve</th>
				<td>... = [filiere][groupe][x]</td>
			</tr>
			<tr>
				<td>Nom</td>
				<td><code class="codeInTable">...[nom]</code></td>
			</tr>
			<tr>
				<td>Prenom</td>
				<td><code class="codeInTable">...[prenom]</code></td>
			</tr>
			<tr>
				<td>Adresse mail</td>
				<td><code class="codeInTable">...[mail]</code></td>
			</tr>
			<tr>
				<td>T&#233;l&#233;phone</td>
				<td><code class="codeInTable">...[tel]</code></td>
			</tr>
			<tr>
				<td>Adresse postale</td>
				<td><code class="codeInTable">...[adressePostale]</code></td>
			</tr>
			<tr>
				<td>Image</td>
				<td><code class="codeInTable">...[image]</code></td>
			</tr>
		</table>

		<h3>Affichage d'image</h3>
			<div id="lienIMG">
				<code id="lienIMGTxt"><em>&lt;img src="http://thibault-beleguic.yo.fr/ProjetWeb2/image/<?php echo('$json[\'filiere\'][\'groupe\'][\'x\'][\'image\']') ?>" onerror="this.onerror=null;this.src=&#39;http://thibault-beleguic.yo.fr/ProjetWeb2/image/account.png&#39;;" /&gt;</em></code>
			</div>
		<h3> Exemple </h3>
		<div id="divExempleDoc">
			<?php 
				$data = file_get_contents("./info/exemple.json");
				$data = json_decode($data,true);
				echo("<pre>");
				print_r($data);
				echo("</pre>"); 
			?>
		</div>
		<div class="divExemple">
			<h3> Exemple D'affichage </h3>
			<div class="divExempleRow">
				<?php  
					for ($x=0; $x < 2; $x++) { 
						$info["image"] = $data['LPI-RIWS']["LPI-1"]["$x"]["image"];
						$info["nom"] = $data['LPI-RIWS']["LPI-1"]["$x"]["nom"];
						$info["prenom"] = $data['LPI-RIWS']["LPI-1"]["$x"]["prenom"];
						echo("<div class='divExempleColone'>");
							echo("<img class='image' src=\"http://thibault-beleguic.yo.fr/ProjetWeb2/image/".$info["image"]."\" onerror=\"this.onerror=null;this.src='http://thibault-beleguic.yo.fr/ProjetWeb2/image/account.png';\" alt='Error' />");
							echo("<div class='nomPrenom'>");
								echo("<p class='paraPrint'>".$info["nom"]."</p>"); 
								echo("<p class='paraPrint'>".$info["prenom"]."</p>");
							echo("</div>");
						echo("</div>");
					}
					?>
				</div>
				<div>
					<!-- code de la mosaique -->
				</div>
			</div>
		</div>
	<div id="DivChangeCompte">
		<div class="divRow" id="divBouton">
			<button class="boutonCo" type="button" onclick="changeDiv1()"> Demander sa cl&#233; d'API </button>
			<button class="boutonCo" type="button" onclick="changeDiv2()"> Cl&#233; d'API oubli&#233;e ? </button>
		</div>
	</div>
	<div id="formulaireChangeDiv1">
		<h1> Demander sa cl&#233; d'API</h1>
		<form id="ApiDemande" method="post" action="demandeAPI.php">
			<div class="divColone" style="width: 100%">
				<label for='mail'> Adresse mail </label>
				<input id = 'mail' type="email" name="adresseMail"  placeholder="Adresse mail" required="required"/>
				<label class="inscripInfo" for="pass1"> Mot de passe* </label>
				<input id="pass1" type="password" name="motDePasse" placeholder="Mot de passe" required="required"/>
				<label class="inscripInfo" for="pass2"> Confirmation du mot de passe* </label>
				<input id="pass2" type="password" name="motDePasse2" placeholder="Mot de passe" required="required"/>
				<input type="button" value="Demander sa cl&#233;" onclick="checkInfo()"/>
				<a class="lien" onclick="changeDivMDP()"> Cl&#233; oubli&#233;e ? </a>
				<p class="InfoForm">* 8 caract&#232;res minimum</p>
			</div>
		</form>
		<div style="text-align: center;">
			<p id='ErrorMail' class="ErrorIns"></p>
			<p id='ErrorMailV' class="ErrorIns"></p>
			<p id='ErrorSPWD' class="ErrorIns"></p>
			<p id='ErrorEPWD' class="ErrorIns"></p>

			<?php
				if(isset($_GET['key'])){
					echo("<p> Votre cl&#233; d'API est ".$_GET['key']."</p>");
				}
				if(isset($_GET['error'])){
					if($_GET['error'] == 1){
						echo("<p class='ErrorIns'> Le format du mail n'est pas bon ou le champ est vide </p>");
					}
					if($_GET['error'] == 2){
						echo("<p class='ErrorIns'> Le mail renseign&#233; est d&#233;j&#224; utilis&#233; </p>");
					}
					if($_GET['error'] == 3){
						echo("<p class='ErrorIns'> Le mot de passe n'est pas bon ou les deux mots de passe ne sont pas identiques </p>");
					}
				}
			?>
		</div>	
	</div>
	<div id="formulaireChangeDiv2">
		<h1> Cl&#233; d'API oubli&#233;e ? </h1>
		<form id="FormAPIForgot" method="post" action="apiForgot.php">
			<div class="divColone"  style="width: 100%">
				<label class="inscripInfo" for="co_LOGIN"> Adresse mail </label>
				<input id = "co_LOGIN" type="email" name="adresseMail" placeholder="Adresse mail" required="required"/>
				<label class="inscripInfo" for="co_LOGIN"> Mot de passe </label>
				<input id = "co_MDP" type="password" name="motDePasse" placeholder="Mot de passe" required="required"/>
				<input type="button" value="cl&#233; oubli&#233;e" onclick="checkCo();"/>
				<a class="lien" onclick="changeDivInfoSimple()"> Pas encore de cl&#233; ? </a>
				<p id="ErrorLONG" class="ErrorIns"></p>
				<?php
					if(isset($_GET['key'])){
						echo("<p> Votre cl&#233; d'API est ".$_GET['key']."</p>");
					}
					if(isset($_GET['error'])){
						if($_GET['error'] == 4){
							echo("<p class='ErrorIns'> Le mail et/ou le mot de passe est incorrect ou vous n'avez pas encore demand&#233; de cl&#233; d'API </p>");
						}
						if($_GET['error'] == 5){
							echo("<p class='ErrorIns'> Un des champs du formulaire n'est pas rempli </p>");
						}
					}
				?>
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

	</script>


</body>
</html>