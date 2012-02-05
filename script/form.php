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
					if(!isset($_POST[$campo["nome"]]))
						$_POST[$campo["nome"]] = null;
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
		if($form["controlloJS"] != null)
			echo "<script src='".SCRIPT_PATH."form.js' type='text/javascript'></script>";
		echo "<form method='".$form['metodo']."' name='$nomeForm' action='".$_SERVER['PHP_SELF']."' enctype='multipart/form-data'>";
		echo "<input type='hidden' name='jsIsEnabled' value='NO'/>";
		$leggende = 0;
		for ($i = 0; $i < mysql_num_rows($fields); $i++){
			$field = mysql_fetch_array($fields);
			echo "\n";
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
				case 'submit':
					if($form["controlloJS"] != null){
						?>
						<script type="text/javascript">
						<!--
						document.write('<button type="button" name="<?php echo $field['nome']; ?>" value="<?php echo $field['valore']; ?>" onclick="<?php echo $form["controlloJS"]; ?>();"><?php echo $field['descrizione']; ?></button>');
						// -->
						</script>
						<noscript><?php ;
					}
					?>
						<input type=submit name="<?php echo $field['nome']; ?>" value="<?php echo $field['valore']; ?>" />
					<?php //</noscript><?php
					if($field['aCapo'] == 'y')
						echo "<br/>";
				break;
				
				//////////Campo reset
				case 'reset':
					if($form["controlloJS"] != null)
					?>
						<input type=reset name="<?php echo $field['nome']; ?>" value="<?php echo $field['valore']; ?>" />
					<?php //</noscript><?php
					if($field['aCapo'] == 'y')
						echo "<br/>";
				break;
				//////////Campo check
				case 'checkbox':
					echo $field['descrizione']. ": ";
					if($field['richiesto'] == 'y')
						echo '*';
					echo "<input type='".$field['tipo']."' name='".$field['nome']."' value='".getValue($field["valore"])."'";
					if($field["setPrecedente"] == 'y')
						echo setPrecedenti($field['nome']) == "true" ? "checked" : "";
					echo "'>";
					if($field['aCapo'] == 'y')
						echo "<br/>";
					break;
				//////////Campo select
				case 'select':
					echo $field['descrizione']. ": ";
					if($field['richiesto'] == 'y')
						echo '*';
					echo "<select name='".$field['nome']."' ".getValue($field["valore"])."</select>";//Chiudere il tag '>' nella funzione chiamata!!!
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
			if($campo["tipo"] != "hidden"){
				echo $campo['descrizione']. ": ";
				if($campo['richiesto'] == 'y')
					echo '*';
				}
			echo "<input type='".$campo['tipo']."' name='".$campo['nome']."' value='".getValue($campo["valore"]);
			if($campo["setPrecedente"] == 'y')
				echo setPrecedenti($campo['nome']);
			echo "' />";
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
		$tipiDaControllare = array(1 => 'text','textfield','password','confermaPass','login', 'file', 'checkbox', 'int', 'data');
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
	
	function getSerieIndex(){
		return $_GET["serie"];
	}
	
	function setSerieGet(){
		global $serie;
		return $serie["idSerie"];
	}
	
	function setIdVolumeGet(){
		global $fumetto;
		return $fumetto["idVolume"];
	}
	
function isSetted($campo, $nomeCampo){
	global $errori;
	if (($campo == "") || ($campo == null)) {
	   $errori = $errori.'Il campo <strong>'.$nomeCampo.'</strong> &egrave; obbligatorio.<br />';
	   return false;}
	else
		return true;
}

function fileIsSet(){
	global $errori;
	if(!is_uploaded_file($_FILES['nomefile']['tmp_name'])) {
		$errori = $errori."Non &egrave; stato selezionato nessun file per l'upload.<br />";
		return false;
	}
	if($_FILES["nomefile"]["error"] == 4){
		return false;
	}
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

function checkData($data){
	global $errori;
	if($stamp = strtotime($data) === false){
		$errori .= "La <strong>data<strong> ha un formato non corretto.<br />";
		return false;
		}
	if(checkdate(date('m', $stamp), date('d', $stamp), date('Y', $stamp)))
		return true;
	else{
		$errori .= "La <strong>data<strong> non &egrave; valida.<br />";
		return false;
	}
}

function controlloVolume($volume){
	global $errori;
	if($volume < 0){
		$errori .= "Il <strong>numero del volume</strong> non &egrave; valido.<br />";
		return false;
		}
	return $volume > 0;
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

function cercaCose(){
	$p = $_POST["parolaChiave"];
	$cosa = $_POST["cosa"];
	$ordine = $_POST["ordine"];
	require_once("DbConn.php");
	global $risultati;
	$risultati = array();
	switch($cosa){
		case "tutto":
			$risultati["fumetti"] = searchFumetti($p, "nome, volume");
			$risultati["serie"] = searchSerie($p, "nome");
			$risultati["utenti"] = searchUtenti($p, "username");
			break;
		case "fumetti":
			$risultati["fumetti"] = searchFumetti($p, $ordine);
			break;
		case "serie":
			$risultati["serie"] = searchSerie($p, $ordine);
			break;
		case "utenti":
			$risultati["utenti"] = searchUtenti($p, $ordine);
			break;
	}
	return true;
}

function getCosaCercare(){
	$r = "onChange='aggiornaOrdine(this.form.ordine, this.options[this.selectedIndex].value);'>";
	$r .= "<option value='tutto'>Tutto</option>";
 	$r .= "<option value='serie'>Serie</option>";
 	$r .= "<option value='fumetti'>Fumetti</option>";
 	$r .= "<option value='utenti'>Utenti</option>";
 	return $r;
}

function getComeOrdinare(){
	return "><option value='nome'>Nome/username</option>";
	//$r .= "<option value='inCorso'>In corso</option>";
 	//$r .= "<option value='nFum'>Numero fumetti</option>";
 	//return $r;
}


function cosaCercare($cosa){
	global $errori;
	echo $cosa;
	if($cosa == 'unset'){
		$errori .= "Non hai specificato <strong>cosa cercare.</strong><br />";
		return false;
		}
	return true;
		
}

function valFumettoNome(){
	global $fumetto;
	return $fumetto["nome"];
}

function valFumettoNum(){
	global $fumetto;
	return $fumetto["volume"];
}

function getNomeSerie(){
	require_once("DbConn.php");
	global $serie;
	return $serie["nome"];
}

?>