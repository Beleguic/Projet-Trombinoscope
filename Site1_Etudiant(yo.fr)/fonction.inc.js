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

	function chargerGroupe(json){
		let filiere = document.getElementById("SelectFiliere").value;
		let groupe = document.getElementById("SelectGroupe");
		groupe.innerHTML ="<option class = 'form_ville'> --- Groupe --- </option>";
		for (var i = 0; i < json['listeFilieres'].length; i++) {
			if(json['listeFilieres'][i]['nomFiliere'] == filiere){
				for (var j = 0; j < json['listeFilieres'][i]['groupes'].length; j++) {
					groupe.innerHTML += `<option value='${json['listeFilieres'][i]['groupes'][j]}'>${json['listeFilieres'][i]['groupes'][j]}</option>`;
				}	
			}
		}
	}

	function checkIncripIns() {

		let pass1 = document.getElementById('inscrp_pass1').value;
		let pass2 = document.getElementById('inscrp_pass2').value;
		let mail = document.getElementById('inscrp_mail').value;
		let telephone = document.getElementById('inscrp_telephone').value;
		let nom = document.getElementById('inscrip_nom').value;
		let prenom = document.getElementById('inscrip_prenom').value;
		let adressePostale = document.getElementById('inscrp_adressePostale').value;
		let filiere = document.getElementById('SelectFiliere').value;
		let groupe = document.getElementById('SelectGroupe').value;
		let nbrCaracPWD = 8;
		let nbrCaracLOGIN = 10;
		let ErrorMail = document.getElementById('ErrorMail');
		let ErrorEPWD = document.getElementById('ErrorEPWD'); // pwd equivalent
		let ErrorSPWD = document.getElementById('ErrorSPWD'); // synthqx pwd
		let ErrorLPWD = document.getElementById('ErrorLPWD'); // longueur pwd
		let ErrorLOGIN = document.getElementById('ErrorLOGIN'); // longueur Login
		let ErrorPoint = document.getElementById('Error;'); // longueur Login
		let ErrorTEL =  document.getElementById('ErrorTEL'); 
		let ErrorChamps = document.getElementById('ErrorChamp'); 
		
		let ClogL = false;
		let CpwdL = false;
		let Cmail = false;
		let Ctel = false;
		let CpwdS = false;
		let CpwdE = false;
		let CPoint = false;
		let CChamps = false;
		let telL = telephone.length;
		let pwdL = pass1.length;

		if(telL < nbrCaracLOGIN){
			ErrorLOGIN.innerHTML = "Le num&#233;ro de t&#233;l&#233;phone n'est assez long";
			ClogL = false;
		}
		else{
			ErrorLOGIN.innerHTML = "";
			ClogL = true;
		}
		if(pwdL < nbrCaracPWD){
			ErrorLPWD.innerHTML = "Le mot de passe n'est pas assez long";
			CpwdL = false
		}
		else{
			ErrorLPWD.innerHTML = "";
			CpwdL = true;
		}

		if(CpwdL == true && ClogL == true){
			var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
			var pwdformat = /^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)([^;]).*$/;
			var telformat = /^\d{10}$/gm;
			if(mail.match(mailformat)){
				ErrorMAIL.innerHTML = "";
				Cmail = true;
			}
			else{
				ErrorMAIL.innerHTML = "Votre mail ne respecte pas le format standard";
				Cmail = false;
			}
			if(telephone.match(telformat)){
				ErrorTEL.innerHTML = "";
				Ctel = true;
			}
			else{
				ErrorTEL.innerHTML = "Votre num&#233;ro de t&#233;l&#233;phone doit contenir 10 chiffres";
				Ctel = false;
			}
			
			if(pass1.match(pwdformat)){
				ErrorSPWD.innerHTML = "";
				CpwdS = true;
			}
			else{
				ErrorSPWD.innerHTML = "Le nouveau mot de passe doit contenir au moins 1 majuscule, 1 minuscule, 1 chiffre et 1 caract&#233;re sp&#233;cial";
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

		if(Cmail == true && CpwdS == true && CpwdE == true && Ctel == true){

			var NPPformat = /^[^;]*$/;

			if(nom.match(NPPformat)){
				if(prenom.match(NPPformat)){
					if(telephone.match(NPPformat)){
						if(mail.match(NPPformat)){
							if(pass1.match(NPPformat)){
								if(filiere.match(NPPformat)){
									if(groupe.match(NPPformat)){
										if(adressePostale.match(NPPformat)){
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
					if(groupe != ""){
						if(filiere != "--- Filiere ---"){
							if(adressePostale != ""){
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
					}
					else{
						CChamps = false;
					}
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



	function changeDiv1(){
		//formulaireChange
		var div2 = document.getElementById('formulaireChangeDiv2');
		var div = document.getElementById('formulaireChangeDiv1');
		if(div.style.display == "block"){
			div.style.display = "none";
		}
		else{
			div.style.display = "block";
			div2.style.display = "none";
			location.href ="#formulaireChangeDiv1";

		}
	}

	function changeDiv2(){
		//formulaireChange
		var div2 = document.getElementById('formulaireChangeDiv1');
		var div = document.getElementById('formulaireChangeDiv2');
		if(div.style.display == "block"){
			div.style.display = "none";
		}
		else{
			div.style.display = "block";
			div2.style.display = "none";
			location.href ="#formulaireChangeDiv2"
		}
	}

	function checkInfo(){

		let mail = document.getElementById('mail').value;
		let pass1 = document.getElementById('pass1').value;
		let pass2 = document.getElementById('pass2').value;

		let ErrorCMAIL = document.getElementById('ErrorMail');
		let ErrorVMAIL = document.getElementById('ErrorMailV');
		let ErrorSPWD = document.getElementById('ErrorSPWD');
		let	ErrorEPWD = document.getElementById('ErrorEPWD');

		let Cmail = false;
		let Vmail = false;
		let CpwdE = false;
		let CpwdS = false;

		if (mail != ""){
			if(pass1 != ""){
				if(pass2 != ""){
					Vmail = false;
				}
				else{
					Vmail = true;
				}	
			}
			else{
				Vmail = true;
			}
		}
		else{
			Vmail = true;
		}

		if(Vmail == true){
			ErrorVMAIL.innerHTML = "Un des champs du formulaire n'est pas rempli";
		}
		else{
			ErrorVMAIL.innerHTML = "";
		}

		if(Vmail == false){
			var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
			var pwdformat = /^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)([^;]).*$/;
			if(mail.match(mailformat)){
				ErrorCMAIL.innerHTML = "";
				Cmail = true;
			}
			else{
				ErrorCMAIL.innerHTML = "Votre mail ne respecte pas le format standard";
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

		if(Cmail == true && CpwdE == true && CpwdS == true){
			document.getElementById("ApiDemande").submit();
		}
	}


	function checkIncripCompte() {

		let nom = document.getElementById("modif_nom").value;
		let prenom = document.getElementById("modif_prenom").value;
		let mail = document.getElementById("modif_mail").value;
		let telephone = document.getElementById("modif_telephone").value;
		let adressePostale = document.getElementById("modif_adressePostale").value;
		let filiere = document.getElementById("SelectFiliere").value;
		let groupe = document.getElementById("SelectGroupe").value;
		let pass1 = document.getElementById("modif_pass1").value;
		let pass2 = document.getElementById("modif_pass2").value;
		let nbrCaracPWD = 8;
		let nbrCaracLOGIN = 10;
		let ErrorMail = document.getElementById("ErrorMail1");
		let ErrorEPWD = document.getElementById("ErrorEPWD1"); // pwd equivalent
		let ErrorSPWD = document.getElementById("ErrorSPWD1"); // synthqx pwd
		let ErrorLPWD = document.getElementById("ErrorLPWD1"); // longueur pwd
		let ErrorLOGIN = document.getElementById("ErrorLOGIN1"); // longueur Login
		let ErrorPoint = document.getElementById("Error;1"); // longueur Login
		let ErrorTEL =  document.getElementById("ErrorTEL1"); 
		let ErrorChamps = document.getElementById("ErrorChamp1"); 
		
		let ClogL = false;
		let CpwdL = false;
		let Cmail = false;
		let Ctel = false;
		let CpwdS = false;
		let CpwdE = false;
		let CPoint = false;
		let CChamps = false;
		let telL = telephone.length;
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
			if (pass1 === pass2){
				ErrorEPWD.innerHTML = "";
				CpwdE = true;
			}
			else{
				ErrorEPWD.innerHTML = "Les deux mots de passe ne sont pas égaux";
				CpwdE = false;
			}
		}

		if(telephone == ""){
			Ctel = true;
		}
		else{
			if(telL < nbrCaracLOGIN){
				ErrorLOGIN.innerHTML = "Le numéro de téléphone n'est assez long";
				ClogL = false;
			}
			else{
				ErrorLOGIN.innerHTML = "";
				ClogL = true;
			}
			if(ClogL == true){
				var telformat = /^\d{10}$/gm;
				if(telephone.match(telformat)){
					ErrorTEL.innerHTML = "";
					Ctel = true;
				}
				else{
					ErrorTEL.innerHTML = "Votre numéro de téléphone doit contenir 10 chiffres";
					Ctel = false;
				}
			}
		}

		if(mail == ""){
			Cmail = true;
		}
		else{

			var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

			if(mail.match(mailformat)){
				ErrorMAIL.innerHTML = "";
				Cmail = true;
			}
			else{
				ErrorMAIL.innerHTML = "Votre mail ne respecte pas le format standard";
				Cmail = false;
			}
		}

		if(Cmail == true && CpwdE == true && Ctel == true){

			var NPPformat = /^[^;]*$/;

			if(nom.match(NPPformat)){
				if(prenom.match(NPPformat)){
					if(telephone.match(NPPformat)){
						if(mail.match(NPPformat)){
							if(pass1.match(NPPformat)){
								if(filiere.match(NPPformat)){
									if(groupe.match(NPPformat)){
										if(adressePostale.match(NPPformat)){
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
		}
		if(CPoint == true){
			document.getElementById("formulaireModifInfo").submit();
		}
	}


	function checkNewPwd() {
		
		let oldPwd = document.getElementById("change_passOld").value;
		let newPwd1 = document.getElementById("change_pass1").value;
		let newPwd2 = document.getElementById("change_pass2").value;
		let mail = document.getElementById("change_mail").value;
		let nbrCaracPWD = 8;
		let ErrorEPWD = document.getElementById("ErrorEPWD"); // pwd equivalent
		let ErrorSPWD = document.getElementById("ErrorSPWD"); // synthqx pwd
		let ErrorLPWD = document.getElementById("ErrorLPWD"); // longueur pwd
		let ErrorMail = document.getElementById("ErrorMail"); // synthax mail
		let LnewPwd1 = newPwd1.length;
		let CpwdL = false;
		let Cmail = false;
		let CpwdS = false;
		let CpwdE = false;
		
		if(LnewPwd1 < nbrCaracPWD){
			ErrorLPWD.innerHTML = "Le nouveau mot de passe n'est pas assez long";
			CpwdL = false
		}
		else{
			ErrorLPWD.innerHTML = "";
			CpwdL = true;
		}

		if(CpwdL == true){
			var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
			var pwdformat = /^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/;
			if(mail.match(mailformat)){
				ErrorMAIL.innerHTML = "";
				Cmail = true;
			}
			else{
				ErrorMAIL.innerHTML = "Votre mail ne respecte pas le format standard";
				Cmail = false;
			}
			if(newPwd1.match(pwdformat)){
				ErrorSPWD.innerHTML = "";
				CpwdS = true;
			}
			else{
				ErrorSPWD.innerHTML = "Le nouveau mot de passe doit contenir au moins 1 majuscule, 1 minuscule, 1 chiffre et 1 caractére spécial";
				CpwdS = false;
			}
			if (newPwd1 === newPwd2){
				ErrorEPWD.innerHTML = "";
				CpwdE = true;
			}
			else{
				ErrorEPWD.innerHTML = "Les deux mots de passe ne sont pas égaux";
				CpwdE = false;
			}
		}
		if(Cmail == true && CpwdS == true && CpwdE == true){
			document.getElementById("formChangePwd").submit();
		}
	}