<?php
	require_once("script/config.php");
	require_once(SCRIPT_PATH."funzioni.php");
	inizializza();
	if(!isset($_GET["destinatario"]) || $_GET["destinatario"] == "" || (!isAmico(USER, $_GET["destinatario"]) && $_GET["destinatario"]!="administrator"))
		header("Location: amici.php");
	$destinatario = $_GET["destinatario"];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
   		<?php printHead(); ?>
    </head>
<body>	

    <div id="container">
    
    	<div id="header">
    		<?php 
    		printHeader(); 
    	echo "</div>";
    		printMenu("Controlli utente");

            printMenu("Menu");
            ?>  
        
        <div id="content">
        <div id="scriviMessaggio"></div>
        	<p>Il messaggio verr&agrave; mandato all'indirizzo e-mail del destinatario.</p>
        	<form method="post" name="messaggio" action="invia.php">
        		<input type=hidden value="<?php echo $destinatario; ?>" name="destinatario">
        		<fieldset>
        		<legend>Scrivi a <?php echo $destinatario; ?>:</legend>
        			Oggetto: <input type=text name="oggetto" /> <br />
        			<textarea name="messaggio" rows=20 cols=95 >Messaggio. . .</textarea>
          		</fieldset>
          	<input type="submit" name="submit" value="Invia!">
        	</form>
        	       
        </div></div>
        
  		<div id="footer">
       		<?php printFooter(); ?>
        </div>      
    	
    </div>
</body>
</html> 