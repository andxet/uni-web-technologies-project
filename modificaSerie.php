<?php
	require_once("script/config.php");
	require_once(SCRIPT_PATH."funzioni.php");
	require_once(SCRIPT_PATH."form.php");
	inizializza();
		
	$serie;
	checkForm("modificaSerie");
	if(isset($_POST["idSerie"]))
		$serie = mysql_fetch_array(getSerie($_POST["idSerie"]));
	if(isset($_GET["serie"]))
		$serie = mysql_fetch_array(getSerie($_GET["serie"]));
	if($serie == null)//Non esiste una serie con questo id
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
        	
        	<?php stampaForm("modificaSerie"); ?>
        	       
        </div>
        
  		<div id="footer">
       		<?php printFooter(); ?>
        </div>      
    	
    </div>
</body>
</html> 