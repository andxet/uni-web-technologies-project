<?php
	require_once("script/config.php");
	require_once(SCRIPT_PATH."funzioni.php");
	inizializza();
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
        	
        	<?php
        		if(isset($_GET['start']) && isset($_GET['how'])){
        			$start = $_GET['start'];
        			$how = $_GET['how'];
        		}
        		else{
        		$start = 0;
        		$how = NUMBER_SERIES_PER_PAGE;
        		}
        		
        		printSeries($start, $how);
        		//printPageSelector("Serie");
        	?>
        	       
        </div>
        
  		<div id="footer">
       		<?php printFooter(); ?>
        </div>      
    	
    </div>
</body>
</html> 