<?php
	require_once("script/config.php");
	require_once(SCRIPT_PATH."funzioni.php");
	
	inizializza();
	if(!isset($_GET["fumetto"]))
		header("Location: list.php");
	eliminaFumetto($_GET["fumetto"]);
	header("Location: list.php");
?>