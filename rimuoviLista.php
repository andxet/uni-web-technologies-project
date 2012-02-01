<?php
	require_once("script/config.php");
	require_once(SCRIPT_PATH."funzioni.php");
	inizializza();
	$fumetto = $_GET["fumetto"];
	
	$QUERY = "DELETE FROM  `fumezzi`.`Legge` WHERE  `Legge`.`utente` =  '".USER."' AND  `Legge`.`fumetto` ='$fumetto';";
	//echo $QUERY;
	if(eseguiQuery($QUERY))
		echo "successo";
	else
		echo $errori;
?>