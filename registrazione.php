<?php
	require_once("script/config.php");
	require_once(SCRIPT_PATH."funzioni.php");
	
	global $errori;
	require_once(SCRIPT_PATH."form.php");
	global $paginaControllo;
	global $paginaRegistrazione;
	$registrato = false;
	if($_POST)
		if(isset($_POST["jsIsEnabled"]) && checkRegistration($_POST)){
			require_once(SCRIPT_PATH."DbConn.php");
			if(registraUtente($_POST))
				header("Location: ".HOME_PAGE);
			else die("Errore imprevisto nella registrazione.");
		}
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
                
        <div id="errori">
      		<?php              		
      		if(!isset($_POST))
      			$_POST = array();
      		$nickname = setPrecedenti('nickname');
            $nome = setPrecedenti('nome'); 
            $cognome = setPrecedenti('cognome');
            $email = setPrecedenti('email');
            $luogo = setPrecedenti('luogo');
            //echo $nome.$cognome.$email.$frequenza.$tipo.$commenti;
            echo $errori;
      		?>

        </div>
        <form method="post" name="modulo" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="modulo">
            <fieldset>
            <legend>Credenziali utente</legend>
            <input type="hidden" name="jsIsEnabled" value="NO">
            	Nickname:* <input type="text" name="nickname" value=<?php echo '"'.$nickname.'"'; ?>><br />
            	Password:* <input type="password" name="pass" value=""><br />
            	Reinserisci la password:* <input type="password" name="pass2" value=""><br />
            </fieldset>
            <fieldset>
            <legend>Informazioni personali</legend>
                Nome:* <input type="text" name="nome" value=<?php echo '"'.$nome.'"'; ?>><br />
                Cognome:* <input type="text" name="cognome" value=<?php echo '"'.$cognome.'"'; ?>><br />
                E-mail:* <input type="text" name="email" value=<?php echo '"'.$email.'"'; ?>><br />
                Dove abiti? <input type="text" name="luogo" value=<?php echo '"'.$luogo.'"'; ?>><br />
             </fieldset>
            * : Campi obbligatori.
            
            <script type="text/javascript">
				<!--
					document.write('<button type="button" name="subscribe" value="subscribe" onclick="checkRegistrazione();">');
					document.write('Iscriviti!</button>');
				//  -->
			</script>
			<noscript>
				<input type=submit name="subscribe" value="Iscriviti!">
                Subscribe</button>
			</noscript>
            <script type="text/javascript">
				<!--
					document.write('<button type="button" name="cancella" onClick="conferma_eliminazione();">');
                	document.write('Reset</button>');
            	//  -->
            </script>
            <noscript>
            	<button name="reset"><a href="<?php echo $_SERVER['PHP_SELF']; ?>">
            	Reset</a></button>
            </noscript>
            </p>
        </form>        
        
  		<div id="footer">
       		<?php printFooter(); ?>
        </div>      
    	
    </div>
</body>
</html> 