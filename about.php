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
	
	
	<script type="text/javascript" src="js/scp.js"></script>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/changeSize.js"></script>
	<script type="text/javascript" src="js/jquery.lazy.min.js"></script>
	<script type="text/javascript" src="js/jssor.slider.mini.js"></script>

	
	
</head>

<body>

	<div id="horizon">
	<div class="wrapBorder">
	<div class="wrap">
	
		<?php
					include("topContainer.php");
		?>
		
		<div class="pageTitle"><h1>ABOUT</h1></div>
		
		
<!--  ********************       MAIN CONTENT       ***************************************** -->	
		
		


		<div id="aboutContainer">
			<div id="susanPhotoContainer">
					<?php
						//find the photo node info
						$photoNodes = $xpath->query('//susanPhoto');
						
						foreach($photoNodes as $photoNode){
							$photoName=$photoNode->nodeValue;
						}
						echo "<img src=\"images/self/$photoName\" alt=\" \" class=\"susanPhoto\" />";
					?>
			</div>

			<p class="about">
				<?php
					//get the about info
					$aboutInfoNodes = $xpath->query('//about');
					foreach($aboutInfoNodes as $aboutInfoNode){
						$aboutInfo=$aboutInfoNode->nodeValue;
					}
					echo "$aboutInfo";
				?>
			</p>
		</div>
		
		</br>
		<div class="pageTitleC"><h1>Copyright Info</h1></div>


		<div id="copyrightContainer">
			<p class="copyright">
				<?php
					//get the copyright info
					$copyrightInfoNodes = $xpath->query('//copyright');
					foreach($copyrightInfoNodes as $copyrightInfoNode){
						$copyrightInfo=$copyrightInfoNode->nodeValue;
					}
					echo "$copyrightInfo";
				?>
			</p>
		</div>

		</div>
</div>		
</div>

</body>
</html>