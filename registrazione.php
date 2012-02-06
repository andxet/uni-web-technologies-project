<?php
	require_once("script/config.php");
	require_once(SCRIPT_PATH."funzioni.php");
	require_once(SCRIPT_PATH."form.php");
	checkForm("registrazione");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
   		<?php printHead();
   		echo "<script src=\"".SCRIPT_PATH."form.js\" type=\"text/javascript\"></script>"; ?>
    </head>
<body>	

    <div id="container">
  		<h1>Iscriviti a <?php echo SITE_NAME; ?></h1>

		<?php stampaForm('registrazione'); ?>
	
    </div>    
  	<div id="footer">
       	<?php printFooter(); ?>
	</div>      
    	
    </div>
</body>
</html> 