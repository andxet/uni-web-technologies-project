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
	global $user;
	global $pass;
	global $host;
	global $db_name;
	
	$db = mysql_connect($host, $user, $pass)
		or die("Connessione non riuscita: " . mysql_error());
    mysql_select_db($db_name, $db)
    	or die ("Selezione del database non riuscita");
    return $db;
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

function getAlbums(){
	$Q_GET_ALL_ALBUM = "SELECT * FROM Dischi";

	$db = dbConnect();
	$albums = mysql_query($Q_GET_ALL_ALBUM, $db)
		or die("Query non valida: " . mysql_error());
	mysql_close($db);
	return $albums;
}

function getMenus(){
	$Q_GET_MENUS = "SELECT * FROM Menu ORDER BY posizione";
	
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
	
?>