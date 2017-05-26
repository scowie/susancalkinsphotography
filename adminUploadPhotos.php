<?php

require_once('sessionCheck.php');


if(isset($_POST['adminPhotoUploads'])){



									for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
									$name = $_FILES['file']['name'][$i];

									$extension = substr($name, strpos($name, '.') + 1);

									$tmp_name = $_FILES['file']['tmp_name'][$i];
									$error = $_FILES['file']['error'][$i];

									if (isset ($name)) {
										if (!empty($name) /*&& ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' ||$extension == 'JPG'||
										$extension == 'tif' || $extension == 'gif' || $extension == 'bmp')*/) {

										$location = 'images/self/';
										
											if  (move_uploaded_file($tmp_name, $location.$name)){
												
												$imageSize = getimagesize($location.$name);
												$imageWidth = $imageSize[0];
												$imageHeight = $imageSize[1];
												
												if($extension=='jpg'||$extension=='jpeg'||$extension=='JPG'){
												$oldImage = imagecreatefromjpeg($location.$name);
												}
												else if($extension=='png'){
												$oldImage = imagecreatefrompng($location.$name);
												}
												
												//resizing and saving for main image
												$newSize = ($imageWidth + $imageHeight)/($imageWidth*($imageHeight/400));
												$newWidth = $imageWidth*$newSize;
												$newHeight = $imageHeight*$newSize;
												
												$newImage = imagecreatetruecolor($newWidth, $newHeight);
												
												imagecopyresized($newImage, $oldImage, 0, 0, 0, 0, $newWidth, $newHeight, $imageWidth, $imageHeight);
												$newImageName = $location.$name;
												
												if($extension=='jpg'||$extension=='jpeg'){
												imagejpeg($newImage, $newImageName);
												}
												else if($extension=='png'){
												imagepng($newImage, $newImageName);
												}
										
										} else {
										  echo 'please choose a file';
										  }
											  
										}
									}
								}
}
							
	header("Location: admin.php");								
?>