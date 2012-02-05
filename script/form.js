function controlloDati(){
	if(checkDati()){
			document.modificaDati.jsIsEnabled.value="YES";
			document.modificaDati.submit();
        }
    else return false;
}

function checkDati(){
	errori = "";
	var nome = document.modificaDati.nome.value;
	var cognome = document.modificaDati.cognome.value;
	var luogo = document.modificaDati.luogo.value;
	
	var controllo = true;
	
	//Controllo se i campi sono stati riempiti
	controllo = controllo & isSet(nome, "Nome");
	controllo = controllo & isSet(cognome, "Cognome");
	
	//Controllo se i campi nome e cognome hanno lunghezza > 4
	controllo = controllo & isLong(nome, "Nome");
	controllo = controllo & isLong(cognome, "Cognome");
	
	//Controllo se i campi contengono caratteri proibiti
	controllo = controllo & !hasProhibitedChars(nome, "Nome");
	controllo = controllo & !hasProhibitedChars(cognome, "Cognome");
	controllo = controllo & !hasProhibitedChars(luogo, "Luogo");
	
	showErrors();
	return controllo;	

}

//////////////////////
function controlloMail(){
	if(checkMail()){
			document.modificaMail.jsIsEnabled.value="YES";
			document.modificaMail.submit();
        }
    else return false;
}

function checkMail(){
	
	errori = '';
	email = document.modificaMail.email.value;
	var controllo = isMail(email);
	showErrors();
	return controllo;
	
}

////////////////////////////
function controlloPassword(){
	if(checkPassword()){
			document.modificaPassword.jsIsEnabled.value="YES";
			document.modificaPassword.submit();
        }
    else return false;
}

function checkPassword(){
	errori = "";
	
	var passOld = document.modificaPassword.passOld.value;
	var pass = document.modificaPassword.password.value;
	var pass2 = document.modificaPassword.pass2.value;
	
	var controllo = true;	
	
	controllo = controllo & isSet(passOld, "Vecchia password");
	controllo = controllo & isSet(pass, "Password");
	controllo = controllo & isSet(pass2, "Conferma password");
	
	
	//Controllo se le password sono uguali
	controllo = controllo & controllaPass(pass, pass2);
	if(controllo && passOld == pass){
		controllo = false;
		errori = errori + "La nuova password coincide con quella vecchia.";
		}
	
	showErrors();
	return controllo;
}

function controlloRegistrazione(){
	if(checkRegistrazione()){
			document.registrazione.jsIsEnabled.value="YES";
			document.registrazione.submit();
        }
    else return false;        
}


function checkRegistrazione(){
	errori = "";
	var nickname = document.registrazione.username.value;
	var pass = document.registrazione.password.value;
	var pass2 = document.registrazione.pass2.value;
	var mail = document.registrazione.email.value;
	var nome = document.registrazione.nome.value;
	var cognome = document.registrazione.cognome.value;
	var luogo = document.registrazione.luogo.value;
	
	var controllo = true;
	
	//Controllo se le password sono uguali
	controllo = controllo & controllaPass(pass, pass2);
	
	//Controllo se i campi sono stati riempiti
	controllo = controllo & isSet(nickname, "Username");
	controllo = controllo & isSet(pass, "Password");
	controllo = controllo & isSet(pass2, "conferma Password");
	controllo = controllo & isSet(nome, "Nome");
	controllo = controllo & isSet(cognome, "Cognome");
	
	//Controllo se i campi nome e cognome hanno lunghezza > 1
	controllo = controllo & isLong4(nickname, "Username");
	controllo = controllo & isLong(nome, "Nome");
	controllo = controllo & isLong(cognome, "Cognome");
	
	//Controllo se i campi contengono caratteri proibiti
	controllo = controllo & !hasProhibitedChars(nickname, "Username");
	controllo = controllo & !hasProhibitedChars(nome, "Nome");
	controllo = controllo & !hasProhibitedChars(cognome, "Cognome");
	controllo = controllo & !hasProhibitedChars(luogo, "Luogo");
	
	//controllo se l'e-mail è valida
	controllo = controllo & isMail(mail);
	showErrors();
	return controllo;	
}

function isSet(campo, nomeCampo){
	if ((campo == "") || (campo == "undefined")) {
	   errori = errori + "Il campo <strong>" + nomeCampo + "</strong> &egrave; obbligatorio.\n<br />";
	   return false;}
	else
		return true;
}

function controllaPass(pass, pass2){
	if(pass != pass2){
		errori = errori + "Le <strong>password</strong> non coincidono.\n<br />";
		return false;
	}
	else
		return true;
}

function isMail(mail){
	if ((mail == "") || (mail == "undefined")) {
		errori = errori + "Il campo <strong>e-Mail</strong> &egrave; obbligatorio.<br />";
		return false;
		}
	else if(!email_reg_exp.test(mail)){
   		errori = errori + "Inserire un indirizzo <strong>e-Mail</strong> corretto.<br />";
   		return false;
	}
	else
		return true;
}

function hasProhibitedChars(campo, nomeCampo){
	if((campo.indexOf("|") == -1) &&
		(campo.indexOf("+") == -1) &&
		(campo.indexOf("--") == -1) &&
		(campo.indexOf("=") == -1) &&
		(campo.indexOf("<") == -1) &&
		(campo.indexOf(">") == -1) &&
		(campo.indexOf("!=") == -1) &&
		(campo.indexOf("(") == -1) &&
		(campo.indexOf(")") == -1) &&
		(campo.indexOf("%") == -1) &&
		(campo.indexOf("@") == -1) &&
		(campo.indexOf("#") == -1) &&
		(campo.indexOf("*") == -1)){
			return false;
		}
	else{
		errori = errori + "Il campo <strong>" + nomeCampo + "</strong> contiene caratteri proibiti.<br />";
		return true;
		}		
}

function showErrors(){
	document.getElementById("errori").innerHTML = errori;
}

function isLong(campo, nomeCampo){
	if (campo.length == 1) {
   		errori = errori + "Il campo <strong>" + nomeCampo + "</strong> deve avere pi&ugrave; di un carattere.\n<br />";
   		return false;}
	else
		return true;
}

function isLong4(campo, nomeCampo){
	if (campo.length < 4 && campo.length > 0) {
   		errori = errori + "Il campo <strong>" + nomeCampo + "</strong> deve avere pi&ugrave; di quattro caratteri.\n<br />";
   		return false;}
	else
		return true;
}


function conferma_eliminazione() { 
	var conferma = confirm("Sei sicuro di voler cancellare tutto il contenuto del form?"); 
	if (conferma) 
		document.modulo.reset();
}

var email_reg_exp = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-]{2,})+\.)+([a-zA-Z0-9]{2,})+$/;
