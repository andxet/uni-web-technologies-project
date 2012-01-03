<?php
/*require_once('db.php');
$user = 'root';
$pass = 'root';
$host = 'localhost';
$db_name = 'Sito04_718024';
$Q_GET_ALL_ALBUM = "SELECT * FROM Dischi";
 
/*function dbConnect(){
	$dsn = 'mysql://'.$user.':'.$pass.'@'.$host.'/'.$db_name;
	echo $dsn;
	$db = DB::connect($dsn);
	if (DB::isError($db)){ 
		echo $db->getMessage();
		exit;
	} 
}*/
    
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

/*
function getAlbums(){
	if($db == null)
		dbConnect();
	$result = $db->query($Q_GET_ALL_ALBUM); // check that result was ok
	if (DB::isError($result)){
		echo $db->getMessage();
		exit;
	}		
	return $restult;
}*/

//Query di ricerca

function getMenus(){
	$Q_GET_MENUS = "SELECT * FROM Menu ORDER BY posizione";
	
	$db = dbConnect();
	$menus = mysql_query($Q_GET_MENUS, $db)
		or die("Query non valida: " . mysql_error());
	mysql_close($db);
	return $menus;
}

function getUserControl(){
	$Q_GET_MENUS = "SELECT link, Pagine.nome as nome FROM `Pagine` INNER JOIN `Menu` WHERE `nomeStile` = \"user_control\" ORDER BY Pagine.posizione";
	$db = dbConnect();
	$menus = mysql_query($Q_GET_MENUS, $db)
		or die("Query non valida: " . mysql_error());
	mysql_close($db);
	return $menus;

}
	
function getPages($menu){
	$Q_GET_PAGES = "SELECT * FROM Pagine WHERE menu=$menu ORDER BY posizione";
	
	$db = dbConnect();
	$pages = mysql_query($Q_GET_PAGES, $db)
		or die("Query non valida: " . mysql_error());
	mysql_close($db);
	return $pages;
}

function getTitolo($pagina){
	$Q_GET_TITOLO = "SELECT * FROM  `Pagine` WHERE  `link` =  '$pagina'";
	$db = dbConnect();
	$titolo = mysql_query($Q_GET_TITOLO, $db)
		or die("Query non valida: " . mysql_error());
	mysql_close($db);
	return $titolo;
}

function getUserInfo($user){
	$Q_GET_USER_INFO = "SELECT * FROM `Utenti` WHERE `username` = \"$user\"";
	$db = dbConnect();
	$info = mysql_query($Q_GET_USER_INFO, $db)
		or die("Query non valida: " . mysql_error());
	mysql_close($db);
	return mysql_fetch_array($info);
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
	$Q_EDIT_PASSWORD = "UPDATE  `fumezzi`.`Utenti` SET  `password` =  '".$vett["pass"]."' WHERE  `Utenti`.`username` =  '".USER."';";
	$db = dbConnect();
	$result = mysql_query($Q_EDIT_PASSWORD, $db)
		or die("Query non valida: " . mysql_error());
	mysql_close($db);
	return $result;
}

function getForm($form){
	$Q_GET_FORM = "SELECT * FROM `Form` WHERE `nome` = \"$form\";";
	return eseguiQuery($Q_GET_FORM);
}

function getFormFields($form){
	$Q_GET_FORM_FIELDS = "SELECT * FROM `Campi` WHERE `nomeForm` = \"$form\" ORDER BY `posizione` ASC";
	return eseguiQuery($Q_GET_FORM_FIELDS);
}
	
?>