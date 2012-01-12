<?php
	function checkForm($nomeForm){
	if($_POST)
		if(isset($_POST["jsIsEnabled"]) && controlloForm($nomeForm)){
			require_once(SCRIPT_PATH."DbConn.php");
			$form = getForm($nomeForm);
			$form = mysql_fetch_array($form);
			if(function_exists($form['funzioneForm'])){
					if(call_user_func($form['funzioneForm'], $_POST)){
						if($form['reindirizzamento'] != null)
							header("Location: ".$form['reindirizzamento']);
						else{
							global $errori;
							$errori = $form['successo'];
						}
					}
					else die($form['fallimento']);
			}
			else die("Funzione di controllo form ".$form['funzioneForm']." non esistente.");
		}
}
	
	function controlloForm($nomeForm){
		require_once("DbConn.php");
		global $errori;
		$valido = true;
		$campi = getFormFields($nomeForm);
		for($i = 0; $i < mysql_num_rows($campi); $i++){
			$campo = mysql_fetch_array($campi);
			if(!campoNecessitaControllo($campo["tipo"]))
					continue;
			if($campo['richiesto'] == 'y')
					if(!isSetted($_POST[$campo["nome"]], $campo["descrizione"])){
						$valido = false;
						continue;
						}
			$controlli = getFieldControls($campo);
			for($j = 0; $j < count($controlli); $j++){//Effettuo i controlli base
				if(function_exists($controlli[$j])){
					if(!call_user_func($controlli[$j], $_POST[$campo["nome"]], $campo["descrizione"])){
						$valido = false;
						break;}
					}
					
				else die("Funzione di $controlli[$j](".$campo['nome'].") non esistente.");
			}
			if(!is_null($campo["customFunction"]))//Eseguo una funzione particolare
				if(function_exists($campo["customFunction"])){
					if(!call_user_func($campo["customFunction"], $_POST[$campo["nome"]]))
						$valido = false;
					}
				else die("Funzione ".$campo["customFunction"]." non esistente.");
			}
		return $valido;
	}

	function stampaForm($nomeForm){
		require_once("config.php");
		global $errori;
		$form = getForm($nomeForm);
		if (!$form)
			die("Form non esistente nel database.");
		$form = mysql_fetch_array($form);
		
		$fields = getFormFields($nomeForm);
		
		echo '<div id="errori">'.$errori.'</div>'; 
		echo "<form method=\"".$form['metodo']."\" name=\"$nomeForm\" action=\"".$_SERVER['PHP_SELF']."\">";
		echo "<input type=\"hidden\" name=\"jsIsEnabled\" value=\"NO\"/>";
		$leggende = 0;
		for ($i = 0; $i < mysql_num_rows($fields); $i++){
			$field = mysql_fetch_array($fields);
			switch($field["tipo"]){
			
				//////////Campo legend
				case 'legend':
					if($leggende > 0 && $field["setPrecedente"] == 'n'){
						echo "</fieldset>";
						$leggende--;
						}
					if($field['richiesto'] == 'y'){
						echo "<fieldset>\n\t<legend>".$field['nome']."</legend>\n\t";
						$leggende++;
						}
					break;
					
				/////////Campo conferma pass	
				case 'confermaPass':
					$field['tipo'] = "password";
					stampaCampo($field);
					$field["nome"] = "pass2";
					$field["descrizione"] = "Reinserisci la password";
					stampaCampo($field);
					break;
					
				/////////Campo submit	
				case 'submit':?>
					<script type="text/javascript">
					<!--
					document.write('<button type="button" name="<?php echo $field['nome']; ?>" value="<?php echo $field['valore']; ?>"onclick="checkForm();"><?php echo $field['descrizione']; ?></button>');
					// -->
					</script>
					<noscript>
						<input type=submit name="<?php echo $field['nome']; ?>" value="<?php echo $field['valore']; ?>">
					</noscript><?php
					if($field['aCapo'] == 'y')
						echo "<br/>";
				break;
				
				//////////Campo reset
				case 'reset':?>
					<script type="text/javascript">
					<!--
					document.write('<button type="button" name="<?php echo $field['nome']; ?>" value="<?php echo $field['valore']; ?>"onclick="confermaEliminazione();"><?php echo $field['descrizione']; ?></button>');
					// -->
					</script>
					<noscript>
						<input type=reset name="<?php echo $field['nome']; ?>" value="<?php echo $field['valore']; ?>">
					</noscript><?php
					if($field['aCapo'] == 'y')
						echo "<br/>";
				break;
				
				//////////Altri campi	
				default:
					stampaCampo($field);
					break;
			}
		}
		for($i=0; $i < $leggende; $i++)///Chiudo tutti i fieldset aperti
			echo "</fieldset>";
		echo "*: campi richiesti";
	}
		     
	function stampaCampo($campo){
			echo $campo['descrizione']. ": ";
			if($campo['richiesto'] == 'y')
				echo '*';
			echo "<input type=\"".$campo['tipo']."\" name=\"".$campo['nome']."\" value=\"".getValue($campo["valore"])."\"";
			if($campo["setPrecedente"] == 'y')
				echo setPrecedenti($campo['nome']);
			echo "\">";
			if($campo['aCapo'] == 'y')
				echo "<br/>";
		}
		
	function getValue($value){
		if(function_exists($value))
			return call_user_func($value);
		else 
			return $value;
	}
	
	function getFieldControls($campo){
		$controlli = $campo["controlli"];
		if(is_null($controlli))
			return null;
		//echo $controlli;
		return explode(',', $controlli);
	}	
		
	function campoNecessitaControllo($tipo){
		$tipiDaControllare = array(1 => 'text','textfield','password','confermaPass','login');
		if(!array_search($tipo, $tipiDaControllare))
			return false;
		else
			return true;
	}
	
	function userName(){
		$info = getUserInfo(USER);
		return $info["nome"];
	}
	
	function userCognome(){
		$info = getUserInfo(USER);
		return $info["cognome"];
	}
	
	function userPlace(){
		$info = getUserInfo(USER);
		return $info["luogo"];
	}
	
	function userMail(){
		$info = getUserInfo(USER);
		return $info["email"];
	}
	
	/*
	$paginaControllo = "newsletter.php";
	$paginaRegistrazione = "newsletter.php";

	function checkRegistration($vect){
	$controllo = true;
	global $errori; $errori = "";
	
	global $nickname; $nickname = $vect['nickname'];
	global $mail; $mail = $vect['email'];
	$controllo = $controllo & controlloUser($nickname);
	$controllo = $controllo & controlloEmail($mail);
	if(isset($vect['jsIsEnabled']) && $vect['jsIsEnabled'] == 'YES' && !SERVER_FORM_CONTROL)
		return $controllo;
	
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

function checkEditProfile($vect){
	require_once("config.php");
	if(isset($vect['jsIsEnabled']) && $vect['jsIsEnabled'] == 'YES' && !SERVER_FORM_CONTROL)
		return true;
	global $nome; $nome = $vect['nome'];
	$nomeName = "Nome";
	global $cognome; $cognome = $vect['cognome'];
	$cognomeName = "Cognome";
	global $luogo; $luogo = $vect['luogo'];
	$luogoName = "Luogo";
	global $errori; $errori = "";
	
	$controllo = true;
	
	//Controllo se i campi sono stati riempiti
	$controllo = $controllo & isSetted($nome, $nomeName);
	$controllo = $controllo & isSetted($cognome, $cognomeName);
	
	//Controllo se il nickname
	
	//Controllo se i campi nome e cognome hanno lunghezza accettabile
	$controllo = $controllo & isLong($nome, $nomeName);
	$controllo = $controllo & isLong($cognome, $cognomeName);
	
	//Controllo se i campi contengono caratteri proibiti
	$controllo = $controllo & !hasProhibitedChars($nome, $nomeName);
	$controllo = $controllo & !hasProhibitedChars($cognome, $cognomeName);
	$controllo = $controllo & !hasProhibitedChars($luogo, $luogoName);
	
	return $controllo;
}*/
/*
function checkEditPassword($vect){
	$controllo = true;
	global $errori; $errori = "";
	global $passold; $passold = $vect['passold'];
	require_once("config.php");
	
	$controllo = $controllo & controlloLogin($passold);
	
	if(isset($vect['jsIsEnabled']) && $vect['jsIsEnabled'] == 'YES' && !SERVER_FORM_CONTROL)
		return $controllo;
		
	global $pass; $pass = $vect['pass1'];
	$passName = "Password";
	global $pass2; $pass2 = $vect['pass2'];
	
	$controllo = $controllo & checkPassword($pass, $pass2);
	
	return $controllo;
	
}*/

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
		$errori .= "Le <strong>password</strong> non coincidono.<br />";
		return false;}
	else
		return true;
}

