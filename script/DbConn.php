<?php
    
function dbConnect(){
	require_once('config.php');
	
	$db = mysql_connect(DB_HOST, DB_USER, DB_PASS)
		or die("Connessione non riuscita: " . mysql_error());
    mysql_select_db(DB_NAME, $db)
    	or die ("Selezione del database non riuscita: " . mysql_error());
    return $db;
}

function eseguiQuery($query){
	$db = dbConnect();
	//echo "\n$query";
	$result = mysql_query($query, $db)
		or die("Query non valida: " . mysql_error());
	mysql_close($db);
	return $result;
}

//Query di ricerca

function getMenus(){
	$Q_GET_MENUS = "SELECT * FROM Menu ORDER BY posizione";
	return eseguiQuery($Q_GET_MENUS);
}

function getUserControl(){
	$Q_GET_USER_CONTROL = "SELECT link, Pagine.nome as nome FROM `Pagine` INNER JOIN `Menu` WHERE `Menu`.`nomeStile` = 'user_control' ORDER BY Pagine.posizione";
	return eseguiQuery($Q_GET_USER_CONTROL);
}
	
function getPages($menu){
	$Q_GET_PAGES = "SELECT * FROM `Pagine` WHERE `menu` = '$menu'";
	return eseguiQuery($Q_GET_PAGES);
}

function getPageInfo($page){
	$Q_GET_PAGES = "SELECT * FROM `Pagine` WHERE `link` = '$page'";
	return eseguiQuery($Q_GET_PAGES);
}

function getMenu($menu){
	$Q_GET_MENU = "SELECT * FROM `Menu` WHERE `nome` = '$menu'";
	return eseguiQuery($Q_GET_MENU);
}


function getTitolo($pagina){
	$Q_GET_TITOLO = "SELECT * FROM  `Pagine` WHERE  `link` =  '$pagina'";
	return mysql_fetch_array(eseguiQuery($Q_GET_TITOLO));
}

function getUserInfo($user){
	$Q_GET_USER_INFO = "SELECT * FROM `Utenti` WHERE `username` = \"$user\"";
	return mysql_fetch_array(eseguiQuery($Q_GET_USER_INFO));
}

function getUsers($inizio, $fine){
	if($inizio < 0)
		$inizio *= -1;
	if($fine < 0)
		$inizio *= -1;
	if ($fine < $inizio){
		$temp = $inizio;
  		$inizio = $fine;
  		$fine = $temp;
	}

	$Q_GET_USERS = "SELECT * FROM Utenti LIMIT $inizio, $fine";
	return eseguiQuery($Q_GET_USERS);
}

function getSeries($inizio, $fine){
	if($inizio < 0)
		$inizio *= -1;
	if($fine < 0)
		$inizio *= -1;
	if ($fine < $inizio){
		$temp = $inizio;
  		$inizio = $fine;
  		$fine = $temp;
	}
		
	$Q_GET_SERIES = "SELECT * FROM `Serie` LIMIT $inizio, $fine";
	return eseguiQuery($Q_GET_SERIES);
}

function getFumetti($serie, $inizio, $fine){
	if($inizio < 0)
		$inizio *= -1;
	if($fine < 0)
		$inizio *= -1;
	if ($fine < $inizio){
		$temp = $inizio;
  		$inizio = $fine;
  		$fine = $temp;
	}

	$Q_GET_COMICS = "SELECT * FROM `Fumetti` WHERE `idSerie` = '$serie' LIMIT $inizio, $fine";
	return eseguiQuery($Q_GET_COMICS);
}

function getSerie($idSerie){
	$Q_GET_COMIC = "SELECT * FROM `Serie` WHERE `nome` = '$idSerie'";
	return eseguiQuery($Q_GET_COMIC);
}

function getFumetto($idFumetto){
	$Q_GET_COMIC = "SELECT * FROM `Fumetti` WHERE `idVolume` = '$serie'";
	return eseguiQuery($Q_GET_COMIC);
}

//Query di controllo
function loginIsValid($user, $password){
	$password = md5($password);
	//$Q_GET_USER = "SELECT 'password' FROM 'utenti' WHERE 'username' = \"$user\" AND 'password' = \"$password\"";
	$Q_GET_USER = "SELECT * FROM `Utenti` WHERE `username` = \"$user\" AND `password` = \"$password\"";
	$db = dbConnect();
	//echo $Q_GET_USER;
	//echo $password."<-----";
	$info = mysql_query($Q_GET_USER, $db)
		or die("Query non valida: " . mysql_error());
	if(mysql_num_rows($info) == 1)
		return true;
	else
		return false;
}

