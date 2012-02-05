<?php
	require_once("script/config.php");
	require_once(SCRIPT_PATH."funzioni.php");
	require_once(SCRIPT_PATH."form.php");
	inizializza();
	
	//print_r($_GET);
	$fumetto;
	checkForm("modificaFumetto");
	if(isset($_POST["idVolume"]))
		$fumetto = mysql_fetch_array(getFumetto($_POST["idVolume"]));
	if(isset($_GET["fumetto"]))
		$fumetto = mysql_fetch_array(getFumetto($_GET["fumetto"]));
	if($fumetto == null)//Non esiste un fumetto con questo id
		header("Location: list.php");
	
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
        	
        	<?php stampaForm("modificaFumetto"); ?>
        	       
        </div>
        
  		<div id="footer">
       		<?php printFooter(); ?>
        </div>      
    	
    </div>
</body>
</html> 