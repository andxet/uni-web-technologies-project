<?php
	require_once("script/config.php");
	require_once(SCRIPT_PATH."funzioni.php");
	inizializza();
	if(!isset($_GET["utente"]))
		header("Location: index.php");
	$utente = $_GET["utente"];
	if($utente == USER)
		header("Location: impostazioni.php");
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
        <script src="script/menu.js"></script>	

        <?php
        	
        	$amico = isAmico(USER, $utente);
        	printUserInfo(getUserInfo($utente), "bottoneUtente"); 
        	if($amico)
        		printLista($utente);
        	else
        		echo "<p>Impossibile vedere la lista di questo utente:<br />Questo utente non &egrave; tuo amico oppure deve ancora confermare la tua richiesta di amicizia.</p>";
        	
        ?> 
            	       
        </div>
        
  		<div id="footer">
       		<?php printFooter(); ?>
        </div>      
    	
    </div>
</body>
</html> 