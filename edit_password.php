<?php
	require_once("script/config.php");
	require_once(SCRIPT_PATH."funzioni.php");
	require_once(SCRIPT_PATH."form.php");
	inizializza();
	global $errori;
	if($_POST)
		if(isset($_POST["jsIsEnabled"]) && checkEditPassword($_POST)){
			require_once(SCRIPT_PATH."DbConn.php");
			if(modificaPassword($_POST))
				header("Location: ".HOME_PAGE);
			else die("Errore imprevisto nella modifica della password.");
		}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
   		<?php printHead();
   		echo "<script src=\"".SCRIPT_PATH."form.js\" type=\"text/javascript\"></script>"; ?>
    </head>
<body>	

    <div id="container">
    
    	<div id="header">
    		<?php 
    		printHeader(); 
    	echo "</div>";
    		printMenu("user_control");

            printMenu("navigation");
            ?>  
        
        <div id="content">
        	<div id="errori">
        		<?php global $errori; echo $errori; ?>
        	</div>
        	 <form method="post" name="modulo" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="modulo">
        	 	<fieldset>
        	 		<legend>Vecchia password</legend>
        	 		<input type="password" name="passold">
        	 		<input type="hidden" name="jsIsEnabled" value="NO">
        	 	</fieldset>
        	 	<fieldset>
        	 		<legend>Nuova password</legend>
        	 		<input type="password" name="pass1">
        	 		<input type="password" name="pass2">
        	 	</fieldset>
        	 	<script type="text/javascript">
				<!--
					document.write('<button type="button" name="subscribe" onclick="checkModificaPassword();">Modifica password</button>');
				//  -->
				</script>
				<noscript>
					<input type="submit" name="subscribe" value="Modifica password">
				</noscript>
        	 </form>
        	       
        </div>
        
  		<div id="footer">
       		<?php printFooter(); ?>
        </div>      
    	
    </div>
</body>
</html> 