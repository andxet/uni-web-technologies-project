<?php
	require_once("script/config.php");
	require_once(SCRIPT_PATH."funzioni.php");
	
	inizializza();
	if(!isset($_GET["serie"]))
		header("Location: list.php");
	eliminaSerie($_GET["serie"]);
	header("Location: list.php");
?>