<?php
	require_once("script/config.php");
	require_once(SCRIPT_PATH."funzioni.php");
	inizializza();
	$fumetto = $_GET["fumetto"];
	
	$QUERY = "INSERT INTO  `fumezzi`.`Legge` (`utente` ,`fumetto` ,`letto`) VALUES ('".USER."',  '$fumetto',  'no');";
	//echo $QUERY;
	if($errori = eseguiQuery($QUERY))
		echo "successo";
	else
		echo $errori;
?>