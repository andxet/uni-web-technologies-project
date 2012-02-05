<?php
	//if(!file_exists("dbconf.php"))
	//	header("Location: ../install/index.php");
	
	//Confugurazione per il fuso orario dei computer dell'uni
	
	
	include_once("dbconf.php");
	define('ADMINISTRATOR', "administrator");
	define('MESSAGGI_MAIL', "messaggi@fumezzi.zz");
	define('SERVER_FORM_CONTROL', true);//True se il server deve sempre effettuare il controllo dei form
	define('SITE_NAME', "FumeZZi");
	define('ATTIVAZIONE_UTENTE_DEFAULT', "false"); //Settare una stringa, "true" o "false"
	define('RICOMPILA_CAMPO_PASSWORD', false);
	define('LOGO_NAME', "logo.png");
	define('SITE_ICON', "icon.png");
	define('SAVE_UPLOAD_ORIGINALS', true);
	//define('NUMBER_SERIES_PER_PAGE', 30);
	//define('LIST_FUMETTI_LIMIT', 30);
	//Configurazioni dei path
	define('SCRIPT_PATH', 'script/');
	define('CSS_PATH', 'css/');
	define('IMAGES_PATH', 'images/');
	define('MINIATURE_PATH', IMAGES_PATH.'mini/');
	define('AVATAR_PATH', IMAGES_PATH.'avatar/');
	define('SERIE_PATH', IMAGES_PATH.'serie/');
	define('FUMETTI_PATH', IMAGES_PATH.'fumetti/');
	define('FUMETTI_LITTLE_PATH', IMAGES_PATH.'fumettiLittle/');	
	define('DEFAULT_AVATAR', 'avatar.jpg');
	define('DEFAULT_SERIE', 'serie.jpg');
	define('DEFAULT_FUMETTO', 'fumetto.jpg');
	define('DEFAULTS_PATH', IMAGES_PATH.'defaults/');
	define('ORIGINAL_PATH', IMAGES_PATH.'originali/');
	//IMMAGINI VARIE
	define('BANNATO_IMG', DEFAULTS_PATH.'bannato.jpg');
	define('SBANNATO_IMG', DEFAULTS_PATH.'sbannato.jpg');
	define('ATTIVATO_IMG', DEFAULTS_PATH.'attivato.jpg');
	define('DISATTIVATO_IMG', DEFAULTS_PATH.'disattivato.jpg');
	define('ADD_IMG', DEFAULTS_PATH."add.png");
	define('ADDB_IMG', DEFAULTS_PATH."addb.png");
	define('EDIT_IMG', DEFAULTS_PATH."edit.png");
	define('BAFFO_IMG', DEFAULTS_PATH."baffo.png");
	define('ANNULLA_IMG', DEFAULTS_PATH."annulla.png");
	define('MESS_IMG', DEFAULTS_PATH."messaggio.png");
	define('CESTINO_IMG', DEFAULTS_PATH."bin.png");
	//Configurazione delle pagine di default
	define('LOGIN_PAGE', 'login.php');
	define('WELCOME_PAGE', 'login.php');
	define('REGISTRATION_PAGE', 'registrazione.php');
	define('HOME_PAGE', 'index.php');
	define('PROFILE_PAGE', 'profilo.php');
	define('BAN_PAGE', 'ban.php');
	define('ACTIVE_PAGE', 'attiva.php');
	//Configurazioni immagini
	$formati_immagine = array(".jpg", ".gif", ".png");
	$tipi_immagine = array("image/jpeg", "image/gif", "image/png");
	$estensioni_immagini = array("image/jpeg" => ".jpg", "image/gif" => ".gif", "image/png" => ".png");
	//Comfigurazioni per i form
	define('MIN_LUNGHEZZA_CAMPO', 1);
	//Altro
	$errori = "";
	
	//Dimensioni immagine serie: 708 * 180 = h 4 volte la l
	
?>