<?php
	require_once("script/config.php");
	require_once(SCRIPT_PATH."funzioni.php");
	require_once(SCRIPT_PATH."DbConn.php");
	inizializza();
	if(!isset($_GET["utente"]))
		header("Location: utenti.php");
	$utente = $_GET["utente"];
	eliminaUtente($utente);
	header("Location: utenti.php?avvisi='Eliminazione avvenuta'");
?>