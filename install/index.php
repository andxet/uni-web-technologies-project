<?php
	require_once("../script/config.php");
	require_once("../script/funzioni.php");	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >
   		<!-- <link rel="stylesheet" type="text/css" href="../css/style_layout.css" > -->
   		<title>Installazione di <?php echo SITE_NAME; ?></title>
    </head>
<body>	

    <div id="container">
  	<h1>Procedura di installazione di <?php echo SITE_NAME; ?></h1>
  	<p>Inserire i dati per la connessione al database. Il database verr&agrave; popolato con il file "db.sql". I dati di esempio sono contenuti nel file "dati.sql" e servono per dare un idea delle funzionalit&agrave; del sito.</p>
  	<form action="install.php" method="post" name="installForm">
  	<fieldset>
  	<legend>Dati connessione</legend>
  		host: <input type="textfield" name="host" value="localhost"><br />
  		username: <input type="textfield" name="username" value="root" /><br/>
  		password: <input type="password" name="pass" /><br/>
  		database: <input type="textfield" name="dbName" value="fumeZZi"/><input type="checkbox" name="crea" value="si" checked="checked" />Il database non esiste e deve essere creato<br/>
  		<input type=submit value="Installa!" />
  	</fieldset>
  	</form>
  	
            
  	<div id="footer">
       <?php printFooter(); ?>
    </div>      
    	
    </div>
</body>
</html> 