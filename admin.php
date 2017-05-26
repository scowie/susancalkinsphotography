<?php require_once('sessionCheck.php'); ?>
			
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
	
	<script type="text/javascript" src="js/jquery.lazy.min.js"></script>
	<script type="text/javascript" src="js/scp.js"></script>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/changeSize.js"></script>
	
</head>

<body>
	<div id="horizon">
	<div class="wrapBorder">
	<div class="wrap">
		<?php
			
		
				include("topContainer.php");
		?>
		<hr />
		<div class="pageTitle">
		<div id="logout">
			<form action="logout.php" method="POST">
				<input type="submit" value="Logout" name="logout">
			</form>
			</div>
			<h1>ADMINISTRATIVE CONTROL PANEL</h1>
		</div>
		<div id="admin_galleries" >
			<h1 class="admin" style="margin-bottom:-10px;">GALLERIES</h1>
			</br>
			<?php
				if($galleriesExist){
				//find the galleries (result is an array)
				$galleryNodes = $xpath->query('//photos/gallery');
				
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
				
				//store gallery node
				foreach ($sortedGalleryArray as $gallery) {
					$editName=$gallery->getAttribute('name');
					$editID=$gallery->getAttribute('id');
					$deleteID=$editID;
					echo "<div class=\"galleryList\">";
					echo "<h2 class=\"admin\" style=\"float:left; margin-right:5px;\">";
					echo $gallery->getAttribute('name');
					echo "</h2>";
					echo "<form action=\"edit.php\" method=\"POST\"><input type=\"submit\" value=\"EDIT\" name=".$editID." class=\"editGalleryButton\"></form>";
					echo "<form id=\"deleteGallery\" action=\"deleteGallery.php\" method=\"POST\" onsubmit=\"return confirmDeleteGallery();\"><input type=\"submit\" value=\"DELETE\" name=".$deleteID." class=\"deleteGalleryButton\"></form>";
					// move gallery up in order
					echo "<form action=\"moveGalleryUp.php\" method=\"POST\"><input type=\"submit\" value=\"$editName\" name=\"galleryName\" class=\"moveGalleryUpButton\"><input type=\"hidden\" value=\"$editName\" name=\"galleryName\" ><input type=\"hidden\" value=\"$editID\" name=\"$editID\" ></form>";
					
					// move gallery down in order
					echo "<form action=\"moveGalleryDown.php\" method=\"POST\"><input type=\"submit\" value=\"$editName\" name=\"galleryName\" class=\"moveGalleryDownButton\"><input type=\"hidden\" value=\"$editID\" name=\"galleryID\" ><input type=\"hidden\" value=\"$editID\" name=\"$editID\" ></form>";

					// toggle gallery visibility
					echo "<form action=\"toggleGalleryVisibility.php\" method=\"POST\"><input type=\"submit\" value=\"$editName\" name=\"galleryName\" class=\"moveGalleryDownButton\"><input type=\"hidden\" value=\"$editID\" name=\"galleryID\" ><input type=\"hidden\" value=\"$editID\" name=\"$editID\" ></form>";

					echo "</br>";
					echo "</div>";
					}
				}
			?>
			
			<form action="createGallery.php" method="POST">
				<input type="text" value="" name="newGalleryName" class="newGalleryTextBox">
				<input type="submit" value="ADD" name="button" class="addNewGalleryButton">
			</form>
			<div style="clear:both;"></div>
		</div>
		<hr class="dotted" />
		<div id="admin_slideshow">
			<h1 class="admin">SLIDESHOW</h1>
				<?php
				
					if($galleriesExist){
					//access the slideshow images
					$images = $xpath->query('//photos/gallery/image[slideshow="1"]');
					
					//convert DOM node list to array
					$imageArray = array_values(dnl2array($images));
					
					//define new array for images to be sorted
					$sortedImageArray = array();
					
					//sort the array of images by position
					foreach ($imageArray as $image) {
								
								$slideShowPositions=$image->getElementsByTagName('slideShowPosition');
								foreach($slideShowPositions as $slideShowPosition){
									$slideShowPositionID = $slideShowPosition->nodeValue;
								}
								$sortedImageArray[$slideShowPositionID] = $image;
					}
					ksort($sortedImageArray);
					
					foreach ($sortedImageArray as $image) {
					
						$imageFullName=$image->getAttribute('filename');
						$imageID = $image->getAttribute('id');
						$imageBaseName=substr($imageFullName, 0, strpos($imageFullName, '.'));
						$imageExtension=substr($imageFullName,strpos($imageFullName, '.'));//including the dot
						$imageThumbName=$imageBaseName."_t".$imageExtension;
						
						$galleryName=$image->parentNode->getAttribute('name');
						$imageFilePath="images/$galleryName/";
						
						$fullImagePath=$imageFilePath.$imageThumbName;
						$titles=$image->getElementsByTagName('title');
						foreach($titles as $title){
							$imageTitle=$title->nodeValue;
						}
						$deleteImageName=$imageFullName;
						echo "<div class=\"imageList\">";
						echo "<h2 class=\"admin\">";
						echo "File Name: ".$imageFullName;
						echo "</h2>";
						echo "<div id=\"editImageThumbContainer\">";
						echo "<img src=\"$fullImagePath\" class=\"editImageThumb\" alt=\" \">";
						echo "</div>";
						echo "</br>";
						
						// remove image button
						echo "<form id=\"removeImage\" action=\"removeFromSlideShow.php\" method=\"POST\" onsubmit=\"return confirmRemoveImage();\"><input type=\"submit\" value=\"$imageID\" name=\"imageID\" class=\"removeImageButton\" ></form>";

						// move image up in order
						echo "<form action=\"moveSlideShowImageUp.php\" method=\"POST\"><input type=\"submit\" value=\"$imageID\" name=\"imageID\" class=\"moveImageUpButton\"></form>";

						// move image down in order
						echo "<form action=\"moveSlideShowImageDown.php\" method=\"POST\"><input type=\"submit\" value=\"$imageID\" name=\"imageID\" class=\"moveImageDownButton\"></form>";
						
						echo "<div style=\"clear:both\"></div>";
						
						//end of the imageList div container
						echo "</div>";
						
						}//end of what to do for each image
					}
				?>
		</div>
		<hr class="dotted" />
		<div id="admin_about" >
			<h1 class="admin">ABOUT</h1>
				<?php
					//find the about node info
					$aboutInfoNodes = $xpath->query('//about');
					
					foreach($aboutInfoNodes as $aboutInfoNode){
						$aboutInfo=$aboutInfoNode->nodeValue;
					}
				
					echo "<form action=\"saveAbout.php\" id=\"aboutSusan\" method=\"POST\">";
					echo "<textarea name=\"about\" class=\"aboutTextArea\" >";
					echo $aboutInfo;
					echo "</textarea>";
					echo "<input type=\"submit\" value=\"submit\" name=\"submit\" class=\"saveAboutButton\">";
					echo "</form>";
				?>
		</div>
		<hr class="dotted" />
		<div id="admin_copyright" >
			<h1 class="admin">COPYRIGHT</h1>
				<?php
					//find the copyright node info
					$copyrightInfoNodes = $xpath->query('//copyright');
					
					foreach($copyrightInfoNodes as $copyrightInfoNode){
						$copyrightInfo=$copyrightInfoNode->nodeValue;
					}
				
					echo "<form action=\"saveCopyright.php\" id=\"copyright\" method=\"POST\">";
					echo "<textarea name=\"copyright\" class=\"copyrightTextArea\" >";
					echo $copyrightInfo;
					echo "</textarea>";
					echo "<input type=\"submit\" value=\"submit\" name=\"submit\" class=\"saveCopyrightButton\">";
					echo "</form>";
				?>
		</div>
		<hr class="dotted" />	
		<div id="admin_contact">
			<h1 class="admin">CONTACT</h1>
				<?php
					//find the phone node info
					$phoneInfoNodes = $xpath->query('//phone');
					
					foreach($phoneInfoNodes as $phoneInfoNode){
						$phoneInfo=$phoneInfoNode->nodeValue;
					}
					
					//find the email node
					$emailNodes = $xpath->query('//e-mail');
					foreach($emailNodes as $emailNode){
						$emailInfo=$emailNode->nodeValue;
					}
				
					echo "<h2 class=\"admin\" style=\"float:left; margin-right:5px;\">Phone:</h2>";
					echo "<form action=\"savePhoneEmail.php\" id=\"savePhoneEmail\" method=\"POST\">";
					echo "<input type=\"text\" value=\"$phoneInfo\" name=\"phoneInfo\" class=\"savePhoneInfo\">";
					echo "<div style=\"clear:both;\"></div>";
					echo "<h2 class=\"admin\" style=\"float:left; margin-right:5px;\">E-mail:</h2>";
					echo "<input type=\"text\" value=\"$emailInfo\" name=\"emailInfo\" class=\"saveEmailInfo\">";
					echo "<div style=\"clear:both;\"></div>";
					echo "<input type=\"submit\" value=\"submit\" name=\"submit\" class=\"savePhoneEmailButton\">";
					echo "</form>";
				?>
		</div>
		<hr class="dotted" />
		<div id="admin_photo">
			<h1 class="admin">PHOTO</h1>
				<?php
					//find the photo node info
					$photoNodes = $xpath->query('//susanPhoto');
					
					foreach($photoNodes as $photoNode){
						$photoName=$photoNode->nodeValue;
					}
				
					echo "<div id=\"adminPhotoContainer\">";
					echo "<img src=\"images/self/$photoName\" alt=\" \" style=\"max-height:100%;\" class=\"susanPhoto\">";
					echo "</div>";
				
				?>
		</div>
		
		<div id="admin_photo_upload">
			<?php
				//PHOTO updload and add area
				echo "<div class=\"adminUploadPhotoContainer\">";
				echo "<h2 class=\"admin\">Upload New Portraits</h2></br>";
				echo "<form action=\"adminUploadPhotos.php\" method=\"POST\" enctype=\"multipart/form-data\">";
					echo "<input type=\"file\" name=\"file[]\" multiple /></br></br>";
					echo "<input type=\"submit\" value=\"submit\" name=\"adminPhotoUploads\" class=\"uploadPhotoSubmitButton\">";
				echo "</form>";
				echo "</div></br>";
				echo "<div class=\"adminPhotoAddContainer\">";
				echo "<h2 class=\"admin\">Select New Portrait</h2></br>";
				echo "<form id=\"adminAddPhotoForm\" action=\"adminAddPhoto.php\" method=\"POST\">";
				echo "<select name=\"adminAddPhotoName\" form=\"adminAddPhotoForm\">";
					echo "<option value=\" \">";
					echo "- Select Photo -";
							$dirPath = dir("images/self/");
							$imgArray = array();
							while (($file = $dirPath->read()) !== false)
							{
							   $imgArray[ ] = trim($file);
							}
							$dirPath->close();
							sort($imgArray);
							$c = count($imgArray);
							for($i=0; $i<$c; $i++)
							{
								echo "<option value=\"" . $imgArray[$i] . "\">" . $imgArray[$i] . "\n";
							}
						
				echo "</option>";
				echo "</select>";
				echo "<input type=\"submit\" value=\"add\" name=\"adminPhotoAddButton\" class=\"adminPhotoAddButton\">";
				echo "</form>";
				echo "</div></br>";
		?>
		</div>
		<hr class="dotted" />	
		<div id="admin_logo">
			<h1 class="admin">LOGO</h1>
				<?php
					//find the logo node info
					$logoNodes = $xpath->query('//logo');
					
					foreach($logoNodes as $logoNode){
						$logoName=$logoNode->nodeValue;
					}
					echo "<div id=\"adminLogoContainer\">";
					echo "<img src=\"images/logo/$logoName\" alt=\" \" style=\"max-height:100%;\" class=\"logoPhoto\">";
					echo "</div>";
				?>
		</div>
					
		<div id="admin_logo_upload">
			<?php
				//LOGO upload and add area
				echo "<div class=\"adminUploadLogoContainer\">";
				echo "<h2 class=\"admin\">Upload New Logos</h2></br>";
				echo "<form action=\"adminUploadLogo.php\" method=\"POST\" enctype=\"multipart/form-data\">";
				echo "<input type=\"file\" name=\"file[]\" multiple /></br></br>";
				echo "<input type=\"submit\" value=\"submit\" name=\"adminLogoUploads\" class=\"uploadLogoSubmitButton\">";
				echo "</form>";
				echo "</div></br>";
				
				echo "<div class=\"adminLogoAddContainer\">";
				echo "<h2 class=\"admin\">Select New Logo</h2></br>";
				echo "<form id=\"adminAddLogoForm\" action=\"adminAddLogo.php\" method=\"POST\">";
				echo "<select name=\"adminAddLogoName\" form=\"adminAddLogoForm\">";
					echo "<option value=\" \">";
					echo "- Select Logo Image -";
							$dirPath = dir("images/logo/");
							$imgArray = array();
							while (($file = $dirPath->read()) !== false)
							{
							   $imgArray[ ] = trim($file);
							}
							$dirPath->close();
							sort($imgArray);
							$c = count($imgArray);
							for($i=0; $i<$c; $i++)
							{
								echo "<option value=\"" . $imgArray[$i] . "\">" . $imgArray[$i] . "\n";
							}
						
				echo "</option>";
				echo "</select>";
				echo "<input type=\"submit\" value=\"add\" name=\"adminLogoAddButton\" class=\"adminLogoAddButton\">";
				echo "</form>";
				echo "</div></br>";
			?>
			
			</br>
		</div>
	</div>
</div>	
</div>
</body>

</html>