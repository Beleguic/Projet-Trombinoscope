
	let temoin;


	function showInfo(i){
		var div = document.getElementById("divInfoEleve");
		if(div.style.display == "block" && temoin == i){
			div.style.display = "none";
		}
		else{
			div.style.display = "block";
		}

		var info = document.getElementsByClassName(i);

		let cpt = 0;

		for (etudiant of info){
			cpt++;
			let texte = document.getElementById(cpt);
			if(cpt == 6){
				texte.src = etudiant.textContent;
			}
			else{
				texte.innerHTML = etudiant.textContent;
			}

		}
		temoin = i;
	}

	function chargerGroupe(json){
		let filiere = document.getElementById("SelectFiliere").value;
		let groupe = document.getElementById("SelectGroupe");
		groupe.innerHTML ="<option class = 'form_ville'> Tous les groupes </option>";
		for (var i = 0; i < json['listeFilieres'].length; i++) {
			if(json['listeFilieres'][i]['nomFiliere'] == filiere){
				for (var j = 0; j < json['listeFilieres'][i]['groupes'].length; j++) {
					groupe.innerHTML += `<option value='${json['listeFilieres'][i]['groupes'][j]}'>${json['listeFilieres'][i]['groupes'][j]}</option>`;
				}	
			}
		}
	}

	function checkOpTrombi(){

		let filiere = document.getElementById("SelectFiliere").value;

		let errFiliere = false;

		let pFiliere = document.getElementById("errorFiliere");

		if(filiere == "--- Fili&#232;re ---"){
			errFiliere = true;
			pFiliere.innerHTML = "S&#233;lectionnez une fili&#232;re pour afficher le trombinoscope";
		}
		else{
			errFiliere = false;
			pFiliere.innerHTML = "";

		}

		if(errFiliere == false){
			document.getElementById("formTrombi").submit();
		}

	}

	function checkIncrip() {

		let pass1 = document.getElementById('inscrp_pass1').value;
		let pass2 = document.getElementById('inscrp_pass2').value;
		let mail = document.getElementById('inscrp_mail').value;
		let nom = document.getElementById('inscrip_nom').value;
		let prenom = document.getElementById('inscrip_prenom').value;
		let nbrCaracPWD = 8;
		let nbrCaracLOGIN = 10;
		let ErrorMail = document.getElementById('ErrorMail');
		let ErrorEPWD = document.getElementById('ErrorEPWD'); // pwd equivalent
		let ErrorSPWD = document.getElementById('ErrorSPWD'); // synthqx pwd
		let ErrorLPWD = document.getElementById('ErrorLPWD'); // longueur pwd
		let ErrorLOGIN = document.getElementById('ErrorLOGIN'); // longueur Login
		let ErrorPoint = document.getElementById('Error;'); // longueur Login
		let ErrorChamps = document.getElementById('ErrorChamp'); 
		
		let CpwdL = false;
		let Cmail = false;
		let CpwdS = false;
		let CpwdE = false;
		let CPoint = false;
		let CChamps = false;
		let pwdL = pass1.length;

		if(pwdL < nbrCaracPWD){
			ErrorLPWD.innerHTML = "Le mot de passe n'est pas assez long";
			CpwdL = false
		}
		else{
			ErrorLPWD.innerHTML = "";
			CpwdL = true;
		}

		if(CpwdL == true){
			var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
			var pwdformat = /^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)([^;]).*$/;

			if(mail.match(mailformat)){
				ErrorMAIL.innerHTML = "";
				Cmail = true;
			}
			else{
				ErrorMAIL.innerHTML = "Votre mail ne respecte pas le format standard";
				Cmail = false;
			}
			
			if(pass1.match(pwdformat)){
				ErrorSPWD.innerHTML = "";
				CpwdS = true;
			}
			else{
				ErrorSPWD.innerHTML = "Le mot de passe doit contenir au moins 1 majuscule, 1 minuscule, 1 chiffre et 1 caract&#232;re sp&#233;cial";
				CpwdS = false;
			}
			if (pass1 === pass2){
				ErrorEPWD.innerHTML = "";
				CpwdE = true;
			}
			else{
				ErrorEPWD.innerHTML = "Les deux mots de passe ne sont pas &#233;gaux";
				CpwdE = false;
			}
		}

		if(Cmail == true && CpwdS == true && CpwdE == true){

			var NPPformat = /^[^;]*$/;

			if(nom.match(NPPformat)){
				if(prenom.match(NPPformat)){	
					if(mail.match(NPPformat)){
						if(pass1.match(NPPformat)){
							CPoint = true;
							ErrorPoint.innerHTML = "";
						}
						else{
							CPoint = false;
						}
					}
					else{
						CPoint = false;
					}
				}
				else{
					CPoint = false;
				}
			}
			else{
				CPoint = false;
			}

			if(CPoint == false){
				ErrorPoint.innerHTML = "Un des champs du formulaire contient un \";\" ";
			}

			if(nom != ""){
				if(prenom != ""){						
					CChamps = true;
					ErrorChamps.innerHTML = "";
				}
				else{
					CChamps = false;
				}
			}
			else{
				CChamps = false;
			}

			if(CChamps == false){
				ErrorChamps.innerHTML = "Un des champs du formulaire n'est pas rempli";
			}
		}
			
		if(CPoint == true && CChamps == true){
			document.getElementById("formulaire_inscription").submit();
		}
	}

	function checkCo() {
		
		let pass = document.getElementById('co_MDP').value;
		let pseudo = document.getElementById('co_LOGIN').value;
		let nbrCarac = 1;
		let ErrorLONG = document.getElementById('ErrorLONG'); // longueur champ
		long1 = pass.length;
		long2 = pseudo.length;
		
		if(long1 >= nbrCarac && long2 >= nbrCarac){
			document.getElementById("formulaire_connexion").submit();
		}
		else{
			ErrorLONG.innerHTML = "Veuillez renseigner les informations dans les champs";
		}
	}


/*
	// compte API = administration@gmail.com
	// mdp = UnivCY95*
	// key = c591aa1cd1790d738126de4f544ffd
*/