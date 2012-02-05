<?php
	require_once("script/config.php");
	require_once(SCRIPT_PATH."funzioni.php");
	inizializza();
	$amico = $_GET["amico"];
	$user = USER;
	if($amico == $user)
		return "Non puoi chiedere l'amicizia a te stesso!";
	
	$QUERY = "INSERT INTO  `Richieste` (`richiedente` ,`amico` ,`data`) VALUES ('$user',  '$amico', NOW( ));";
	if($errori = eseguiQuery($QUERY))
		echo "successo";
	else
		echo $errori;
?>