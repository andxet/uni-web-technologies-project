<?php
    
function dbConnect(){
	//print_r(file_exists("script/dbconf.php"));
	//if(file_exists("script/dbconf.php") === false){
	//	echo "sono dbconn!!!!";
	//	header("Location: install/index.php");}
	require_once('config.php');
	
	$db = mysql_connect(DB_HOST, DB_USER, DB_PASS)
		or die("Connessione non riuscita: " . mysql_error());
	//if(!$db)
	//	header("Location: install/index.php");
    mysql_select_db(DB_NAME, $db)
    	//or die ("Selezione del database non riuscita: " . mysql_error());
    	or header("Location: install/index.php");
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
	$Q_GET_MENU = "SELECT *, count(*) FROM `Menu` WHERE `nome` = '$menu'";
	return eseguiQuery($Q_GET_MENU);
}


function getTitolo($pagina){
	$Q_GET_TITOLO = "SELECT * FROM  `Pagine` WHERE  `link` =  '$pagina'";
	return mysql_fetch_array(eseguiQuery($Q_GET_TITOLO));
}

function getUserInfo($user){
	$Q_GET_USER_INFO = "SELECT * FROM `Utenti` WHERE `username` = '$user'";
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

	$Q_GET_USERS = "SELECT * FROM Utenti"; // LIMIT $inizio, $fine";
	return eseguiQuery($Q_GET_USERS);
}

function getSeries(){
	/*
	if($inizio < 0)
		$inizio *= -1;
	if($fine < 0)
		$inizio *= -1;
	if ($fine < $inizio){
		$temp = $inizio;
  		$inizio = $fine;
  		$fine = $temp;
	}*/
		
	//$Q_GET_SERIES = "SELECT * FROM `Serie` LIMIT $inizio, $fine";
	$Q_GET_SERIES = "SELECT * FROM `Serie` ORDER BY `nome`";
	return eseguiQuery($Q_GET_SERIES);
}

function getSerieComicNum($serie){
	$Q_COUNT_COMICS = "SELECT count(*) AS num FROM `Fumetti` WHERE `idSerie`=\"$serie\" ";
	//echo $Q_COUNT_COMICS;
	$ris = mysql_fetch_array(eseguiQuery($Q_COUNT_COMICS));
	//print_r ($ris);
	return $ris["num"];
}

function getFumetti($serie){/*
	if($inizio < 0)
		$inizio *= -1;
	if($fine < 0)
		$inizio *= -1;
	if ($fine < $inizio){
		$temp = $inizio;
  		$inizio = $fine;
  		$fine = $temp;
	}*/

	$Q_GET_COMICS = "SELECT *, `Serie`.`idSerie` AS `numSerie`, `Fumetti`.`nome` AS `nomeFum` FROM `Fumetti`, `Serie` WHERE `Fumetti`.`idSerie` = '$serie' AND `Fumetti`.`idSerie`=`Serie`.`idSerie` ORDER BY volume";
	//echo $Q_GET_COMICS;
	return eseguiQuery($Q_GET_COMICS);
}

function getSerie($idSerie){
	$Q_GET_SERIES = "SELECT * FROM `Serie` WHERE `idSerie` = '$idSerie'";
	return eseguiQuery($Q_GET_SERIES);
}

