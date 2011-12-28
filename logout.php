<?php
	require_once("script/config.php");
	require_once(SCRIPT_PATH."funzioni.php");
	session_start();
	if(userIsLogged())
		logout();
	header("Location: ".WELCOME_PAGE);
?>