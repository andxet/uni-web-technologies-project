var errori;
var nickname;
var nome;
var cognome;
var mail;
var luogo;
var email_reg_exp = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-]{2,})+\.)+([a-zA-Z0-9]{2,})+$/;

function checkRegistration(){

	errori = "";
	nickname = document.modulo.nickname.value;
	pass = document.modulo.pass.value;
	pass2 = document.modulo.pass2.value;
	nome = document.modulo.nome.value;
	cognome = document.modulo.cognome.value;
	mail = document.modulo.email.value;
	luogo = document.modulo.luogo.value;
	
	
	var controllo = true;
	
	//Controllo se le password sono uguali
	controllo = controllo & controllaPass(pass, pass2);
	
	//Controllo se i campi sono stati riempiti
	controllo = controllo & isSet(nickname, "Nickname");
	controllo = controllo & isSet(pass, "Password");
	controllo = controllo & isSet(pass2, "conferma Password");
	controllo = controllo & isSet(nome, "Nome");
	controllo = controllo & isSet(cognome, "Cognome");
	
	//Controllo se i campi nome e cognome hanno lunghezza > 1
	controllo = controllo & isLong(nickname, "Nickname");
	controllo = controllo & isLong(nome, "Nome");
	controllo = controllo & isLong(cognome, "Cognome");
	
	//Controllo se i campi contengono caratteri proibiti
	controllo = controllo & !hasProhibitedChars(nickname, "Nickname");
	controllo = controllo & !hasProhibitedChars(nome, "Nome");
	controllo = controllo & !hasProhibitedChars(cognome, "Cognome");
	controllo = controllo & !hasProhibitedChars(luogo, "Luogo");
	
	//controllo se l'e-mail è valida
	controllo = controllo & isMail(mail);
	showErrors();
	return controllo;
}

function checkEditProfile(){

	errori = "";
	nome = document.modulo.nome.value;
	cognome = document.modulo.cognome.value;
	luogo = document.modulo.luogo.value;
	
	
	var controllo = true;
	
	//Controllo se i campi sono stati riempiti
	controllo = controllo & isSet(nome, "Nome");
	controllo = controllo & isSet(cognome, "Cognome");
	
	//Controllo se i campi nome e cognome hanno lunghezza > 1
	controllo = controllo & isLong(nome, "Nome");
	controllo = controllo & isLong(cognome, "Cognome");
	
	//Controllo se i campi contengono caratteri proibiti
	controllo = controllo & !hasProhibitedChars(nome, "Nome");
	controllo = controllo & !hasProhibitedChars(cognome, "Cognome");
	controllo = controllo & !hasProhibitedChars(luogo, "Luogo");
	
	showErrors();
	return controllo;
}

function checkEditPassword(){
	errori = "";
	var controllo = true;
	pass1 = document.modulo.pass1.value;
	pass2 = document.modulo.pass2.value;
	passold = document.modulo.passold.value;
	
	//Controllo se le password sono uguali
	controllo = controllo & controllaPass(pass1, pass2);
	controllo = controllo & isSet(passold, "vecchia Password");
	controllo = controllo & isSet(pass1, "Password");
	controllo = controllo & isSet(pass2, "conferma Password");
	
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

function checkRegistrazione(){
	if(checkRegistration()){
			document.modulo.jsIsEnabled.value="YES";
			document.modulo.submit();
        }
    else return false;        
}

function checkModificaProfilo(){
	if(checkEditProfile()){
		document.modulo.jsIsEnabled.value="YES";
		document.modulo.submit();
		}
}

function checkModificaPassword(){
	if(checkEditPassword()){
		document.modulo.jsIsEnabled.value="YES";
		document.modulo.submit();
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