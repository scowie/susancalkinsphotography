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
	
	<link rel="stylesheet" href="css/justifiedGallery.css">
	<link rel="stylesheet" href="css/magnific-popup.css">
	
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.justifiedGallery.js"></script>
	<script type="text/javascript" src="js/jquery.magnific-popup.js"></script>
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
		
		<div class="pageTitle"><?php echo "<h1>$targetGalleryName</h1>"; ?></div>
		
<!--  ********************       MAIN CONTENT       ***************************************** -->	
		
		<div id="portfolioThumbGrid">
		
			<?php
					//access the images (result is a list of nodes)
					$images = $xpath->query('//photos/gallery[@name="'.$targetGalleryName.'"]/image');
					$numImages = $images->length;
					
					$imageFilePath="images/$targetGalleryName/";
					
					//convert DOM node list to array
					$imageArray = array_values(dnl2array($images));
					
					//define new array for images to be sorted
					$sortedImageArray = array();
					
					//sort the array of images by position
					foreach ($imageArray as $image) {
								
								$positions=$image->getElementsByTagName('position');
								foreach($positions as $position){
									$posID = $position->nodeValue;
								}
								$sortedImageArray[$posID] = $image;
								
					}
					ksort($sortedImageArray);

					echo "<div class=\"popup-gallery\">";
					
					//loop through the array of images and display in order found in xml file
					foreach ($sortedImageArray as $image) {
								$imageFullName=$image->getAttribute('filename');
								$imageID = $image->getAttribute('id');
								$imageBaseName=substr($imageFullName, 0, strpos($imageFullName, '.'));
								$imageExtension=substr($imageFullName,strpos($imageFullName, '.'));//including the dot
								$imageThumbName=$imageBaseName."_t".$imageExtension;
								$fullImagePath=$imageFilePath.$imageFullName;
								$thumbImagePath=$imageFilePath.$imageThumbName;
								$titles=$image->getElementsByTagName('title');
								foreach($titles as $title){
									$imageTitle=$title->nodeValue;
								}
								$positions=$image->getElementsByTagName('position');
								foreach($positions as $position){
									$posID = $position->nodeValue;
								}
							
							echo "<a href=\"$fullImagePath\" title=\"$imageTitle\"><img src=\"$thumbImagePath\"></a>";
					}
				?>
	
			</div> <!-- popup-gallery div  -->
			
		</div> <!-- portfolioThumbGrid div -->
	</div> <!--  wrap div   -->
	</div>
	</div>
	
<!-- magnific-popup  -->
<script type="text/javascript">
$('.popup-gallery').justifiedGallery({
	lastRow : 'nojustify', 
    rowHeight : 110,
    maxRowHeight : 130,
    fixedHeight : false,
    captionSettings: { animationDuration: 500,
    				  visibleOpacity: 0.0,
    				  nonVisibleOpacity: 0.0 }
}).magnificPopup({
  delegate: 'a', // child items selector, by clicking on it popup will open
  type: 'image',
  gallery: {
    // options for gallery
    enabled: true
  }
  // other options
});
</script>

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