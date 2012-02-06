<?php
	if(!isset($_POST["username"]) || $_POST["username"]=="" || $_POST["pass"]=="" || $_POST["host"]=="" || $_POST["dbName"]=="")
		header("Location: index.php");
	$user=$_POST["username"];
	$pass=$_POST["pass"];
	$host=$_POST["host"];
	$dab=$_POST["dbName"];
	
	//$file = fopen("../config/dbconf.php", "w");
	$file = fopen("../script/dbconf.php", "w")
		or die ("Non posso creare il file, controlla i permessi!");
	fwrite($file, "<?php\n//Configurazioni per il server:\n");
	fwrite($file, "define('DB_USER', '$user');\n");
	fwrite($file, "define('DB_PASS', '$pass');\n");
	fwrite($file, "define('DB_HOST', '$host');\n");
	fwrite($file, "define('DB_NAME', '$dab');\n");
	fwrite($file, "?>");
	fclose($file);
		
	//require_once("../script/config.php");
	
	$database = mysql_connect($host, $user, $pass)
		or die("Connessione non riuscita: " . mysql_error());
	if($_POST["crea"] == "si"){
		//	mysql_create_db(DB_NAME);
		$crea_db = "CREATE DATABASE `$dab`";
		//echo $crea_db;
		if(mysql_select_db($dab, $database))
			die ("Il database esiste gi&agrave;!");
		mysql_query($crea_db)
			or die("Creazione del database non riuscita");
		}
		
    mysql_select_db($dab, $database)
    	or die ("Selezione del database non riuscita: " . mysql_error());
	
	$templine = '';
	// Read in entire file
	$lines = file("db.sql");
	// Loop through each line
	foreach ($lines as $line)
	{
    	// Skip it if it's a comment
    	if (substr($line, 0, 2) == '--' || $line == '')
        	continue;
 
    	// Add this line to the current segment
    	$templine .= $line;
    	// If it has a semicolon at the end, it's the end of the query
    	if (substr(trim($line), -1, 1) == ';')
    		{
        	// Perform the query
        	mysql_query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
        	// Reset temp variable to empty
        	$templine = '';
    	}
	}

	
	mysql_close($database);
 
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >
   		<link rel="stylesheet" type="text/css" href="../css/style_layout.css" >
   		<title>Installazione di <?php echo SITE_NAME; ?></title>
    </head>
	<body>

	
		<h1>Installazione riuscita!</h1>
		<p>Vai immediatamente alla <a href="../index.php">home page</a>!</p>
	</body>
</html>