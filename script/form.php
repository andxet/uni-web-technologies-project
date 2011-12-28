<?php

	$paginaControllo = "newsletter.php";
	$paginaRegistrazione = "newsletter.php";

	function checkRegistration($vect){
	
	global $nickname; $nickname = $vect['nickname'];
	global $mail; $mail = $vect['email'];
	if(isset($vect['jsIsEnabled']) && $vect['jsIsEnabled'] == 'YES')
		return controlloUser($nickname) && controlloEmail($mail);
	
	global $pass; $pass = $vect['pass'];
	$passName = "Password";
	global $pass2; $pass2 = $vect['pass2'];
	$nicknameName = "Nickname";
	global $nome; $nome = $vect['nome'];
	$nomeName = "Nome";
	global $cognome; $cognome = $vect['cognome'];
	$cognomeName = "Cognome";
	global $mail; $mail = $vect['email'];
	$mailName = "eMail";
	global $luogo; $luogo = $vect['luogo'];
	$luogoName = "Luogo";
	global $errori; $errori = "";
	
	$controllo = true;
	
	//Controllo se i campi sono stati riempiti
	$controllo = $controllo & isSetted($nickname, $nicknameName);
	if($controllo)
		$controllo = $controllo & controlloUser($nickname);
		
	$controllo = $controllo & isSetted($pass, $passName);
	$controllo = $controllo & isSetted($nome, $nomeName);
	$controllo = $controllo & isSetted($cognome, $cognomeName);
	
	//Controllo per le password
	$controllo = $controllo & checkPassword($pass, $pass2);
	
	//Controllo se il nickname
	
	//Controllo se i campi nome e cognome hanno lunghezza accettabile
	$controllo = $controllo & isLong($nickname, $nicknameName);
	$controllo = $controllo & isLong($nome, $nomeName);
	$controllo = $controllo & isLong($cognome, $cognomeName);
	
	//Controllo se i campi contengono caratteri proibiti
	$controllo = $controllo & !hasProhibitedChars($nickname, $nicknameName);
	$controllo = $controllo & !hasProhibitedChars($nome, $nomeName);
	$controllo = $controllo & !hasProhibitedChars($cognome, $cognomeName);
	$controllo = $controllo & !hasProhibitedChars($luogo, $luogoName);
	
	//controllo se l'e-mail è valida
	$controllo = $controllo & isMail($mail);
	return $controllo;
}

function isSetted($campo, $nomeCampo){
	global $errori;
	if (($campo == "") || ($campo == null)) {
	   $errori = $errori.'Il campo <strong>'.$nomeCampo.'</strong> &egrave; obbligatorio.<br />';
	   return false;}
	else
		return true;
}

function isMail($mail){
	global $errori;
	$email_reg_exp = '/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-]{2,})+\.)+([a-zA-Z0-9]{2,})+$/';
	if (($mail == "") || ($mail == null)) {
		$errori = $errori."Il campo <strong>e-Mail</strong> &egrave; obbligatorio.<br />";
		return false;
		}
	else if(!preg_match($email_reg_exp, $mail)){
   		$errori = $errori."Inserire un indirizzo <strong>e-Mail</strong> corretto.<br />";
   		return false;
	}
	else
		return true;
}

function checkPassword($pass, $pass2){
	global $errori;
	if($pass != $pass2){
		$errori .= "Le <strong>password</strong> &egrave; non coincidono.<br />";
		return false;}
	else
		return true;
}

function controlloEmail($mail){
	require_once("DbConn.php");
	if(isExistingEmail($mail))
		return true;
	else{
		global $errori;
		$errori .= "Esiste gi&agrave; un utente con questa <strong>mail</strong>, puoi <a href=\"login.php\">effettuare l'accesso qui.</a><br />";
		return false;
	}
}

function controlloUser($utente){
	require_once("DbConn.php");
	if(isExistingUser($utente))
		return true;
	else{
		global $errori;
		$errori .= "Il <strong>nickname</strong> &egrave; gi&agrave; esistente.<br />";
		return false;
	}
}

function hasProhibitedChars($campo, $nomeCampo){
	global $errori;
	if((strpos($campo, '|') === false) &&
		(strpos($campo, '+') === false) &&
		(strpos($campo, '--') === false) &&
		(strpos($campo, '=') === false) &&
		(strpos($campo, '<') === false) &&
		(strpos($campo, '>') === false) &&
		(strpos($campo, '!=') === false) &&
		(strpos($campo, '(') === false) &&
		(strpos($campo, ')') === false) &&
		(strpos($campo, '%') === false) &&
		(strpos($campo, '@') === false) &&
		(strpos($campo, '#') === false) &&
		(strpos($campo, '*') === false)){
			return false;
		}
	else{
		$errori = $errori.'Il campo <strong>'.$nomeCampo.'</strong> non pu&ograve; contenere i caratteri |, +, --, =, <, >, !=, (, ), %, @, #, *.<br />';
		return true;
		}		
}

function isLong($campo, $nomeCampo){
	require_once('config.php');
	global $errori;
	if (strlen($campo) <= MIN_LUNGHEZZA_CAMPO) {
   		$errori = $errori."Il campo <strong>".$nomeCampo."</strong> deve avere pi&ugrave; di un carattere.\n<br />";
   		return false;}
	else
		return true;
}

function setPrecedenti($nome){
	if(isset($_POST[$nome]))
  		return $_POST[$nome];
	else
		return null;
}
	
function isSelected($freq){
	//global $_POST;
	global $frequenza;
	if($frequenza == '""')
		$frequenza = "daily";
	if (strcmp($frequenza, $freq) == 0)
		return 'selected';
	else return "";
}
	
function isChecked($focused){
	//global $_POST;
	global $tipo;
	if($tipo == null)
		$tipo = "html";
	if (strcmp($tipo, $focused) == 0)
		return 'checked';
	else
		return "";
}


?>