function isExistingEmail($mail){
	$Q_SEARCH_EMAIL = "SELECT * FROM `Utenti` WHERE `email` = \"$mail\"";
	$db = dbConnect();
	$result = mysql_query($Q_SEARCH_EMAIL, $db)
		or die("Query non valida: " . mysql_error());
	if(mysql_num_rows($result) == 1){
		return true;
		}
	else
		return false;
}

function isExistingUser($user){
	$Q_SEARCH_USER = "SELECT * FROM `Utenti` WHERE `username` = \"$user\"";
	$db = dbConnect();
	$result = mysql_query($Q_SEARCH_USER, $db)
		or die("Query non valida: " . mysql_error());
	if(mysql_num_rows($result) == 1)
		return true;
	else
		return false;
}

/////////////////////////////////////////FUNZIONI PER IL FUNZIONAMENTO DEI FORM

function getForm($form){
	$Q_GET_FORM = "SELECT * FROM `Form` WHERE `nome` = \"$form\";";
	return eseguiQuery($Q_GET_FORM);
}

function getFormFields($form){
	$Q_GET_FORM_FIELDS = "SELECT * FROM `Campi` WHERE `nomeForm` = \"$form\" ORDER BY `posizione` ASC";
	return eseguiQuery($Q_GET_FORM_FIELDS);
}

//Query di aggiunta
function registraUtente($vett){
	if(!isset($vett))
		return false;
	require_once("config.php");
	$Q_INSERT_USER = "INSERT INTO `Utenti` (`username`, `nome`, `cognome`, `email`, `luogo`, `avatar`, `banned`, `privilegi`, `attivo`, `password`) VALUES ('".$vett['username']."', '".$vett['nome']."', '".$vett['cognome']."', '".$vett['email']."', '".$vett['luogo']."', NULL, CURRENT_TIMESTAMP, 'guest', '".ATTIVAZIONE_UTENTE_DEFAULT."', '".md5($vett['password'])."');";
	$db = dbConnect();
	$result = mysql_query($Q_INSERT_USER, $db)
		or die("Query non valida: " . mysql_error());
	mysql_close($db);
	return $result;
}

//////////////////////////////////////////FUNZIONI DI MODIFICA

function modificaUtente($vett){
	if(!isset($vett))
		return false;
	require_once("config.php");
	$Q_EDIT_USER = "UPDATE  `fumezzi`.`Utenti` SET  `nome` =  '".$vett["nome"]."', `cognome` =  '".$vett["cognome"]."', `luogo` =  '".$vett["luogo"]."' WHERE  `Utenti`.`username` =  '".USER."';";
	$db = dbConnect();
	$result = mysql_query($Q_EDIT_USER, $db)
		or die("Query non valida: " . mysql_error());
	mysql_close($db);
	return $result;
}

function modificaPassword($vett){
	if(!isset($vett))
		return false;
	require_once("config.php");
	$Q_EDIT_PASSWORD = "UPDATE  `fumezzi`.`Utenti` SET  `password` =  '".md5($vett["password"])."' WHERE  `Utenti`.`username` =  '".USER."';";
	$db = dbConnect();
	$result = mysql_query($Q_EDIT_PASSWORD, $db)
		or die("Query non valida: " . mysql_error());
	mysql_close($db);
	return $result;
}

function modificaMail($vett){
	if(!isset($vett))
		return false;
	require_once("config.php");
	$Q_EDIT_MAIL = "UPDATE  `fumezzi`.`Utenti` SET  `email` =  '".$vett['email']."' WHERE  `Utenti`.`username` =  '".USER."';";
	$db = dbConnect();
	$result = mysql_query($Q_EDIT_MAIL, $db)
		or die("Query non valida: " . mysql_error());
	mysql_close($db);
	return $result;
}

function editUserState($vett){
	$Q_EDIT_USER = "UPDATE  `fumezzi`.`Utenti` SET ";
	if($vett["ban"] != null)
		$Q_EDIT_USER .= "`banned` = '".$vett["ban"]."' , ";
	$Q_EDIT_USER .= "`attivo` =  '".$vett["activated"]."' WHERE  `Utenti`.`username` =  '".$vett["user"]."';";
	eseguiQuery($Q_EDIT_USER);
}

	
?>