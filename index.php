<?php
	require_once("script/config.php");
	require_once($script_path."funzioni.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >
<script src="<?php echo $script_path; ?>menu.js" type="text/javascript"></script>
   <title><?php printTitolo($_SERVER['PHP_SELF']); ?></title>
   
   <link rel="stylesheet" type="text/css" href="<?php echo $css_path; ?>style_layout.css" >
   
</head>


<body>
	
    <div id="container">
 
    	<div id="header">
    		<?php printHeader(); ?>
    	</div>
        
        <div id="navigation">
            
            <?php
            stampa_menu();
            ?>
            
            <div id="info">
            	<script type="text/javascript">
				<!--
					stampaInfoAlt();
				//  -->
				</script>
            </div>
            	
        </div>
        
        <div id="content">
        
            <p>AC/DC are an Australian rock band formed in 1973 by brothers Malcolm and Angus Young. Although the band are commonly classified as hard rock and are considered a pioneer of heavy metal, they have always classified their music as rock and roll.</p>
            
            <p>AC/DC underwent several line-up changes before releasing their first album, High Voltage, in 1975. Membership remained stable until bassist Mark Evans was replaced by Cliff Williams in 1977 for the album Powerage. The band recorded their highly successful album Highway to Hell in 1979. Lead singer and co-songwriter Bon Scott died on 19 February 1980, after a night of heavy alcohol consumption. The group briefly considered disbanding, but soon ex-Geordie singer Brian Johnson was selected to replace Scott. Later that year, the band released their best-selling album, Back in Black.</p>
        
            <p>The band's next album, For Those About to Rock We Salute You, was their first album to reach number one in the United States. AC/DC declined in popularity soon after drummer Phil Rudd was fired in 1983 and was replaced by future Dio drummer Simon Wright, though the band resurged in the early 1990s with the release of The Razor's Edge. Phil Rudd returned in 1994 (after Chris Slade, whom was with the band from 1990-1994, was asked to leave in favour of him) and contributed to the band's 1995 album Ballbreaker. Stiff Upper Lip was released in 2000 and was well received by critics. Since then, the band has stayed the same with the 1980-1983 lineup. The band's most recent album, Black Ice, was released on 20 October 2008. It was their biggest hit on the charts since "For Those About to Rock, reaching #1 on all the charts eventually. AC/DC's newest studio album, AC/DC: Iron Man 2 is set to release on April 19, 2010.</p>
        
            <p>As of 2008, AC/DC have sold more than 200 million albums worldwide, including 71 million albums in the United States. Back in Black has sold an estimated 45 million units worldwide, making it the highest-selling album by any band and the 2nd highest-selling album in history, behind Thriller by Michael Jackson. The album has sold 22 million in the US alone, where it is the fifth-highest-selling album. AC/DC ranked fourth on VH1's list of the "100 Greatest Artists of Hard Rock" and was named the seventh "Greatest Heavy Metal Band of All Time" by MTV. In 2004, the band was ranked number 72 in the Rolling Stone list of the "100 Greatest Artists of All Time".</p>
        
        </div>
        
  		<div id="footer">
       		<?php printFooter(); ?>
        </div>      
    	
    </div>
</body>
</html> 