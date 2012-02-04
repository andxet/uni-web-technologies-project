<?php
	require_once("script/config.php");
	require_once(SCRIPT_PATH."funzioni.php");
	$errori;
	login_script();
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
    	<h1>Tieni traccia dei tuoi fumetti!</h1>
    </div>
    <div id="siteDescription">
        Con <?php echo SITE_NAME; ?> potrai tenere un inventario dei tuoi fumetti, registrare quelli che hai gi&agrave; letto e trovare persone che possiedono quelli che ti mancano!<br />
     	Che aspetti? <a href="<?php echo REGISTRATION_PAGE ?>"> Registrati! </a> oppure effettua l'accesso
    </div>
   	<div id="login">
   		<h1>Login:</h1>
   		<div id="errori">
        	<?php echo $errori; ?>
       	</div>
   		<form action="<?php echo LOGIN_PAGE; ?>" method="post">
   		<fieldset>
   			Username: <input type="text" name="username"/><br/>
   			Password: <input type="password" name="password"/><br/>
   			<input type="submit" value="Entra!"/><br>
   		</fieldset>
   		</form>
   	</div>
  	<div id="footer">
       		<?php printFooter(); ?>
    </div>      
</div>
</body>
</html> 