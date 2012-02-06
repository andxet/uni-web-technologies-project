<?php
	require_once("script/config.php");
	require_once(SCRIPT_PATH."funzioni.php");
	inizializza();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
   		<?php printHead(); ?>
   		<script src=script/cookie.js type="text/javascript"></script>
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
        		printUserInfo(getUserInfo(USER), null);
        	?>   
        	<script type="text/javascript">
        	<!-- 
        		stampaVisite();
        	-->
        	</script>
        	<h2>Come iniziare?</h2>
        	<p>Con fumeZZi puoi:
        	<ul>
        		<li>Mantenere una lista dei fumetti che possiedi (clicca su esplora ed aggiungi i tuoi fumetti!)</li>
        		<li>Ricordare quali hai già letto</li>
        	</ul>
        	E non solo! FumeZZi &egrave; pi&ugrave; di una semplice lista!
        	<ul type="square">
        		<li>Cerca i tuoi amici e rimanete in contatto!</li>
        		<li>Controlla la lista dei tuoi amici, se possiede fumetti che ti mancano, proponigli uno scambio inviandogli un messaggio!</li>
        	</ul>
        	</p>
        </div>
        
  		<div id="footer">
       		<?php printFooter(); ?>
        </div>      
    	
    </div>
</body>
</html> 