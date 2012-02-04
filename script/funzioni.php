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


//Funzioni per disegnare la pagina
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
	echo "<a href=\"index.php\"><img src=\"".IMAGES_PATH.LOGO_NAME."\" height=\"100px\" alt=\"".SITE_NAME."\"></a>";
	echo "<div id=\"avvisoJS\"><noscript>Javascript deve essere abilitato per un corretto funzionamento del sito.</noscript></div>";
}

function printFooter(){
	echo "<p>Realizzato da <a href=\"mailto:andrea.peretti@studenti.unito.it\">Andrea Peretti</a> - 2012</p>";
}

function printMenu($nome){
	require_once('DbConn.php');
	require_once('config.php');
	$menus = getMenu($nome);
	$menus = mysql_fetch_array($menus);
	if($menus["count(*)"] == 0)
		return;
	echo "<div id=\"".$menus["nomeStile"]."\">";
	$pagine = getPages($nome);
	for ($j = 0; $j < mysql_num_rows($pagine); $j++){
		$pagina = mysql_fetch_array($pagine);
		if(!in_array(PRIVILEGI, explode(",", $pagina["permessi"])))
			continue;
		if(file_exists($pagina['link'])){
			//if($j!=0) echo "|";
			echo "<div id=\"comando\"><a href=\"".$pagina['link']."\">";
			if(function_exists($pagina["nome"]))
				echo call_user_func($pagina["nome"]);
			else
				echo $pagina['nome'];
			echo "</a></div>";
			}
	}
	echo "</div>";
}


//Funzioni
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
	echo "<div id=\"comando\"><a href=\"impostazioni.php\">".USER."</a></div>";
}

function getRichiesteAmici(){
	return getRiechiesteAmiciDi(USER);
}

function getRiechiesteAmiciDi($user){
	require_once("DbConn.php");
	$numRichieste = mysql_num_rows(getRichiesteAmicizia($user));
	$ret = "<div id=\"comando\"><a href=\"amici.php\">Amici</a>";
		if($numRichieste > 0)
			$ret .= "&nbsp<div id=\"notifiche\">&nbsp;".$numRichieste."&nbsp;</div>";
	$ret .= "</div>";
	return $ret;
	
}

function getAmici(){
	return getAmiciDb(USER);
}

function nuovaSerieButton(){
	echo "<a href=aggiungiSerie.php><img src='".ADD_IMG."' />Nuova serie</a>";
}

function nuovoFumettoButton(){
	$serie = $_GET["serie"];
	//echo $serie;
	echo "<a href=\"aggiungiFumetto.php?serie=".$serie."\"><img src='".ADD_IMG."' />Nuovo fumetto</a>";
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
	$_SESSION = array();
	
	if (ini_get("session.use_cookies")) {
	$params = session_get_cookie_params(); 
	setcookie(session_name(), '', time() - 42000,
		$params["path"], $params["domain"],
		$params["secure"], $params["httponly"] );
	}
	session_destroy();

}

/*function userInfo($user){
	require_once(SCRIPT_PATH."DbConn.php");
	$userInfo = getUserInfo($user);
	echo "<div id=\"userInfo\">";
	echo "<img src=\"".getAvatarPath($userInfo['username'])."\" />";
	echo "<div id=\"username\">".$userInfo['username']."</div>";
	echo "<div id=\"nome\">".$userInfo['nome']."</div>  ";
	echo "<div id=\"cognome\">&nbsp;".$userInfo['cognome']."</div>";
	echo "<div id=\"luogo\">".$userInfo['luogo']."</div>";
	echo "<div id=\"numeroFumetti\">".numFumettiPosseduti(USER)." fumetti</div>";
	echo "</div>";
}*/

