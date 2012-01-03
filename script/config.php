<?php
	define('SERVER_FORM_CONTROL', true);//True se il server deve sempre effettuare il controllo dei form
	define('SITE_NAME', "FumeZZi");
	define('ATTIVAZIONE_UTENTE_DEFAULT', true);
	define('RICOMPILA_CAMPO_PASSWORD', false);
	//Configurazioni per il server:
	define('DB_USER', 'root');
	define('DB_PASS', 'root');
	define('DB_HOST', 'localhost');
	define('DB_NAME', 'fumezzi');
	//Configurazioni dei path
	define('SCRIPT_PATH', 'script/');
	define('CSS_PATH', 'css/');
	define('IMAGES_PATH', 'images/');
	define('MINIATURE_PATH', IMAGES_PATH.'mini/');
	define('AVATAR_PATH', IMAGES_PATH.'avatar/');
	define('DEFAULT_AVATAR', 'default.jpg');
	//Configurazione delle pagine di default
	define('LOGIN_PAGE', 'login.php');
	define('WELCOME_PAGE', 'login.php');
	define('REGISTRATION_PAGE', 'registrazione.php');
	define('HOME_PAGE', 'index.php');
	define('PROFILE_PAGE', 'profilo.php');
	//Comfigurazioni per i form
	define('MIN_LUNGHEZZA_CAMPO', 1);
	//Altro
	$errori = "";
?>