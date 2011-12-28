<?php 
//Funzioni per il login
function userIsLogged(){
	return isset($_SESSION['user']);
}

function userHasVisited(){
	return isset($_COOKIE['nome']);
}

function inizializza(){//setta come variabile globale il nome utente
require_once("config.php");
// Starting the session 
session_start(); 

if(userIsLogged()) 
        define('USER', $_SESSION['user']);  
else 
    { 
    	if(userHasVisited())
    		header("Location: ".LOGIN_PAGE);
    	else
			header("Location: ".WELCOME_PAGE);
    }
}

//Funzioni per la gestione dei menu
function stampa_menu(){
	require_once('DbConn.php');
	require_once('config.php');
	$menus = getMenus();
	for ($i = 0; $i < mysql_num_rows($menus); $i++){
		$menu = mysql_fetch_array($menus);
		echo "<div class=\"vnav\">";
		echo "	<h3 onclick=\"menuToggle($i)\" ><img src=\"".IMAGES_PATH."freccia-basso.png\" alt=\"Menu espanso\"name=\"freccia$i\" />".$menu['nome']."</h3>";
		echo "	<ul id=\"show\">";
		$pagine = getPages($i);
		for ($j = 0; $j < mysql_num_rows($pagine); $j++){
			$pagina = mysql_fetch_array($pagine);
			echo "<li><a href=\"".$pagina['link']."\">".$pagina['nome']."</a></li>";
		}
		echo "	</ul>";
		echo "</div>";
	}
	
}

function printHead(){
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" >";
	echo "<script src=\"".SCRIPT_PATH."\"menu.js\" type=\"text/javascript\"></script>";
	echo "<title>"; printTitolo($_SERVER['PHP_SELF']); echo"</title>";
   	echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"".CSS_PATH."style_layout.css\" >";
}

function printTitolo($pagina){
	require_once('DbConn.php');
	$titolo = mysql_fetch_array(getTitolo($pagina));
	if($titolo === false)
		echo SITE_NAME;
	else
		echo $titolo['titolo'];
}

function printHeader(){
	echo "<img src=\"".IMAGES_PATH."logo.png\" height=\"100px\" alt=\"Logo ACDC\">";
}

function printFooter(){
	echo "<p class=\"menu\"><a href=\"http://wikipedia.org\">Wikipedia</a>&nbsp;|&nbsp;<a href=\"http://www.acdc.com\">Official Site</a>&nbsp;|&nbsp;<a href=\"mailto:andrea.peretti@studenti.unito.it\">Contact</a></p>";
}

function printUserControl(){
	require_once("DbConn.php");
	$uc = getUserControl();
	
	for ($i = 0; $i < mysql_num_rows($uc); $i++){
		$pagina = mysql_fetch_array($uc);
		if($pagina['nome'] == "USER")
			$pagina['nome'] = USER;
		echo "<button><a href=\"".$pagina['link']."\">".$pagina['nome']."</a></button>";
	}
}

function printMenu($stile){
	require_once('DbConn.php');
	require_once('config.php');
	$menus = getMenus();
	for ($i = 0; $i < mysql_num_rows($menus); $i++){
		$menu = mysql_fetch_array($menus);
		if($menu['nomeStile'] != $stile)
			continue;
		echo "<div id=\"$stile\">";
		//echo "	<h3 onclick=\"menuToggle($i)\" ><img src=\"".IMAGES_PATH."freccia-basso.png\" alt=\"Menu espanso\"name=\"freccia$i\" />".$menu['nome']."</h3>";
		//echo "	<ul id=\"show\">";
		$pagine = getPages($i);
		for ($j = 0; $j < mysql_num_rows($pagine); $j++){
			$pagina = mysql_fetch_array($pagine);
			echo "<button><a href=\"".$pagina['link']."\">".ricavaNome($pagina['nome'])."</a></button>";
		}
		//echo "	</ul>";
		echo "</div>";
	}
}

function ricavaNome($nome){
	switch ($nome){
		case "__USER__":
			return USER;
			break;
		default:
			return $nome;
			break;
	}
}

//Script per pagine specifiche
function welcome_script(){//Se l'utente ha effettuato l'accesso o ha già visitato il sito, viene mandato alle rispettiva pagine.
	session_start();
	if(userIsLogged())
		header("Location: " . HOME_PAGE);
	if(userHasVisited())
		header("Location: " . LOGIN_PAGE);
}

function login_script(){//Se l'utente ha effettuato l'accesso o ha già visitato il sito, viene mandato alle rispettiva pagine.
	session_start();
	if(userIsLogged())
		header("Location: " . HOME_PAGE);
	
	if(isset($_POST) && isset($_POST['username']) && isset($_POST['password'])){
		require_once(SCRIPT_PATH."DbConn.php");
		if(loginIsValid($_POST['username'], $_POST['password'])){
			$_SESSION['user'] = $_POST['username'];
			setcookie('user', $_SESSION['user'], time()+3600);
			header("Location: " . HOME_PAGE);
			}
		else{
			global $errori;
			$errori = "Hai inserito delle credenziali errate. Riprova.<br />"; 
		}
			
	}
		
}

function logout(){
	$_SESSION = array();
	session_destroy();
}

function userInfo($user){
	require_once(SCRIPT_PATH."DbConn.php");
	$userInfo = getUserInfo($user);
	echo "<div id=\"userInfo\">";
	echo "<img src=\"".AVATAR_PATH.$userInfo['avatar']."\" />";
	echo "<div id=\"username\">".$userInfo['username']."</div>";
	echo "<div id=\"nome\">".$userInfo['nome']."</div>";
	echo "<div id=\"cognome\">".$userInfo['cognome']."</div>";
	echo "<div id=\"luogo\">".$userInfo['luogo']."</div>";
	echo "</div>";
}

function stampaBacheca(){
	
}

?>