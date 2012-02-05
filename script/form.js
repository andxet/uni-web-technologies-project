function controlloDati(){

}

function controlloMail(){

}

function controlloPassword(){
	if(checkPassword()){
			document.modificaPassword.jsIsEnabled.value="YES";
			document.modificaPassword.submit();
        }
    else return false;
}

function checkPassword(){
	var passOld = document.modificaPassword.passOld.value;
	var pass = document.modificaPassword.password.value;
	var pass2 = document.modificaPassword.pass2.value;
	
	var controllo = true;
	
	//Controllo se le password sono uguali
	controllo = controllo & controllaPass(pass, pass2);
	controllo = controllo & controllaPass(passOld, pass);
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
	controllo = controllo & isLong(nickname, "Username");
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

function conferma_eliminazione() { 
	var conferma = confirm("Sei sicuro di voler cancellare tutto il contenuto del form?"); 
	if (conferma) 
		document.modulo.reset();
}

var email_reg_exp = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-]{2,})+\.)+([a-zA-Z0-9]{2,})+$/;
