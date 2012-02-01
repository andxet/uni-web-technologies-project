<?php
	require_once("script/config.php");
	require_once(SCRIPT_PATH."funzioni.php");
	require_once(SCRIPT_PATH."form.php");
	inizializza();
	$risultati = "";
	checkForm("cerca");
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
        	<div id="formCerca">
        		<?php
        			stampaForm("cerca"); 
        		?>
        	</div>
        	
        	<?php
        		if($risultati != "")
        			stampaRisultati();
        	?>
        	       
        </div>
        
  		<div id="footer">
       		<?php printFooter(); ?>
        </div>      
    	
    </div>
</body>
</html> 