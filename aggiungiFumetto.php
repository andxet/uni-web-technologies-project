<?php
	require_once("script/config.php");
	require_once(SCRIPT_PATH."funzioni.php");
	require_once(SCRIPT_PATH."form.php");
	inizializza();
	
	$fumetto;
	checkForm("inserisciFumetto");
	
	if(isset($_POST["serie"]) && !isset($_GET["serie"]))
		$_GET["serie"] = '';

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
        	<div id="errori"></div>
            <?php
        	if(!isset($_GET["serie"]) && !isset($_POST["serie"]))
        			echo "Per inserire un fumetto, <a href=list.php>seleziona una serie</a> ed utilizza l'apposito pulsante ( + bianca su sfondo verde)";
        	else
 				stampaForm("inserisciFumetto");
 			?>
        	       
        </div>
        
  		<div id="footer">
       		<?php printFooter(); ?>
        </div>      
    	
    </div>
</body>
</html> 