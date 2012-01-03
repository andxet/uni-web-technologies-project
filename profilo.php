<?php
	require_once("script/config.php");
	require_once(SCRIPT_PATH."funzioni.php");
	inizializza();
	require_once(SCRIPT_PATH."form.php");
	checkForm("modificaDati");
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
            <?php stampaForm("modificaDati"); ?>   
        </div>
        
  		<div id="footer">
       		<?php printFooter(); ?>
        </div>      
    	
    </div>
</body>
</html> 