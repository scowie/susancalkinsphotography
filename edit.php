<?php session_start(); ?>
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

	<?php
		if (empty($_POST) && isset($_SESSION['last_post'])) {
			  $post = $_SESSION['last_post'];
			  unset($_SESSION['last_post']);
			}
			else $post = $_POST;	
	?>
	
	<div id="horizon">
	<div class="wrapBorder">
	<div class="wrap">
	
		<?php
				
				include("topContainer.php");
				
				//access the galleries
					$galleries = $xpath->query('//photos/gallery');

					//store gallery node
					foreach ($galleries as $gallery) {
						$galleryName=$gallery->getAttribute('name');
						$galleryID=$gallery->getAttribute('id');
						if (isset($post[$galleryID])) {
				
				//display the main title
				echo "<div class=\"pageTitle\"><h1>$galleryName</h1><div id=\"admin_link\"><a href=\"admin.php\" class=\"admin\"></a></div></div>";
				
				
				echo "<div class=\"imageAddContainer\">";
				echo "<h2 class=\"edit\">Upload & Add New Images</h2></br>";
				echo "<form action=\"uploadFiles.php\" method=\"POST\" enctype=\"multipart/form-data\">";
					echo "<input type=\"file\" name=\"file[]\" multiple /></br></br>";
					echo "<input type=\"submit\" value=\"submit\" name=\"uploads\"><input type=\"hidden\" value=\"$galleryID\" name=\"$galleryID\"><input type=\"hidden\" value=\"$galleryID\" name=\"galleryID\">";
				echo "</form>";
				echo "</div></br>";
				echo "<div class=\"imageAddContainer\">";
				echo "<h2 class=\"edit\">Add To Gallery From Existing Images</h2></br>";
				echo "<form id=\"addImageForm\" action=\"addImage.php\" method=\"POST\">";
				echo "<select class=\"addImageForm\" name=\"addImageFileName\" form=\"addImageForm\">";
					echo "<option value=\" \">";
					echo "- Select Image -";
							$dirPath = dir("images/available/");
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
				echo "<input type=\"submit\" value=\"add\" name=\"imageAddButton\" class=\"addImageButton\"><input type=\"hidden\" value=\"$galleryID\" name=\"$galleryID\"><input type=\"hidden\" value=\"$galleryID\" name=\"galleryID\">";
				echo "</form>";
				echo "</div></br>";
				
					} //end of if statement
				} //end of foreach gallery
				
				
					//access the galleries
					$galleries = $xpath->query('//photos/gallery');

					//store gallery node
					foreach ($galleries as $gallery) {
						$galleryName=$gallery->getAttribute('name');
						$galleryID=$gallery->getAttribute('id');
						if (isset($post[$galleryID])) {
							
							$imageFilePath="images/$galleryName/";
							echo "<div class=\"editGalleryName\">";
							echo "<h2 class=\"edit\" style=\"float:left; margin-right:5px;\">";
							echo "Gallery Name: ";
							echo "</h2>";
							echo "<form action=\"changeGalleryName.php\" method=\"POST\"><input type=\"text\" value='$galleryName' name=\"newGalleryName\" class=\"inlineText\">";
							echo "<input type=\"submit\" value=\"SAVE\" name=\"$galleryName\" class=\"saveGalleryNameButton\">";
							echo "<input type=\"hidden\" value=\"$galleryName\" name=\"previousGalleryName\" ><input type=\"hidden\" value=\"$galleryID\" name=\"$galleryID\" ></form>";
							echo "</div>";
							
							//access the gallery-specific images (result is an array)
							$images = $xpath->query('//photos/gallery[@name="'.$galleryName.'"]/image');
							
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
							
							foreach ($sortedImageArray as $image) {
								$imageFullName=$image->getAttribute('filename');
								$imageID = $image->getAttribute('id');
								$imageBaseName=substr($imageFullName, 0, strpos($imageFullName, '.'));
								$imageExtension=substr($imageFullName,strpos($imageFullName, '.'));//including the dot
								$imageThumbName=$imageBaseName."_t".$imageExtension;
								$fullImagePath=$imageFilePath.$imageThumbName;
								$titles=$image->getElementsByTagName('title');
								foreach($titles as $title){
									$imageTitle=$title->nodeValue;
								}
								$descriptions=$image->getElementsByTagName('description');
								foreach($descriptions as $description){
									$imageDescription=$description->nodeValue;
								}
								$shs=$image->getElementsByTagName('slideshow');
								foreach($shs as $sh){
									$slideshowOn=$sh->nodeValue;
								}
								$fps = $image->getElementsByTagName('frontPage');
								$frontPageOn=false;
								foreach($fps as $fp){
									$frontPageOn=$fp->nodeValue;
								}
								$deleteImageName=$imageFullName;
								
								//IMAGE LIST................////////////
								echo "<div id=\"editImageThumbContainer\">";
								echo "<img src=\"$fullImagePath\" class=\"editImageThumb\" alt=\" \">";
								echo "</div>";
								
								echo "<div class=\"imageList\">";
								echo "<h2 class=\"edit\">";
								echo "File Name: ".$imageFullName;
								echo "</h2>";
								echo "<h2 class=\"edit\" style=\"float:left; margin-right:5px;\">";
								echo "Title: ";
								echo "</h2>";
								//////////////////////////////////     FORM          ////////////////////////////////////
								echo "<form action=\"saveImage.php\" id=\"imageInfo\" method=\"POST\"><input type=\"text\" value='$imageTitle' name=\"title\" class=\"inlineText2\" >";
							
								echo "<div style=\"clear:right\"></div>";
								//slideshow
								if($slideshowOn != 1){
								echo "<h2 class=\"edit\" style=\"float:left; margin-right:5px;\">";
								echo "Add to Slideshow?: ";
								echo "</h2>";
								echo "<input type=\"checkbox\" name=\"slideshow\" value=\"yes\" style=\"float:left;\">Yes";
								echo "<div style=\"clear:both\"></div>";
								}
								//frontPage image
								if($frontPageOn != 1){
								echo "<h2 class=\"edit\" style=\"float:left; margin-right:5px;\">";
								echo "Make Front Page Background?: ";
								echo "</h2>";
								echo "<input type=\"checkbox\" name=\"frontpage\" value=\"yes\" style=\"float:left;\">Yes";
								echo "<div style=\"clear:both\"></div>";
								}
								
								//description
								echo "<h2 class=\"edit\" style=\"float:left; margin-right:5px;\">";
								echo "Description: ";
								echo "</h2>";
								
								//text area 
								echo "<textarea name=\"description\" class=\"textArea\" >";
								echo $imageDescription;
								echo "</textarea>";
								
								// save image button
								echo "<input type=\"submit\" value=\"$imageID\" name=\"imgID\" class=\"saveImageButton\">";
								echo "<input type=\"hidden\" value=\"$galleryName\" name=\"$galleryName\" >";
								echo "<input type=\"hidden\" value=\"$galleryID\" name=\"$galleryID\" >";
								echo "</form>";
								/////////////////////////////////////////////////////////////////////////////////////////
								
								// delete image button
								echo "<form id=\"deleteImage\" action=\"deleteImage.php\" method=\"POST\" onsubmit=\"return confirmDeleteImage();\"><input type=\"submit\" value=\"$imageID\" name=\"imageID\" class=\"deleteImageButton\" ><input type=\"hidden\" value=\"$galleryID\" name=\"galleryID\" ><input type=\"hidden\" value=\"$galleryID\" name=\"$galleryID\" ></form>";
								
								// move image up in order
								echo "<form action=\"moveImageUp.php\" method=\"POST\"><input type=\"submit\" value=\"$imageID\" name=\"imageID\" class=\"moveImageUpButton\"><input type=\"hidden\" value=\"$galleryID\" name=\"$galleryID\" ><input type=\"hidden\" value=\"$galleryID\" name=\"galleryID\" ></form>";
								
								// move image down in order
								echo "<form action=\"moveImageDown.php\" method=\"POST\"><input type=\"submit\" value=\"$imageID\" name=\"imageID\" class=\"moveImageDownButton\"><input type=\"hidden\" value=\"$galleryID\" name=\"$galleryID\" ><input type=\"hidden\" value=\"$galleryID\" name=\"galleryID\" ></form>";
								
								echo "<div style=\"clear:both\"></div></br>";
								
								//end of the imageList div container
								echo "</div>";
								
								}//end of what to do for each image
							
						}//end of what to do if particular galleryies $_POST is set
					}//end of what to do for each gallery 
				?>
		</div>
	</div>
	</div>

</body>

</html>