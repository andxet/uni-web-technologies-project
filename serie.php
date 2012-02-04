<?php
	require_once("script/config.php");
	require_once(SCRIPT_PATH."funzioni.php");
	inizializza();
	if(!isset($_GET["serie"]))
		header("Location: list.php");
	$serie = $_GET["serie"];
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
        <script src="script/funzioniAjax.js"></script>
        	<?php 
        		//Comandi controllo serie
        		printMenu('Controlli fumetti');
        		printSerieDettagli($serie);
        		//printElencoFumetti($serie);
        		//printCommenti($serie);
        	?>
        <!--
		<div id=aggiungiCommento>
        	<form action=agginungiCommento.php method="post" name=aggiungiCommento>
        		<fieldset>
        			<legend>Aggiungi un commento</legend>
        			<input type="hidden" name=serie value=<?php echo $serie; ?>>
        			<input type="hidden" name=user value=<?php echo USER; ?>>
        			        			<text name=commento>
        				Inserisci il commento qui...
        			</text>
        			<submit value="Inserisci" onclick=checkCommento() >
        			<noscript>
        				<input type="submit" value="Inserisci">
        			</noscript>        		</fieldset>
        	</form>
        </div>-->

        	<p>Non hai trovato quello che cerchi? <a href="scrivi.php?destinatario=<?php echo ADMINISTRATOR ?>">Chiedi di aggiungerlo!</a></p>       
        </div>
        
  		<div id="footer">
       		<?php printFooter(); ?>
        </div>      
    	
    </div>
</body>
</html> 