function isValidMail($mail){
	if(!isExistingEmail($mail))
		return true;
	else{
		global $errori;
		if(USER == "")
			$errori .= "Esiste gi&agrave; un utente con questa <strong>e-mail</strong>, puoi <a href=\"login.php\">effettuare l'accesso qui.</a><br />";
		else $errori .= "Esiste gi&agrave; un utente con questa <strong>e-mail</strong>.<br />"; 
		return false;
	}
}

function controlloEmail($mail){
	if(isMail($mail))
		if(isValidMail($mail))
			return true;
	return false;
}

function controlloUser($utente){
	require_once("DbConn.php");
	if(!isExistingUser($utente))
		return true;
	else{
		global $errori;
		$errori .= "L' <strong>Username</strong> &egrave; gi&agrave; esistente.<br />";
		return false;
	}
}

function confermaPass($pass){
	if(checkPassword($pass, $_POST["pass2"]))
		{	//controlli per adeguatezza password
			return true;//controlli per adeguatezza password
		}
	return false;
}

function notHasProhibitedChars($campo, $nomeCampo){
	return !hasProhibitedChars($campo, $nomeCampo);
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
		//(strpos($campo, '@') === false) &&
		(strpos($campo, '#') === false) &&
		(strpos($campo, '*') === false)){
			return false;
		}
	else{
		$errori = $errori.'Il campo <strong>'.$nomeCampo.'</strong> contiene caratteri proibiti.<br />';
		return true;
		}		
}

function isLong1($campo, $nomeCampo){
	return isLong($campo, $nomeCampo, 1);
}

function isLong4($campo, $nomeCampo){
	return isLong($campo, $nomeCampo, 4);
}

function isLong8($campo, $nomeCampo){
	return isLong($campo, $nomeCampo, 8);
}

function isLong($campo, $nomeCampo, $lungh){
	require_once('config.php');
	global $errori;
	if($campo == "")
		return true;
	if (strlen($campo) < $lungh) {
   		$errori = $errori."Il campo <strong>".$nomeCampo."</strong> deve avere pi&ugrave; di $lungh caratteri.\n<br />";
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

function controlloLogin($pass){
	require_once("DbConn.php");
	global $errori;
	if(loginIsValid(USER, $pass))
		return true;
	else{
		$errori .= "La vecchia password non &egrave; quella giusta.<br />";
		return false;
	}
}

?>