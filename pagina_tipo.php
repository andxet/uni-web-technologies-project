<?php
	require_once("script/config.php");
	require_once(SCRIPT_PATH."funzioni.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<?php printHead(); ?>
   </head>
<body>	

    <div id="container">
    
    	<div id="header">
    		<?php printHeader(); ?>
    	</div>
    	
        <div id="user_control">
        	<?php printUserControl(); ?>
        </div>
        
        <div id="navigation">
            <?php
            stampa_menu();
            ?>            	
        </div>
        
        <div id="content">
        	<div id="errori">
        		<?php global $errori; echo $errori; ?>
        	</div>
            COSE
        
        </div>
        
  		<div id="footer">
       		<?php printFooter(); ?>
        </div>      
    	
    </div>
</body>
</html> 