<?php
	require_once("script/config.php");
	require_once(SCRIPT_PATH."funzioni.php");
	inizializza();
	require_once(SCRIPT_PATH."form.php");
	if($_POST)
		if(isset($_POST["jsIsEnabled"]) && checkEditProfile($_POST)){
			require_once(SCRIPT_PATH."DbConn.php");
			if(modificaUtente($_POST))
				header("Location: ".HOME_PAGE);
			else die("Errore imprevisto nella modifica dei dati.");
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
        	<?php
        		$info = getUserInfo(USER);
        	?>
            <h1>Dati utente <?php echo USER; ?></h1>
            <button type="button"><a href="edit_password.php">Modifica la password</a></button><br/>
            <?php echo $info["email"] ?><button type="button"><a href="edit_mail.php">Modifica l'eMail</a></button><br/>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="modulo">
            	<fieldset>
            		<legend>Informazioni personali</legend>
            		<div id="errori">
        				<?php global $errori; echo $errori; ?>
        			</div>
            		Nome: <input type="text" name="nome" value="<?php echo $info["nome"]; ?>"><br/>
            		Cognome: <input type="text" name="cognome" value="<?php echo $info["cognome"]; ?>"><br/>
            		Dove ti trovi adesso? <input type="text" name="luogo" value="<?php echo $info["luogo"]; ?>"><br/>
            		<input type="hidden" name="jsIsEnabled" value="NO">
            	</fieldset>
            	<script type="text/javascript">
				<!--
					document.write('<button type="button" name="subscribe" value="subscribe" onclick="checkModificaProfilo();">Modifica</button>');
					document.write('<button type="button" name="cancella" onClick="conferma_eliminazione();">Reset</button>');
            	//  -->
            	</script>
            	<noscript>
            		<input type="submit" value="Modifica">
            		<input type="reset">
            	</noscript>
            </form>
        
        </div>
        
  		<div id="footer">
       		<?php printFooter(); ?>
        </div>      
    	
    </div>
</body>
</html> 