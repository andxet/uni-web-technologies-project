<?php
	require_once("script/config.php");
	require_once(SCRIPT_PATH."funzioni.php");
	inizializza();
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
    		printMenu("Controlli utente");

            printMenu("Menu");
            ?>  
        
        <div id="content">
        	<?php $info = getUserInfo(USER); ?>
        	<h2>I tuoi dati:</h2>
        	<?php userInfo(USER); ?>
            <button type="button"><a href="edit_password.php">Modifica la password</a></button><br/>
            eMail: <?php echo $info["email"] ?><button type="button"><a href="edit_mail.php">Modifica</a></button><br/>
            <button type="button"><a href="edit_user.php">Modifica altri dati</a></button><br/>
        </div>
        
  		<div id="footer">
       		<?php printFooter(); ?>
        </div>      
    	
    </div>
</body>
</html> 