<?php
	require_once("script/config.php");
	require_once(SCRIPT_PATH."funzioni.php");
	inizializza();
	$amico = $_GET["amico"];
	$user = USER;
	if($amico == $user)
		return "Errore improbabile :-S";
	
	$QUERY1 = "DELETE FROM  `Richieste` WHERE `Richiedente` = '$user' AND `Amico` = '$amico';";
	$QUERY2 = "DELETE FROM  `Richieste` WHERE `Richiedente` = '$amico' AND `Amico` = '$user';";
	if($errori = (eseguiQuery($QUERY1) && eseguiQuery($QUERY2)))
		echo "successo";
	else
		echo $errori;
?>