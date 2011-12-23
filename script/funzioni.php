<?php 

function inizializza(){
require_once(config.php);
// Starting the session 
session_start(); 

if(isset($_SESSION['user'])) 
        define('USER', $_SESSION['user']);  
else 
    { 
    	if(isset($_COOKIE['nome']))
    		header("Location: ".LOGIN_PAGE);
    	else
			header("Location: ".WELCOME_PAGE);
    } 
?>

function stampa_menu(){
	global $script_path;
	global $css_path;
	global $gallery_path;
	global $miniature_path;
	global $images_path;
	require_once('DbConn.php');
	require_once('config.php');
	$menus = getMenus();
	for ($i = 0; $i < mysql_num_rows($menus); $i++){
		$menu = mysql_fetch_array($menus);
		echo "<div class=\"vnav\">";
		echo "	<h3 onclick=\"menuToggle($i)\" ><img src=\"".$images_path."freccia-basso.png\" alt=\"Menu espanso\"name=\"freccia$i\" />".$menu['nome']."</h3>";
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

function printTitolo($pagina){
	require_once('DbConn.php');
	$titolo = mysql_fetch_array(getTitolo($pagina));
	if($titolo === false)
		echo "AC/DC fan page";
	else
		echo $titolo['titolo'];
}

function printHeader(){
	global $images_path;
	echo "<img src=\"".$images_path."acdc_logo_band.png\" height=\"100px\" alt=\"Logo ACDC\">";
    echo "<h3>It's a long way to the top (if you wanna rock'n roll)</h3>";
}

function printFooter(){
	echo "<p class=\"menu\"><a href=\"http://wikipedia.org\">Wikipedia</a>&nbsp;|&nbsp;<a href=\"http://www.acdc.com\">Official Site</a>&nbsp;|&nbsp;<a href=\"mailto:andrea.peretti@studenti.unito.it\">Contact</a></p>";
}

?>