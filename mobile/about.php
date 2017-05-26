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
	
		<nav id="galleries">
				<ul>
						<li class="last"><a href="index.php">HOME</a><p> > </p></li>
					
				</ul>

				<div style="clear:both;"></div>
		</nav>
		</br>
		
		<div class="pageTitleMobile"><p>ABOUT</p></div>
		
		
<!--  ********************       MAIN CONTENT       ***************************************** -->	
		
		

		</br>
		<div id="aboutContainerMobile">
			<div id="susanPhotoContainerMobile">
					<?php
						//find the photo node info
						$photoNodes = $xpath->query('//susanPhoto');
						
						foreach($photoNodes as $photoNode){
							$photoName=$photoNode->nodeValue;
						}
						echo "<img src=\"../images/self/$photoName\" alt=\" \" class=\"susanPhoto\" />";
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
		<div class="pageTitleMobile"><p>COPYRIGHT INFO</p></div>
		</br>

		<div id="copyrightContainerMobile">
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

		</br>
		<nav id="galleries">
				<ul>
						<li class="last"><a href="index.php">HOME</a><p> > </p></li>
					
				</ul>

				<div style="clear:both;"></div>
		</nav>

	</div>

</body>
</html>