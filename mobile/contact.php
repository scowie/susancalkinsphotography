<!doctype html>
<html lang="en">
<head>
	<?php
		include("../titleMetaFonts.php");
		include("DOMandFunctions.php");
	?>
	
	<link rel="stylesheet" href="../css/scp.css">
	<link rel="stylesheet" href="../css/scp_m.css">
	<script type="text/javascript">
		document.write('<style type="text/css">body{display:none}</style>');
	</script>
	
	
	<script type="text/javascript" src="../js/scp.js"></script>
	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<script type="text/javascript" src="../js/changeSize.js"></script>
	
</head>

<body>

	<div id="mobileContainer">
	</br></br>	
<!--  ********************       MAIN CONTENT       ***************************************** -->	
		<div id="contactContainer">
			<p class="mobileContact">
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

		</br></br>
		<nav id="galleries">
				<ul>
						<li class="last"><a href="index.php">HOME</a><p> > </p></li>
					
				</ul>

				<div style="clear:both;"></div>
		</nav>

	</div>

</body>
</html>