<?php 
function addImageDirect($imageToAdd, $galleryID){
			//load the XML document....for using DOM
			$doc = new DOMDocument;
			$doc->load('xml/photoGalleries.xml');
			$xpath = new DOMXPath($doc);

			//get largest existing id number.  they will be listed in numerical order
			$existingImageIDs = $xpath->query('//photos/imageIDs/idNum[last()]');
			if($existingImageIDs->length==0){
				$nextImageID = 1;
			}
			else{
				foreach($existingImageIDs as $lastAssignedImageID) {
					$nextImageID = ($lastAssignedImageID->nodeValue)+1;
				} 
			}

			//set the new image to the last position
			$images = $xpath->query('//photos/gallery[@id="'.$galleryID.'"]/image');
			$numImages = $images->length;
			$nextPosition = ($numImages +1);

			//create the new image  node
			$newImageNode = $doc->createElement('image', '');
				$newImageNode->setAttribute('id',$nextImageID);
				$newImageNode->setAttribute('filename', $imageToAdd);
				$newTitle = $doc->createElement('title', 'Title');
				$newPosition = $doc->createElement('position', $nextPosition);
				$newSlideShowPosition = $doc->createElement('slideShowPosition', "");
				$newDescription = $doc->createElement('description', 'Enter description...');
				$newSlideShow = $doc->createElement('slideshow', false);
				$newFrontPage = $doc->createElement('frontPage', false);
				$newImageNode->appendChild($newTitle);
				$newImageNode->appendChild($newPosition);
				$newImageNode->appendChild($newDescription);
				$newImageNode->appendChild($newSlideShow);
				$newImageNode->appendChild($newSlideShowPosition);
				$newImageNode->appendChild($newFrontPage);

			//find the target gallery
				$galleries = $xpath->query('//photos/gallery[@id="'.$galleryID.'"]');

			//store gallery node
				foreach ($galleries as $gallery) {
					$targetGalleryNode = $gallery;
					$targetGalleryName = $targetGalleryNode->getAttribute('name');
				}
				
			//add the new node
				$targetGalleryNode->appendChild($newImageNode);

			//add assigned id to the list of id's used so it won't be double used
			$newIDNode = $doc->createElement('idNum', $nextImageID);
			$doc->getElementsByTagName("imageIDs")->item(0)->appendChild($newIDNode);

			//save the XML file
			$doc->save("xml/photoGalleries.xml");

			//create thumbnails of the selected file and move them into the correct gallery folder
			$fullSizeImageNamePath = 'images/available/'.$imageToAdd.'';
			$imageSize = getimagesize($fullSizeImageNamePath);
			$imageWidth = $imageSize[0];
			$imageHeight = $imageSize[1];

			$BaseName=substr($imageToAdd, 0, strpos($imageToAdd, '.'));
			$Extension=substr($imageToAdd,strpos($imageToAdd, '.'));//including the dot
			
			/*
			'lt100': '',  // e.g. Flickr uses '_t'
			'lt240': '',  // e.g. Flickr uses '_m' 
			'lt320': '',  // e.g. Flickr uses '_n' 
			'lt500': '',  // e.g. Flickr uses '_' 
			'lt640': '',  // e.g. Flickr uses '_z'
			'lt1024': '', // e.g. Flickr uses '_b'
			*/
			
			$ThumbIdentifier1='_t';
			$ThumbIdentifier2='_m';
			$ThumbIdentifier3='_n';
			$ThumbIdentifier4='_';
			$ThumbIdentifier5='_z';
			$ThumbIdentifier6='_b';
			
			$imageThumbNamePath1 = 'images/'.$targetGalleryName.'/'.$BaseName.$ThumbIdentifier1.$Extension.'';
			$imageThumbNamePath2 = 'images/'.$targetGalleryName.'/'.$BaseName.$ThumbIdentifier2.$Extension.'';
			$imageThumbNamePath3 = 'images/'.$targetGalleryName.'/'.$BaseName.$ThumbIdentifier3.$Extension.'';
			$imageThumbNamePath4 = 'images/'.$targetGalleryName.'/'.$BaseName.$ThumbIdentifier4.$Extension.'';
			$imageThumbNamePath5 = 'images/'.$targetGalleryName.'/'.$BaseName.$ThumbIdentifier5.$Extension.'';
			$imageThumbNamePath6 = 'images/'.$targetGalleryName.'/'.$BaseName.$ThumbIdentifier6.$Extension.'';
			
			if($Extension=='.jpg'|| $Extension=='.JPG' || $Extension=='.jpeg'){
				$fullSizeImage = imagecreatefromjpeg($fullSizeImageNamePath);
                                 imageinterlace($fullSizeImage, true);
			}
			else if($Extension=='.png'){
				$fullSizeImage = imagecreatefrompng($fullSizeImageNamePath);
			}
			else if($Extension=='.gif'){
				$fullSizeImage = imagecreatefromgif($fullSizeImageNamePath);
			}
			
			//resizing and saving the thumbnail
			$scaleFactor1 = ($imageWidth + $imageHeight)/($imageWidth*($imageHeight/50));
				if($scaleFactor1 > 1){$scaleFactor1 = 1;}
			$scaleFactor2 = ($imageWidth + $imageHeight)/($imageWidth*($imageHeight/100));
				if($scaleFactor2 > 1){$scaleFactor2 = 1;}
			$scaleFactor3 = ($imageWidth + $imageHeight)/($imageWidth*($imageHeight/150));
				if($scaleFactor3 > 1){$scaleFactor3 = 1;}
			$scaleFactor4 = ($imageWidth + $imageHeight)/($imageWidth*($imageHeight/200));
				if($scaleFactor4 > 1){$scaleFactor4 = 1;}
			$scaleFactor5 = ($imageWidth + $imageHeight)/($imageWidth*($imageHeight/300));
				if($scaleFactor5 > 1){$scaleFactor5 = 1;}
			$scaleFactor6 = ($imageWidth + $imageHeight)/($imageWidth*($imageHeight/450));
				if($scaleFactor6 > 1){$scaleFactor6 = 1;}
			
			$newWidth1 = $imageWidth*$scaleFactor1;
			$newWidth2 = $imageWidth*$scaleFactor2;
			$newWidth3 = $imageWidth*$scaleFactor3;
			$newWidth4 = $imageWidth*$scaleFactor4;
			$newWidth5 = $imageWidth*$scaleFactor5;
			$newWidth6 = $imageWidth*$scaleFactor6;
			
			$newHeight1 = $imageHeight*$scaleFactor1;
			$newHeight2 = $imageHeight*$scaleFactor2;
			$newHeight3 = $imageHeight*$scaleFactor3;
			$newHeight4 = $imageHeight*$scaleFactor4;
			$newHeight5 = $imageHeight*$scaleFactor5;
			$newHeight6 = $imageHeight*$scaleFactor6;

			$newImage1 = imagecreatetruecolor($newWidth1, $newHeight1);
			$newImage2 = imagecreatetruecolor($newWidth2, $newHeight2);
			$newImage3 = imagecreatetruecolor($newWidth3, $newHeight3);
			$newImage4 = imagecreatetruecolor($newWidth4, $newHeight4);
			$newImage5 = imagecreatetruecolor($newWidth5, $newHeight5);
			$newImage6 = imagecreatetruecolor($newWidth6, $newHeight6);

			imagecopyresampled($newImage1, $fullSizeImage, 0, 0, 0, 0, $newWidth1, $newHeight1, $imageWidth, $imageHeight);
			imagecopyresampled($newImage2, $fullSizeImage, 0, 0, 0, 0, $newWidth2, $newHeight2, $imageWidth, $imageHeight);
			imagecopyresampled($newImage3, $fullSizeImage, 0, 0, 0, 0, $newWidth3, $newHeight3, $imageWidth, $imageHeight);
			imagecopyresampled($newImage4, $fullSizeImage, 0, 0, 0, 0, $newWidth4, $newHeight4, $imageWidth, $imageHeight);
			imagecopyresampled($newImage5, $fullSizeImage, 0, 0, 0, 0, $newWidth5, $newHeight5, $imageWidth, $imageHeight);
			imagecopyresampled($newImage6, $fullSizeImage, 0, 0, 0, 0, $newWidth6, $newHeight6, $imageWidth, $imageHeight);
			
			if($Extension=='.jpg'|| $Extension=='.JPG' || $Extension=='.jpeg'){
				imagejpeg($newImage1, $imageThumbNamePath1,100);
				imagejpeg($newImage2, $imageThumbNamePath2,100);
				imagejpeg($newImage3, $imageThumbNamePath3,100);
				imagejpeg($newImage4, $imageThumbNamePath4,100);
				imagejpeg($newImage5, $imageThumbNamePath5,100);
				imagejpeg($newImage6, $imageThumbNamePath6,100);    
			}
			else if($Extension=='.png'){
				imagepng($newImage1, $imageThumbNamePath1);
				imagepng($newImage2, $imageThumbNamePath2);
				imagepng($newImage3, $imageThumbNamePath3);
				imagepng($newImage4, $imageThumbNamePath4);
				imagepng($newImage5, $imageThumbNamePath5);
				imagepng($newImage6, $imageThumbNamePath6);
			}
			else if($Extension=='.gif'){
				imagegif($newImage1, $imageThumbNamePath1);
				imagegif($newImage2, $imageThumbNamePath2);
				imagegif($newImage3, $imageThumbNamePath3);
				imagegif($newImage4, $imageThumbNamePath4);
				imagegif($newImage5, $imageThumbNamePath5);
				imagegif($newImage6, $imageThumbNamePath6);
			}

			//move the selected full size file from "available" folder to the correct gallery folder
			rename('images/available/'.$imageToAdd.'', 'images/'.$targetGalleryName.'/'.$imageToAdd.'');
}
?>