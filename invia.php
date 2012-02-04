<?php
	require_once("script/config.php");
	require_once(SCRIPT_PATH."funzioni.php");
	inizializza();
	if(!isset($_POST["destinatario"]) || $_POST["destinatario"] == "" || (!isAmico(USER, $_POST["destinatario"]) && $_POST["destinatario"]!="administrator"))
		header("Location: amici.php");

	$destinatario = $_POST["destinatario"];
	$inviato = inviaMail($_POST);
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
       
       		<?php
       			if($inviato){
       				?><p><h1>Messaggio inviato!</h1></p><?php }
       				else{
       				?><p>Errore nell'invio del messaggio! Assicurati di essere amico dell'utente a cui vuoi mandare il messaggio.</p><?php } ?>
        	       
        </div></div>
        
  		<div id="footer">
       		<?php printFooter(); ?>
        </div>      
    	
    </div>
</body>
</html> 