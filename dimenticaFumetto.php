<?php
	require_once("script/config.php");
	require_once(SCRIPT_PATH."funzioni.php");
	inizializza();
	$fumetto = $_GET["fumetto"];
	$utente = USER;
	
	$QUERY = "UPDATE  `fumezzi`.`Legge` SET  `letto` =  'no', `dataLettura` = NULL WHERE  `Legge`.`utente` =  '$utente' AND  `Legge`.`fumetto` = '$fumetto';";
	//echo $QUERY;
	if($errori = eseguiQuery($QUERY))
		echo "successo";
	else
		echo $errori;
?>