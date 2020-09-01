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
	<script type="text/javascript" src="js/changeSize.js"></script>

	
</head>

<body>
	
	<div id="horizon">
	<div class="wrapBorder">
	<div class="wrap">
	
		<?php
					
					include("topContainer.php");
		?>
		
		<div class="pageTitle"><h1>PORTFOLIOS</h1></div>
		
		
<!--  ********************       MAIN CONTENT       ***************************************** -->	
		
		<div id="portfolioCoverContainer">
		
			<?php
					/*   *************   DISPLAY PORTFOLIOS    ***********************   */
					
					if($galleriesExist){
					
					foreach ($sortedGalleryArray as $gallery) {
						$portfolioName=$gallery->getAttribute('name');
						$firstImage = $xpath->query('//photos/gallery[@name="'.$portfolioName.'"]/image[position="1"]');
						foreach($firstImage as $fI){
							$firstImageName=$fI->getAttribute('filename');
						}
						$firstImageBaseName=substr($firstImageName, 0, strpos($firstImageName, '.'));
								$imageExtension=substr($firstImageName,strpos($firstImageName, '.'));//including the dot
								$imageThumbName=$firstImageBaseName."_t".$imageExtension;

						echo "<div class=\"portfolioListWrapper\">";
						echo "<form action=\"portfolio.php\" method=\"GET\"><input type=\"submit\" name=\"galleryName\" value=\"$portfolioName\" class=\"portfolioCoverButton\" style=\"background-image: url('images/$portfolioName/$imageThumbName'); cursor:pointer;\"></form>";
						echo "<h4 class=\"portfolioList\">";
						echo $gallery->getAttribute('name');
						echo "</h4>";
						echo "<p class=\"portfolioDescription\">";
						echo "</p>";
						echo "</div>";
						echo "<div style=\"clear:both\"></div>";
						}
				
					}
					?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

$(window).bind("load", function() {
    var timeout = setTimeout(function() {
        $("img.lazy").each(function(){
			$(this).attr('src', $(this).attr('data-src'));
		})
	}, 100);
});

</script>

</body>
</html>