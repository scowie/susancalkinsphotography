<!DOCTYPE html>
<html>
<head>
	<?php
		include("../titleMetaFonts.php");
		include("DOMandFunctions.php");
	?>
	
	<link rel="stylesheet" href="../css/scp_m.css">
	<link rel="stylesheet" href="../css/fontawesome/css/font-awesome.css">
	<script type="text/javascript">
		document.write('<style type="text/css">body{display:none}</style>');
	</script>
	
	
	<script type="text/javascript" src="../js/scp.js"></script>
	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<script type="text/javascript" src="../js/changeSize.js"></script> 
	<script type="text/javascript" src="../js/jquery.lazy.min.js"></script>
	<script type="text/javascript" src="../js/jssor.slider.mini.js"></script>
</head>

<body>
	
	<div id="mobileContainer">
		
		<div id="top_container">
			<div id="logo">
				<img src="../images/logo/logoTory.png" id="logo_image" alt=" ">
			</div>
		</div>
		
		
		<nav id="galleries">
				<ul>
					<?php
						//get the name of the 1st gallery
						$gallery = $xpath->query('//gallery[order="1"]');
						//if there is at least one gallery search and show all the galleries
						if($gallery->length > 0){
							$galleriesExist = true;
							foreach($gallery as $foundGallery){
								$firstGalleryName = $foundGallery->getAttribute('name');
							}					
						//get the name for the gallery that needs displayed
						if(isset($_GET['galleryName'])){
							$targetGalleryName = $_GET['galleryName'];
							}
						else {
							$targetGalleryName = $firstGalleryName;
						}
						//get the gallery nodes from the XML file
						$galleryNodes = $xpath->query('//gallery');
						
						$galleryArray = array_values(dnl2array($galleryNodes));
						//define new array for images to be sorted
						$sortedGalleryArray = array();
						//sort the array of galleries by order
						foreach ($galleryArray as $gallery) {
									$orders=$gallery->getElementsByTagName('order');
									foreach($orders as $order){
										$orderID = $order->nodeValue;
									}
									$sortedGalleryArray[$orderID] = $gallery;
						}
						ksort($sortedGalleryArray);
						foreach($sortedGalleryArray as $gallery) {
							$galleryName = $gallery->getAttribute('name');
							$orders=$gallery->getElementsByTagName('order');
									foreach($orders as $order){
										$orderID = $order->nodeValue;
										//find the gallery name that matches the order#
										$gallery = $xpath->query('//gallery[order="'.$orderID.'"]');
										foreach($gallery as $foundGallery){
											$foundGalleryName = $foundGallery->getAttribute('name');
										}
										//see if the gallery matches the target
										if($foundGalleryName == $targetGalleryName){
											echo "<li><form action=\"portfolio.php\" method=\"GET\"><input type=\"submit\" name=\"galleryName\" value=\"$galleryName\" class=\"currentLink\"></form>
											<p> > </p></li>";
										}
										else {
											echo "<li><form action=\"portfolio.php\" method=\"GET\"><input type=\"submit\" name=\"galleryName\" value=\"$galleryName\"></form>
											<p> > </p></li>";
										}
										}
									}
						}
						?>
					
					<li><a href="about.php">ABOUT</a><p> > </p></li>
					<li><a href="contact.php">CONTACT</a><p> > </p></li>
					<li class="last"><a href="https://www.instagram.com/susancphotos/"><i class="fa fa-instagram"></i></a></li>
					
				</ul>

				<div style="clear:both;"></div>
		</nav>
		
	</div>
	
<script src="http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui.js"></script>
<script type="text/javascript" src="../js/scp.js"></script>

</body>
</html>