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
	
	<link rel="stylesheet" href="../css/justifiedGallery.css">
	<link rel="stylesheet" href="../css/magnific-popup.css">
	
	
	<script type="text/javascript" src="../js/scp.js"></script>
	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<script type="text/javascript" src="../js/changeSize.js"></script>
	<script type="text/javascript" src="../js/jquery.justifiedGallery.js"></script>
	<script type="text/javascript" src="../js/jquery.magnific-popup.js"></script>
	<script type="text/javascript" src="../js/jquery.lazy.min.js"></script>
	
</head>

<body>
	
		
<!--  ********************       MAIN CONTENT       ***************************************** -->	
		<div id="mobileContainer">

			<nav id="galleries">
				<ul>
						<li class="last"><a href="index.php">HOME</a><p> > </p></li>
					
				</ul>

				<div style="clear:both;"></div>
			</nav>

			<?php

					//get the name for the gallery that needs displayed
					if(isset($_GET['galleryName'])){
						$targetGalleryName = $_GET['galleryName'];
						}
					else {
						$targetGalleryName = $firstGalleryName;
					}

					//access the images (result is a list of nodes)
					$images = $xpath->query('//photos/gallery[@name="'.$targetGalleryName.'"]/image');
					$numImages = $images->length;
					
					$imageFilePath="../images/$targetGalleryName/";
					
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
							
							echo "<img src=\"$fullImagePath\" class=\"mobileImage\">";
					}
			?>

			<nav id="galleries">
				<ul>
						<li class="last"><a href="index.php">HOME</a><p> > </p></li>
					
				</ul>

				<div style="clear:both;"></div>
			</nav>


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