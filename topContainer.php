<?php
	$galleriesExist = false;
?>
<div id="top_container">
			<div id="logo">
				<?php
					//find the logo node info
					$logoNodes = $xpath->query('//logo');
					
					foreach($logoNodes as $logoNode){
						$logoName=$logoNode->nodeValue;
					}
				?>
				<a href="about.php"><img src="images/logo/logoToryAll.png" id="logo_image" alt=" "></a>
			</div>
		
		
			<nav id="nav">
			<ul id="navigation">
				<li class="last"><a href="https://www.instagram.com/susancphotos/"><i class="fa fa-instagram"></i></a></li>
				<li><a href="contact.php">Contact</a></li>
				<li><a href="about.php">About</a></li>
				<li><a href="portfolioCover.php">Portfolios</a>
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
											echo "<li><form action=\"portfolio.php\" method=\"GET\"><input type=\"submit\" name=\"galleryName\" value=\"$galleryName\" class=\"currentLink\"></form></li>";
										}
										else {
										
											echo "<li><form action=\"portfolio.php\" method=\"GET\"><input type=\"submit\" name=\"galleryName\" value=\"$galleryName\"></form></li>";
										}
										
										}
									}
						}
						?>
					</ul>
				</li>
				
				<li><a href="home.php">Home</a></li>

				<div style="clear:both;"></div>
			</ul>
		</nav>
	
		</div>