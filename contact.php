<!doctype html>
<html lang="en">
<head>
	<?php
		include("titleMetaFonts.php");
		include("DOMandFunctions.php");
	?>
	
	<link rel="stylesheet" href="css/scp.css">
	<script type="text/javascript">
		document.write('<style type="text/css">body{display:none}</style>');
	</script>
	
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.lazy.min.js"></script>
	<script type="text/javascript" src="js/scp.js"></script>
	<script type="text/javascript" src="js/jssor.slider.mini.js"></script>
	<script type="text/javascript" src="js/changeSize.js"></script>
	
</head>

<body>

	<div id="horizon">
	<div class="wrapBorder">
	<div class="wrap">
	
		<?php
					include("topContainer.php");
		?>
		
		<div class="pageTitle"><h1>CONTACT</h1></div>
		
		
<!--  ********************       MAIN CONTENT       ***************************************** -->	
		<div id="contactContainer">
			<p class="contact">
				<?php
				
					//get the phone info
					$phoneInfoNodes = $xpath->query('//phone');
					foreach($phoneInfoNodes as $phoneInfoNode){
						$phoneInfo=$phoneInfoNode->nodeValue;
					}
				
					//get the e-mail info
					$emailInfoNodes = $xpath->query('//e-mail');
					foreach($emailInfoNodes as $emailInfoNode){
						$emailInfo=$emailInfoNode->nodeValue;
					}
					
					//display results
					echo "$phoneInfo";
					echo "<br />";
					echo "$emailInfo";
				?>
			</p>
		</div>
		
		</div>
</div>
</div>

</body>
</html>