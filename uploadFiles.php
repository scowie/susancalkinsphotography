<?php require_once('addImageDirect.php');

//get the galleryID
$galleryID = $_POST['galleryID'];

if(isset($_POST['uploads'])){



									for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
									$name = $_FILES['file']['name'][$i];

									//$extension = substr($name, strpos($name, '.') + 1);

									$tmp_name = $_FILES['file']['tmp_name'][$i];
									$error = $_FILES['file']['error'][$i];

									if (isset ($name)) {
										if (!empty($name) /*&& ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'JPG' || $extension == 'png' || 
										$extension == 'tif' || $extension == 'gif' || $extension == 'bmp')*/) {

										$location = 'images/available/';
										
										if  (move_uploaded_file($tmp_name, $location.$name)){
											
											$imageSize = getimagesize($location.$name);
											$imageWidth = $imageSize[0];
											$imageHeight = $imageSize[1];
											
											$oldImage = imagecreatefromjpeg($location.$name);
														imageinterlace($oldImage, true);
											
											
											//resizing and saving for main image
											$scaleFactor = ($imageWidth + $imageHeight)/($imageWidth*($imageHeight/600));
											//do not up-size an image
											if($scaleFactor > 1){
												$scaleFactor = 1;
											}
											
											
											$newWidth = $imageWidth*$scaleFactor;
											$newHeight = $imageHeight*$scaleFactor;
											
											$newImage = imagecreatetruecolor($newWidth, $newHeight);
											
											imagecopyresampled($newImage, $oldImage, 0, 0, 0, 0, $newWidth, $newHeight, $imageWidth, $imageHeight);
											
											
											$newImageName = $location.$name;
											imagejpeg($newImage, $newImageName, 100);
											
											}
											
											} else {
											  echo 'please choose a file';
											  }
											  
										}
										
										addImageDirect($name, $galleryID);
									}
									
								}
						
?>
<script type="text/javascript">
      window.location.href = "admin.php";
</script>