function getFumetto($idFumetto){
	$Q_GET_COMIC = "SELECT * FROM `Fumetti` WHERE `idVolume` = '$idFumetto'";
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

function loginIsValid2($user, $password){
	$password = md5($password);
	//$Q_GET_USER = "SELECT 'password' FROM 'utenti' WHERE 'username' = \"$user\" AND 'password' = \"$password\"";
	$Q_GET_USER = "SELECT * FROM `Utenti` WHERE `username` = \"$user\" AND `password` = \"$password\"";
	$db = dbConnect();
	//echo $Q_GET_USER;
	//echo $password."<-----";
	$info = mysql_query($Q_GET_USER, $db)
		or die("Query non valida: " . mysql_error());
	//print_r(mysql_fetch_row($info));
	if(mysql_num_rows($info) == 1){
		$info = mysql_fetch_array($info);
		return $info["privilegi"];
		}
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

function isExistingSeries($user){
	$Q_SEARCH_USER = "SELECT * FROM `Utenti` WHERE `username` = \"$user\"";
	$db = dbConnect();
	$result = mysql_query($Q_SEARCH_USER, $db)
		or die("Query non valida: " . mysql_error());
	if(mysql_num_rows($result) == 1)
		return true;
	else
		return false;
}

function eliminaSerie($serie){
	require_once(SCRIPT_PATH."immagini.php");
	$q = "DELETE FROM `Serie` WHERE `Serie`.`idSerie` = '$serie'";
	if(eseguiQuery($q)){
		eliminaSerieImg($serie);
		return true;}
	return false;

}

function eliminaFumetto($fumetto){
	require_once(SCRIPT_PATH."immagini.php");
	$q = "DELETE FROM `Fumetti` WHERE `Fumetti`.`idVolume` = '$fumetto'";
	if(eseguiQuery($q)){
		eliminaFumettoImg($fumetto);
		return true;}
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
	$Q_INSERT_USER = "INSERT INTO `Utenti` (`username`, `nome`, `cognome`, `email`, `luogo`, `banned`, `privilegi`, `attivo`, `password`) VALUES ('".$vett['username']."', '".$vett['nome']."', '".$vett['cognome']."', '".$vett['email']."', '".$vett['luogo']."', CURRENT_TIMESTAMP, 'guest', '".ATTIVAZIONE_UTENTE_DEFAULT."', '".md5($vett['password'])."');";
	$db = dbConnect();
	$result = mysql_query($Q_INSERT_USER, $db)
		or die("Query non valida: " . mysql_error());
	mysql_close($db);
	return $result;
}

function aggiungiSerie($vett){
	if(!isset($vett))
		return false;
	require_once("config.php");
	require_once("immagini.php");
	
	if(serieEsistente($vett))
		return false;
	
	$Q_INSERT_SERIE = "INSERT INTO  `Serie` (`nome` , `inCorso`) VALUES ( '".$vett['nome']."', ";
	if(isset($vett["inCorso"]))
		$Q_INSERT_SERIE .= " 'true' ";
	else
		$Q_INSERT_SERIE .= " 'false' ";
	$Q_INSERT_SERIE .= ");";
	$db = dbConnect();
	$ris = mysql_query($Q_INSERT_SERIE, $db)
		or die("Query non valida: " . mysql_error());
	$id = mysql_insert_id();
	if($ris && !uploadSerieImg($id))
		return false;
	else
		return true;
}

function aggiungiFumetto($vett){
	if(!isset($vett))
		return false;
	require_once("config.php");
	require_once("immagini.php");

	if(volumeEsistente($vett))
		return false;
	
	$Q_ADD_COMIC = "INSERT INTO  `Fumetti` (`idVolume` ,`idSerie` ,`nome` ,`volume` ,`dataUscita`) VALUES (NULL ,  '".$vett["serie"]."', '".$vett["nome"]."',  '".$vett["volume"]."', NOW( ));";
	$db = dbConnect();
	$ris = mysql_query($Q_ADD_COMIC, $db)
		or die("Query non valida: " . mysql_error());
	$id = mysql_insert_id();
	if($ris && !uploadFumettoImg($id))
		return false;
	else
		return true;	
}

function volumeEsistente($vett){
	$q = "SELECT * FROM `Fumetti` WHERE `idSerie` = '".$vett["serie"]."' AND `volume` = '".$vett["volume"]."';";
	if(mysql_num_rows(eseguiQuery($q)) > 0){
		global $errori;
		$errori .= "Questo volume esiste gi&agrave;.";
		return true;
	}
	return false;
}

function serieEsistente($vett){
	$q = "SELECT * FROM `Serie` WHERE `nome` = '".$vett["nome"]."';";
	if(mysql_num_rows(eseguiQuery($q)) > 0){
		global $errori;
		$errori .= "Esiste gi&agrave; una serie con questo nome.";
		return true;
	}
	return false;
}

//Fumzioni per la lista
function getFumettiPosseduti($serie){
	$QUERY = "SELECT `idVolume` FROM `Legge`, `Fumetti` WHERE `Legge`.`fumetto`=`Fumetti`.`idVolume` AND `utente`='".USER."' AND `Fumetti`.`idSerie`='$serie'";
	//echo $QUERY;
	$ris = array();
	$qris = eseguiQuery($QUERY);
	for ($i = 0; $i < mysql_num_rows($qris); $i++){
		$array = mysql_fetch_array($qris);
		$ris[] = $array[0];
		}
	return $ris;
}

//////////////////////////////////////////FUNZIONI DI MODIFICA

function modificaSerie($vett){
	if(!isset($vett))
		return false;
	require_once("config.php");
	require_once("immagini.php");
	
	$idSerie = $vett["idSerie"];
	$nome = $vett["nome"];
	if(isset($vett["inCorso"]))
		$inCorso = "true";
	else
		$inCorso = "false";
	
	if(fileIsSet())
		if(!uploadSerieImg($vett["idSerie"]))
			return false;
	$q = "UPDATE  `Serie` SET  `nome` =  '$nome', `inCorso` =  '$inCorso' WHERE  `Serie`.`idSerie` = '$idSerie';";
	return eseguiQuery($q);
}

function modificaFumetto($vett){
	if(!isset($vett))
		return false;
	require_once("config.php");
	require_once("immagini.php");
	
	$idVolume = $vett["idVolume"];
	$nome = $vett["nome"];
	$volume = $vett["volume"];
	
	if(fileIsSet())
		if(!uploadFumettoImg($vett["idVolume"]))
			return false;
	
	$q = "UPDATE  `Fumetti` SET  `nome` =  '$nome', `volume` =  '$volume' WHERE  `Fumetti`.`idVolume` ='$idVolume';";
	return eseguiQuery($q);
}

function modificaUtente($vett){
	if(!isset($vett))
		return false;
	require_once("config.php");
	require_once("immagini.php");
	if(fileIsSet())
		if(!uploadAvatarImg(USER))
			return false;
	$Q_EDIT_USER = "UPDATE  `Utenti` SET  `nome` =  '".$vett["nome"]."', `cognome` =  '".$vett["cognome"]."', `luogo` =  '".$vett["luogo"]."' WHERE  `Utenti`.`username` =  '".USER."';";
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
	$Q_EDIT_PASSWORD = "UPDATE  `Utenti` SET  `password` =  '".md5($vett["password"])."' WHERE  `Utenti`.`username` =  '".USER."';";
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
	$Q_EDIT_MAIL = "UPDATE  `Utenti` SET  `email` =  '".$vett['email']."' WHERE  `Utenti`.`username` =  '".USER."';";
	$db = dbConnect();
	$result = mysql_query($Q_EDIT_MAIL, $db)
		or die("Query non valida: " . mysql_error());
	mysql_close($db);
	return $result;
}

function editUserState($vett){
	$Q_EDIT_USER = "UPDATE  `Utenti` SET ";
	if($vett["ban"] != null)
		$Q_EDIT_USER .= "`banned` = '".$vett["ban"]."' , ";
	if(isset($vett["privilegi"]))
		$Q_EDIT_USER .= "`privilegi` = '".$vett["privilegi"]."' , ";
	$Q_EDIT_USER .= "`attivo` =  '".$vett["activated"]."' WHERE  `Utenti`.`username` =  '".$vett["user"]."';";
	eseguiQuery($Q_EDIT_USER);
}

//Query di eliminazione
function eliminaUtente($utente){
	require_once(SCRIPT_PATH."immagini.php");
	$Q_DELETE_USER = "DELETE FROM `Utenti` WHERE `Utenti`.`username` = '$utente'";
	if(eseguiQuery($Q_DELETE_USER)){
		eliminaAvatarImg($utente);
		return true;}
	return false;
	
	}

function numFumettiPosseduti($user){
	$query = "SELECT count(*) FROM `Legge` WHERE `utente`='$user'";
	$num = mysql_fetch_row(eseguiQuery($query));
	return $num[0];
}

function getListaFumetti($user){
	$query = "SELECT `Serie`.`idSerie`, `Serie`.`nome` AS nomeSerie, `Fumetti`.`nome` AS nomeFum, `Fumetti`.`volume`, `Fumetti`.`idVolume`, `dataUscita`, `letto` FROM `Serie` INNER JOIN `Fumetti` ON `Serie`.`idSerie` = `Fumetti`.`idSerie` INNER JOIN `Legge` ON `Fumetti`.`idVolume` = `Legge`.`fumetto` WHERE utente='$user' ORDER BY `Serie`.`nome` ASC, `Fumetti`.`volume` ASC";
	return eseguiQuery($query);
}

//Funzioni di ricerca
//Funzioni per la pagina cerca.php
function searchFumetti($p, $ordine){
	//$p = htmlspecialchars($p, ENT_QUOTES);
	$query = "SELECT *, nome as `nomeFum` FROM `Fumetti` WHERE `Fumetti`.`nome` LIKE '%$p%' OR `volume` like '$p' ORDER BY '$ordine' ";
	return eseguiQuery($query);

}
function searchSerie($p, $ordine){
	//$p = htmlspecialchars($p, ENT_QUOTES);
	$query = "SELECT * FROM `Serie` WHERE `nome` LIKE '%$p%' ORDER BY '$ordine'";
	return eseguiQuery($query);
}
function searchUtenti($p, $ordine){
	$par = explode(" ", $p);
	$query = "SELECT DISTINCT * FROM `Utenti` WHERE ";
	for($i=0; $i<count($par); $i++){
		//$p = htmlspecialchars($p, ENT_QUOTES);
		$query.= "`nome` LIKE '%$p%' OR `cognome` LIKE '%$p%' OR `luogo` LIKE '%$p%' OR `username` LIKE '%$p%'";
		if($i < count($par) - 1)
			$query .= " OR ";
		}
	$query .= " ORDER BY `$ordine`";
	return eseguiQuery($query);
}

function getRichiesteAmicizia($user){
	$q = "SELECT * FROM `Richieste` JOIN `Utenti` ON `Richieste`.`richiedente`=`Utenti`.`username` WHERE `amico` = '$user' AND `richiedente` NOT IN (SELECT `amico` FROM `Richieste` WHERE `richiedente` = '$user');";
	return eseguiQuery($q);
}
	
function getAmiciDb($user){
	$q = "SELECT `Utenti`.`username`, `Utenti`.`nome`, `Utenti`.`cognome`, `Utenti`.`luogo` FROM `Richieste` AS `r1` JOIN `Richieste` AS `r2` ON `r1`.`amico` = `r2`.`richiedente` JOIN `Utenti` ON `r1`.`amico`=`Utenti`.`username`  WHERE `r1`.`richiedente` = '$user' AND `r1`.`richiedente` = `r2`.`amico` ORDER BY `Utenti`.`username`; ";
	//echo $q;
	return eseguiQuery($q);
}

function getRichieste($user){
	$q = "SELECT `amico` FROM `Richieste` WHERE `richiedente` = '$user';";
	$r = eseguiQuery($q);
	$c = array();
	for ($j = 0; $j < mysql_num_rows($r); $j++){
		$arr = mysql_fetch_array($r);
		$c[] = $arr[0];
		}
	return $c;
}

function isAmico($utente, $diUtente){
	$q1 = "SELECT * FROM `Richieste` WHERE `amico` = '$utente' AND `richiedente` = '$diUtente'";
	$q2 = "SELECT * FROM `Richieste` WHERE `amico` = '$diUtente' AND `richiedente` = '$utente'";
	$r1 = mysql_num_rows(eseguiQuery($q1));
	$r2 = mysql_num_rows(eseguiQuery($q2));
	return (($r1 + $r2) == 2);
}
?>