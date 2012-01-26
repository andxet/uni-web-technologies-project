<?php 
//Funzioni per il login
function userIsLogged(){
	return isset($_SESSION['user']);
}

function userHasVisited(){
	return isset($_COOKIE['nome']);
}

function userIsBanned($user){
	if(getDataNumber($user) > time())
		return true;
	else
		return false;
}

function userIsActive($user){
	if($user == 'false')
		return false;
	else return true;
}

function isAuthorizedUser($user, $page){
	//echo $page;
	require_once("DbConn.php");
	$userInfo = getUserInfo($user);
	if(userIsBanned($userInfo["banned"]))
		return "ban";
	if(!userIsActive($userInfo["attivo"]))
		return "inactive";
	$pageInfo = mysql_fetch_array(getPageInfo($page));
	if($pageInfo == null)
		return "ok";
	$permessiPagina = explode(",", $pageInfo["permessi"]);
	if(in_array($userInfo["privilegi"], $permessiPagina)){
		//if(!isset(PRIVILEGI))
		return "ok";
		}
	else 
		return "noAut";
}


function inizializza(){//setta come variabile globale il nome utente
require_once("config.php");
// Starting the session 
session_start(); 

	if(userIsLogged()){
		$login = isAuthorizedUser($_SESSION['user'], str_replace("/", "", $_SERVER['PHP_SELF']));
		switch($login){
			case "ok":
				define('USER', $_SESSION['user']);
				define('PRIVILEGI', $_SESSION['privilegi']);
				return true;
				break;
			case 'inactive':
				logout();
				header("Location: ".ACTIVE_PAGE);
				//$errori = "Il tuo account non &egrave; attivo.<br />";
				break;
			case 'ban':
				logout();
				header("Location: ".BAN_PAGE);
				//$errori = "L'utente &egrave; bannato.<br />";
				break;
			case 'noAut':
	    			header("Location: ".HOME_PAGE);
				break;
			}
	}
	else{
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
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" >\n";
	//echo "<script src=\"".SCRIPT_PATH."menu.js\" type=\"text/javascript\"></script>\n";
	echo "<title>"; printTitolo($_SERVER['PHP_SELF']); echo"</title>\n";
   	echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"".CSS_PATH."style_layout.css\" >\n";
}

function printTitolo($pagina){
	require_once('DbConn.php');
	$titolo = getTitolo($pagina);
	if($titolo === false)
		echo SITE_NAME;
	else
		echo $titolo['titolo'];
}

function printHeader(){
	require_once("config.php");
	echo "<a href=\"index.php\"><img src=\"".IMAGES_PATH.LOGO_NAME."\" height=\"100px\" alt=\"".SITE_NAME."\">";
}

function printFooter(){
	echo "<p>Realizzato da <a href=\"mailto:andrea.peretti@studenti.unito.it\">Andrea Peretti</a> - 2012</p>";
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

function printMenu($nome){
	require_once('DbConn.php');
	require_once('config.php');
	$menus = getMenu($nome);
	$menus = mysql_fetch_array($menus);
	echo "<div id=\"".$menus["nomeStile"]."\">";
	$pagine = getPages($nome);
	for ($j = 0; $j < mysql_num_rows($pagine); $j++){
		$pagina = mysql_fetch_array($pagine);
		if(!in_array(PRIVILEGI, explode(",", $pagina["permessi"]))){
			continue;}
		if(file_exists($pagina['link']))
			if(function_exists($pagina["nome"]))
				call_user_func($pagina["nome"]);
			else
				echo "<button><a href=\"".$pagina['link']."\">".$pagina['nome']."</a></button>";
	}
	echo "</div>";
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

function printUser(){
	echo "<button><a href=\"profilo.php\">".USER."</a></button>";;
}

function nuovaSerieButton(){
	echo "<a href=aggiungiSerie.php><img src='".ADD_IGM."' />Nuova serie</a>";
}

function nuovoFumettoButton(){
	$serie = $_GET["serie"];
	//echo $serie;
	echo "<a href=\"aggiungiFumetto.php?serie=".$serie."\"><img src='".ADD_IGM."' />Nuovo fumetto</a>";
	/*?>
	
	<a href=aggiungiFumetto.php?serie=<?php echo $serie; ?> ><img src='<?php echo ADD_IGM; ?>' />Nuovo fumetto</a>
	<?php*/
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
		$permessi = loginIsValid2($_POST['username'], $_POST['password']);
		if($permessi == false){
			global $errori;
			$errori = "Hai inserito delle credenziali errate. Riprova.<br />"; 
		}
		else{
			$_SESSION['user'] = $_POST['username'];
			$_SESSION['privilegi'] = $permessi;
			setcookie('user', $_SESSION['user'], time()+3600);
			header("Location: " . HOME_PAGE);
			}
			
	}
		
}

function logout(){
	// Initialize the session.
	// If you are using session_name("something"), don't forget it now! session_start();
	// Unset all of the session variables.
	$_SESSION = array();
	// If it's desired to kill the session, also delete the session cookie. // Note: This will destroy the session, and not just the session data! 
	if (ini_get("session.use_cookies")) {
	$params = session_get_cookie_params(); 
	setcookie(session_name(), '', time() - 42000,
		$params["path"], $params["domain"],
		$params["secure"], $params["httponly"] );
	}
	// Finally, destroy the session.
	session_destroy();


//	$_SESSION = array();
//	session_destroy();
}

function userInfo($user){
	require_once(SCRIPT_PATH."DbConn.php");
	$userInfo = getUserInfo($user);
	echo "<div id=\"userInfo\">";
	echo "<img src=\"".getAvatarPath($userInfo['avatar'])."\" />";
	echo "<div id=\"username\">".$userInfo['username']."</div>";
	echo "<div id=\"nome\">".$userInfo['nome']."</div>";
	echo "<div id=\"cognome\">".$userInfo['cognome']."</div>";
	echo "<div id=\"luogo\">".$userInfo['luogo']."</div>";
	echo "</div>";
}

function getAvatarPath($avatar){
	if(is_file(AVATAR_PATH.$avatar))
		return AVATAR_PATH.$avatar;
	else
		return DEFAULTS_PATH.DEFAULT_AVATAR;
}

function getSeriePath($serieImg){
	if(is_file(SERIE_PATH.$serieImg))
		return SERIE_PATH.$serieImg;
	else
		return DEFAULTS_PATH.DEFAULT_SERIE;
}

function getInCorsoValue($val){
	if($val == "true")
		return "In corso.";
	else
		return "Terminata.";
}

function getNomeFumetto($nome, $numero){
	if($nome == "")
		return "Volume $numero";
	else return $nome;
}

function getFumettoLittlePath($nome){
	if(is_file(FUMETTI_LITTLE_PATH.$nome))
		return FUMETTI_PATH.$nome;
	else
		return DEFAULTS_PATH.DEFAULT_FUMETTO;
}

function stampaBacheca(){
	
}

function printSeries(){
	$series = getSeries();
	if(mysql_num_rows($series) == 0)
		echo "Non ci sono serie. Ritorna tra un po'!";
	for ($j = 0; $j < mysql_num_rows($series); $j++){
			$serie = mysql_fetch_array($series);
			printSerie($serie["nome"]);
		}
}

function printSerie($IdSerie){
	require_once("DbConn.php");
	$serie = mysql_fetch_array(getSerie($IdSerie));
	if(!$serie)
		echo "Non esiste nessuna serie con questo nome: $IdSerie.";
	else
		printSerieInfo($serie);	
}

function printSerieDettagli($IdSerie){
	require_once("DbConn.php");
	$serie = mysql_fetch_array(getSerie($IdSerie));
	if(!$serie)
		echo "Non esiste nessuna serie con questo nome: $IdSerie.";
	else
		printSerieInfoDettagli($serie);	
}


function printSerieInfo($serie){
	require_once(SCRIPT_PATH."DbConn.php");
	echo "<div id=\"serieInfo\">";
	echo "<img src=\"".getSeriePath("Serie_".$serie["nome"].".jpg")."\" />";
	echo "<div id=\"nome\"><a href='serie.php?serie=".$serie['nome']."'>".$serie['nome']."</a></div>";
	echo "<div id=\"inCorso\">".getInCorsoValue($serie["inCorso"])."</div>";
	echo "<div id=\"elencoFumetti\">";
	//printElencoFumetti($serie["nome"]);
	$numFumetti = mysql_fetch_array(getSerieComicNum($serie["nome"]));
	if($numFumetti[0] == 0)
		echo "Non sono ancora stati inseriti fumetti per questa serie.";
	else
		echo $numFumetti[0]." volumi!";
	echo "</div></div>";
}

function printSerieInfoDettagli($serie){
	require_once(SCRIPT_PATH."DbConn.php");
	echo "<div id=\"serieInfo\">";
	echo "<img src=\"".getSeriePath("Serie_".$serie["nome"].".jpg")."\" />";
	echo "<div id=\"nomeSerie\">".$serie['nome']."</div>";
	echo "<div id=\"inCorso\">".getInCorsoValue($serie["inCorso"])."</div>";
	echo "<div id=\"elencoFumetti\">";
	printElencoFumetti($serie["nome"]);
	echo "</div></div>";
}

function printElencoFumetti($serie){
	require_once("DbConn.php");
	$fumetti = getFumetti($serie);//, 0 , LIST_FUMETTI_LIMIT);
	echo '<div id="fumettiInfo">';
	//if(mysql_num_rows($fumetti) == 0)
		//echo "Non esistono ancora fumetti per questa serie.";
	print mysql_num_rows($fumetti);
	for ($j = 0; $j < mysql_num_rows($fumetti); $j++){
			$fumetto = mysql_fetch_array($fumetti);
			printFumettoLittle($fumetto);
		}
	if($j == LIST_FUMETTI_LIMIT)
		echo "<a href=\"serie.php?".$serie["nome"].">Visualizza tutti</a>";
	echo '</div>';
}

function printFumettoLittle($fumetto){
	if($fumetto['dataUscita'] > time())
		return;
	echo '<div id="fumettoLittle">';
	echo "<img src=\"".FUMETTI_PATH."Fumetto_".$fumetto["idSerie"].$fumetto["volume"].".jpg"."\" />";
	//echo "Fumetto_".$fumetto["idSerie"].$fumetto["volume"].".jpg";
	echo '<div id="volume">'.$fumetto['volume'].'</div>';
	echo '<div id="nome">'.getNomeFumetto($fumetto['nome'], $fumetto['volume'])."</div>";
	echo '<div id="data">Uscito il: '.$fumetto['dataUscita'].'</div>';
	echo '<div id="comandiFumetto">'.printMenu("Controlli fumetti").'</div>';
	echo '</div>';
	
}

function printUtenti(){
	require_once("DbConn.php");
	$utenti = getUsers(0, 100);
	echo "<div id=\"elencoUtenti\">\n\t<table border=1>";
	?>
	<tr><th>Att.</th><th>Username</th><th>Nome</th><th>Cognome</th><th>e-Mail</th><th>Permessi</th><th>Ban</th><th>Elimina</th><th>Salva</th></tr>
	<?php
	for ($j = 0; $j < mysql_num_rows($utenti); $j++){
			$utente = mysql_fetch_array($utenti);
			if($utente["username"] == USER)
				continue;
			printRow($utente);
		}
	echo "</table></div>";
}

function printRow($utente){
	echo "<tr>";
	echo "<form method=post name=\"form".$utente["username"]."\" action=".$_SERVER['PHP_SELF'].">\n";
	echo "<input type=hidden name=user value='".$utente["username"]."' >";
	//Utente attivo?
	echo "<td><div id='active'><input type=\"checkbox\" name='activated' value=\"true\" ";
	if($utente["attivo"] == "true")
		echo " checked='checked' ";
	echo "/></div></td>";

	//Username
	echo "<td><div id='username'>".$utente["username"]."</div></td>\n";
	
	//Nome
	echo "<td><div id='nome'>".$utente["nome"]."</div></td>\n";
	
	//Cognome
	echo "<td><div id='cognome'>".$utente["cognome"]."</div></td>\n";
	
	//eMail
	echo "<td><div id='email'>".$utente["email"]."</div></td>\n";
	
	//Permessi
	if(PRIVILEGI == "administrator"){
		?> <td><div id="privilegi"><select name="privilegi">
				<option value="guest" <?php if($utente["privilegi"] == "guest") echo "selected"; ?>>Guest</option>
				<option value="manager" <?php if($utente["privilegi"] == "manager") echo "selected"; ?>>Manager</option>
				<option value="administrator" <?php if($utente["privilegi"] == "administrator") echo "selected"; ?>>Administrator</option>
				</select></td>
		<?php
		}
	else
		echo "<td><div id=\"permessi\">".$utente["privilegi"]."</td>";
	
	//Bannato?
	if(userIsBanned($utente["banned"])){
		//echo "<td><div id='isBanned'><img src=\"".BANNATO_IMG."\"></div></td>";
		echo "<td><div id='ban'>Ban:<select name=ban>\n\t<option value='";
		echo time()-1000;
		echo "'>Togli il ban</option>\n\t<option value=\"";
		echo $utente["banned"];
		echo "\" selected>Bannato</option></div></td>\n";

	}
	else{
		//echo "<td><div id='isBanned'><img src=\"".SBANNATO_IMG."\"></div></td>";
		echo "<td><div id='ban'>Ban:<select name=ban>\n\t<option></option>\n\t<option value=";
		echo (time() + (3 * 24 * 60 * 60));
		echo ">Un giorno</option>\n\t<option value=";
		echo (time() + (7 * 24 * 60 * 60));
		echo ">Una settimana</option>\n\t<option value=";
		echo (time() + (31 * 24 * 60 * 60));
		echo ">Un mese</option></div></td>\n";
	}
	echo "<td><a href=elimina_utente.php?utente=".$utente["username"].">Elimina</a></td>";
	echo "<td><input type='submit' value=Salva></td></form></tr>";
	//Nel caso si vogliano inserire altri campi, la chiusura del campo tr va fatta al di fuori di questa funzione
		
}

function getDataNumber($datas){
	$data = new DateTime($datas);
	return $data->getTimestamp();
}

function getTimeStamp($datas){
	try{
		$data = new DateTime("@$datas");
		$data = $data->format('Y-m-d H:i:s');
	}catch (exception $Exception){ $data = null; }
	return $data;
}

function modificaUtenti($vett){
	//print_r($vett);
	if(!isset($vett) || !isset($vett["user"]))
		return;
	if(!isset($vett["activated"]))
		$vett["activated"] = 'false';
	$vett['ban'] = getTimeStamp($vett['ban']);
	editUserState($vett);
}

/////////////////////////////////////////FUNZIONI VARIE

?>