//Funzioni per la stampa di valori
function getAvatarPath($avatar){
	if(is_file(AVATAR_PATH."Avatar_".$avatar.".jpg"))
		return AVATAR_PATH."Avatar_".$avatar.".jpg";
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

function getFumettoPath($nome){
	if(is_file(FUMETTI_PATH.$nome))
		return FUMETTI_PATH.$nome;
	else
		return DEFAULTS_PATH.DEFAULT_FUMETTO;
}

//Funzioni di stampa di tipi di oggetti
function stampaBacheca(){
	
}

function printSeries(){
	$series = getSeries();
	if(mysql_num_rows($series) == 0)
		echo "Non ci sono serie. Ritorna tra un po'!";
	for ($j = 0; $j < mysql_num_rows($series); $j++){
			$serie = mysql_fetch_array($series);
			printSerieInfo($serie);
		}
}

function printSerie($serie){
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
	echo "<a href='serie.php?serie=".$serie['idSerie']."'><img src=\"".getSeriePath("Serie_".$serie["idSerie"].".jpg")."\" />";
	echo "<div id=\"nomeSerie\">".$serie['nome']."</a></div>";
	echo "<div id=\"inCorso\">".getInCorsoValue($serie["inCorso"])."</div>";
	echo "<div id=\"elencoFumetti\">";
	//printElencoFumetti($serie["nome"]);
	$numFumetti = getSerieComicNum($serie["idSerie"]);
	if($numFumetti == 0)
		echo "Non sono ancora stati inseriti fumetti per questa serie.";
	else
		echo $numFumetti." volumi!";
	echo "</div></div>";
}

function printSerieInfoDettagli($serie){
	require_once(SCRIPT_PATH."DbConn.php");
	echo "<div id=\"serieInfo\">";
	echo "<img src=\"".getSeriePath("Serie_".$serie["idSerie"].".jpg")."\" />";
	//echo "<div id=\"nomeSerie\">".$serie['nome']."</div>";
	//echo "<div id=\"inCorso\">".getInCorsoValue($serie["inCorso"])."</div>";
	echo "</div>";
	echo "<div id=\"elencoFumetti\">";
	printElencoFumetti($serie["idSerie"]);
	echo "</div>";
}

function printElencoFumetti($serie){
	require_once("DbConn.php");
	$fumetti = getFumetti($serie);//, 0 , LIST_FUMETTI_LIMIT);
	echo '<div id="fumettiInfo">';
	//if(mysql_num_rows($fumetti) == 0)
		//echo "Non esistono ancora fumetti per questa serie.";
	//print mysql_num_rows($fumetti);
	for ($j = 0; $j < mysql_num_rows($fumetti); $j++){
			$fumetto = mysql_fetch_array($fumetti);
			printFumetto($fumetto);
		}
	//if($j == LIST_FUMETTI_LIMIT)
	//	echo "<a href=\"serie.php?".$serie["nome"].">Visualizza tutti</a>";
	echo '</div>';
}

function printFumetto($fumetto){
	if($fumetto['dataUscita'] > time())
		return;
	echo '<div id="fumetto">';
	echo "<img src=\"".FUMETTI_PATH."Fumetto_".$fumetto["idSerie"]."_".$fumetto["volume"].".jpg"."\" />";
	//echo "Fumetto_".$fumetto["idSerie"].$fumetto["volume"].".jpg";
	echo '<div id="volume">'.$fumetto['volume'].'</div>';
	echo '<div id="nome">'.getNomeFumetto($fumetto['nomeFum'], $fumetto['volume'])."</div>";
	echo '<div id="data">Uscito il: '.$fumetto['dataUscita'].'</div>';
	bottoneLista($fumetto);
	echo printMenu("Controlli fumetto");
	echo '</div>';
	
}

function printUtenti(){
	require_once("DbConn.php");
	$utenti = getUsers(0, 100);
	echo "<div id=\"elencoUtenti\">\n\t<table >";
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
		echo "<td><div id='ban'><select name=ban>\n\t<option value='";
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


//Date
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

//Funzioni per la pagina serie.php
function bottoneLista($fumetto){
	//print_r($fumetto["idSerie"]);
	global $fumettiPosseduti;
	if(!isset($fumettiPosseduti))
		$fumettiPosseduti = getFumettiPosseduti($fumetto["idSerie"]);
	//print_r($fumettiPosseduti);
	if($fumettiPosseduti && in_array($fumetto["idVolume"], $fumettiPosseduti))
		bottoneRimuoviLista($fumetto["idVolume"]);
	else
		bottoneAggiungiLista($fumetto["idVolume"]);
}

function bottoneRimuoviLista($fumetto){?>
	<div id="comandiFumetto">
		<img src="<?php echo BAFFO_IMG; ?>" alt="Rimuovi dalla lista dei fumetti che stai leggendo" onclick=rimuoviLista(<?php echo $fumetto; ?>,this); onmouseover=this.src='<?php echo ANNULLA_IMG; ?>' onmouseout=this.src='<?php echo BAFFO_IMG; ?>' />
	</div>
	<?php
}

function bottoneAggiungiLista($fumetto){?>
	<div id="comandiFumetto">
		<img src="<?php echo ADDB_IMG; ?>" alt="Aggiungi alla lista dei fumetti che stai leggendo!" onclick=aggiungiLista(<?php echo $fumetto; ?>,this); />
	</div>
	<?php
}

function bottoneUtente($utente){
	//print_r($fumetto["idSerie"]);
	global $amici;
	if(!isset($amici))
		$amici = getRichieste(USER);
	if(in_array($utente, $amici))
		bottoneRimuoviAmico($utente);
	else
		bottoneAggiungiAmico($utente);
}

function bottoneUtenteNascondi($utente){?>
	<div id="comandiAmico">
		<a href="scrivi.php?destinatario=<?php echo $utente; ?>"><img src="<?php echo MESS_IMG; ?>" alt="Invia messaggio"></a>
		<img src="<?php echo BAFFO_IMG; ?>" alt="Rimuovi dagli amici" onclick="rimuoviAmicoR('<?php echo $utente; ?>',this);" onmouseover="this.src='<?php echo ANNULLA_IMG; ?>'" onmouseout="this.src='<?php echo BAFFO_IMG; ?>'" />
	</div>
	<?php
}


function bottoneRimuoviAmico($utente){?>
	<div id="comandiAmico">
	<?php if(isAmico(USER, $utente)) echo "<a href='scrivi.php?destinatario=$utente'><img src='".MESS_IMG."' alt='Invia messaggio'></a>"; ?>
		<img src="<?php echo BAFFO_IMG; ?>" alt="Rimuovi dagli amici" onclick="rimuoviAmico('<?php echo $utente; ?>',this);" onmouseover="this.src='<?php echo ANNULLA_IMG; ?>'" onmouseout="this.src='<?php echo BAFFO_IMG; ?>'" />
	</div>
	<?php
}

function bottoneRichiestaAmico($utente){?>
	<div id="comandiAmico">
		<img src="<?php echo ANNULLA_IMG; ?>" alt="Rifiuta amico" onclick="rimuoviAmicoR('<?php echo $utente; ?>',this);" />
		<img src="<?php echo BAFFO_IMG; ?>" alt="Aggiungi agli amici!" onclick="aggiungiAmicoR('<?php echo $utente; ?>',this);" />
	</div>
	<?php
}

function bottoneAggiungiAmico($utente){?>
	<div id="comandiAmico">
		<img src="<?php echo ADDB_IMG; ?>" alt="Aggiungi agli amici!" onclick="aggiungiAmico('<?php echo $utente; ?>',this);" />
	</div>
	<?php
}

function bottoneConfermaAmico($utente){?>
	<div id="comandiAmico">
		<img src="<?php echo BAFFO_IMG; ?>" alt="Aggiungi agli amici!" onclick="aggiungiAmicoR('<?php echo $utente; ?>',this);" />
	</div>
	<?php
}

//Funzioni per la pagina lista.php
function printLista($user){
	$fumetti = getListaFumetti($user);
	if(mysql_num_rows($fumetti) == 0)
		if($user == USER)
			echo "Non hai fumetti! Aggiungine <a href=\"list.php\">qua!</a>";
		else
			echo "Nessun fumetto.";
	for ($j = 0; $j < mysql_num_rows($fumetti); $j++){
			$fumetto = mysql_fetch_array($fumetti);
			if($user == USER)
				printFumettoL($fumetto);
			else
				printFumettoDiAltri($fumetto);
		}
}

function rimuoviLista($fumetto){?>
	<div id="comandiFumetto">
		<img src="<?php echo ANNULLA_IMG; ?>" alt="Rimuovi dalla lista dei fumetti che stai leggendo" onclick=rimuoviListaR(<?php echo $fumetto; ?>,this); />
	</div>
	<?php
}

function printFumettoL($fumetto){
	if($fumetto["letto"] == "si"){
		echo '<div id="fumettoLetto" >';
		echo '<img src="'.FUMETTI_PATH.'Fumetto_'.$fumetto["idSerie"].'_'.$fumetto["volume"].'.jpg" onclick="dimenticaLettura(this, '.$fumetto["idVolume"].')"/>';
		}
	else{
		echo '<div id="fumetto" >';
		echo '<img src="'.FUMETTI_PATH.'Fumetto_'.$fumetto["idSerie"].'_'.$fumetto["volume"].'.jpg" onclick="leggi(this, '.$fumetto["idVolume"].')"/>';
		}
	//echo "Fumetto_".$fumetto["idSerie"].$fumetto["volume"].".jpg";
	echo '<div id="volume">'.$fumetto['volume'].'</div>';
	echo '<div id="nome">'.getNomeFumetto($fumetto['nomeFum'], $fumetto['volume'])."</div>";
	echo '<div id="data">Uscito il: '.$fumetto['dataUscita'].'</div>';
	rimuoviLista($fumetto["idVolume"]);
	echo printMenu("Controlli fumetto");
	echo '</div>';
	
}

function printFumettoDiAltri($fumetto){
	if($fumetto["letto"] == "si"){
		echo '<div id="fumettoLetto" >';
		echo '<img src="'.FUMETTI_PATH.'Fumetto_'.$fumetto["idSerie"].'_'.$fumetto["volume"].'.jpg" "/>';
		}
	else{
		echo '<div id="fumetto" >';
		echo '<img src="'.FUMETTI_PATH.'Fumetto_'.$fumetto["idSerie"].'_'.$fumetto["volume"].'.jpg" "/>';
		}
	//echo "Fumetto_".$fumetto["idSerie"].$fumetto["volume"].".jpg";
	echo '<div id="volume">'.$fumetto['volume'].'</div>';
	echo '<div id="nome">'.getNomeFumetto($fumetto['nomeFum'], $fumetto['volume'])."</div>";
	echo '<div id="data">Uscito il: '.$fumetto['dataUscita'].'</div>';
	//rimuoviLista($fumetto["idVolume"]);
	echo printMenu("Controlli fumetto");
	echo '</div>';
	
}

//Funzioni per la pagina cerca.php
function stampaRisultati(){
	global $risultati;
	if(!isset($risultati["fumetti"]) && !isset($risultati["serie"]) && !isset($risultati["utenti"])){
		echo "Errorre nei risultati.";
		return;
	}
	
	$amici;
	
	switch($_POST["cosa"]){
		case "tutto":
			$fumetti = $risultati["fumetti"];
			$serie = $risultati["serie"];
			$utenti = $risultati["utenti"];
			risultatiFumetti($fumetti);
			risultatiSerie($serie);
			risultatiUtenti($utenti);
			break;
		case "fumetti":
			$fumetti = $risultati["fumetti"];
			if(mysql_num_rows($fumetti) == 0){
				echo "<p>Nessun risultato trovato.</p>";
				break;}
			?>
			<div id="risultati">
			<?php
				for($j = 0; $j < mysql_num_rows($fumetti); $j++){
					$s = mysql_fetch_array($fumetti);
					printFumetto($s);
					}
			?>
			</div><?php
			break;
		case "serie":
			$serie = $risultati["serie"];
			if(mysql_num_rows($serie) == 0){
			echo "<p>Nessun risultato trovato.</p>";
				break;}
			?>
			<div id="risultati">
			<?php
				for($j = 0; $j < mysql_num_rows($serie); $j++){
					$s = mysql_fetch_array($serie);
					printSerieInfo($s);
					}
			?>
			</div><?php
			break;
		case "utenti":
			$utenti = $risultati["utenti"];
			if(mysql_num_rows($utenti) == 0){
				echo "<p>Nessun risultato trovato.</p>";
				break;}
			?>
			<div id="risultati">
			<?php
				for($j = 0; $j < mysql_num_rows($utenti); $j++){
					$s = mysql_fetch_array($utenti);
					printUserInfo($s, "bottoneUtente");
					}
			?>
			</div><?php
			break;
		}	
}

function risultatiSerie($serie){
	if(mysql_num_rows($serie) == 0)
		return;
	?>
	<div id="risultati"><div id="intRisultati" onclick="mostraMenu(this.parentNode);"><img src="images/frecciad.png" />Serie <div id="notifiche">&nbsp;<?php echo mysql_num_rows($serie); ?>&nbsp;</div>
	</div>
		<div id="risultatiElenco">
		<?php
			for($j = 0; $j < mysql_num_rows($serie); $j++){
				$s = mysql_fetch_array($serie);
				printSerieInfo($s);
				}
		?>
		</div>
	</div>
	<?php
}

function risultatiFumetti($fumetti){
if(mysql_num_rows($fumetti) == 0)
		return;
	?>
	<div id="risultati"><div id="intRisultati" onclick="mostraMenu(this.parentNode);"><img src="images/frecciad.png" />Fumetti <div id="notifiche">&nbsp;<?php echo mysql_num_rows($fumetti); ?>&nbsp;</div>
	</div>
	<div id="risultatiElenco">
		<?php
			for($j = 0; $j < mysql_num_rows($fumetti); $j++){
				$s = mysql_fetch_array($fumetti);
				printFumetto($s);
				}
		?>
		</div>
	</div>
	<?php
}

function risultatiUtenti($utenti){
if(mysql_num_rows($utenti) == 0)
		return;
	?>
	<div id="risultati"><div id="intRisultati" onclick="mostraMenu(this.parentNode);"><img src="images/frecciad.png" />Utenti <div id="notifiche">&nbsp;<?php echo mysql_num_rows($utenti); ?>&nbsp;</div>
	</div>
		<div id="risultatiElenco">
		<?php
			for($j = 0; $j < mysql_num_rows($utenti); $j++){
				$s = mysql_fetch_array($utenti);
				printUserInfo($s, "bottoneUtente");
				}
		?>
		</div>
	</div>
	<?php
}

//Funzioni per la stampa di utenti

function printUserInfo($userInfo, $funzioneBottone){
	require_once(SCRIPT_PATH."DbConn.php");
	echo "<div id=\"userInfo\">";
	echo "<img src=\"".getAvatarPath($userInfo['username'])."\" />";
	if(function_exists($funzioneBottone))
		call_user_func($funzioneBottone, $userInfo['username']);
	echo "<div id=\"username\"><a href=\"profilo.php?utente=".$userInfo['username']."\">".$userInfo['username']."</a></div id=\"datiUtente\">";
	echo "<div id=\"nome\">".$userInfo['nome']."</div>  ";
	echo "<div id=\"cognome\">&nbsp;".$userInfo['cognome']."</div>";
	echo "<div id=\"luogo\">".$userInfo['luogo']."</div>";
	echo "<div id=\"numeroFumetti\">".numFumettiPosseduti($userInfo["username"])." fumetti</div>";
	echo "</div>";
}

function printRichiesteAmicizia(){
	$richieste = getRichiesteAmicizia(USER);
	if(mysql_num_rows($richieste) == 0)
		return;
	?>
	<div id="risultati"><div id="intRisultati" onclick="mostraMenu(this.parentNode);"><img src="images/frecciad.png" />Richieste di amicizia <div id="notifiche">&nbsp;<?php echo mysql_num_rows($richieste); ?>&nbsp;</div>
	</div>
	<div id="risultatiElenco">
		<?php
			for($j = 0; $j < mysql_num_rows($richieste); $j++){
				$s = mysql_fetch_array($richieste);
				printUserInfo($s, "bottoneRichiestaAmico");
				}
		?>
		</div>
	</div>
	<?php
}
        	
function printAmici(){
	$amici = getAmiciDb(USER);
	if(mysql_num_rows($amici) == 0)
		return;
	?>
	<div id="amici">
		<?php
			for($j = 0; $j < mysql_num_rows($amici); $j++){
				$s = mysql_fetch_array($amici);
				printUserInfo($s, "bottoneUtenteNascondi");
				}
		?>
	</div>
	<?php
}

function inviaMail($v){
	$destinatario = getUserInfo($v["destinatario"]);
	$mailD = $destinatario["email"];
	$utente = getUserInfo(USER);
	$mailU = $utente["email"];
	$messaggio = "<p>Ricevi questo messaggio perch&egrave; sei registrato a ".SITE_NAME.". L'utente <a href='mailto:$mailU'>".USER."</a>Ti ha inviato il seguente messaggio:</p>\n<p>".$v["messaggio"]."</p>";
	$oggetto = $v["oggetto"];
	//echo $messaggio;
	if(mail($mailD, $oggetto, $messaggio))
		return true;
	else
		return false;
}

?>