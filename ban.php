<?php
	require_once("script/config.php");
	require_once(SCRIPT_PATH."funzioni.php");
	//require_once(SCRIPT_PATH."registrazione.php");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
   		<?php printHead(); ?>
   </head>
<body>
    <div id="container">
    	<div id="welcomeTitle">
    		<h1>Utente bannato!</h1>
    	</div>
    	<div id="siteDescription">
    		L'accesso di questo account &egrave; stato bloccato per motivi disciplinari. Contatta un moderatore se desideri fare ricorso.
    	</div>
   		<div id="footer">
       		<?php printFooter(); ?>
    	</div>
    </div>      
</div>
</body>
</html> 