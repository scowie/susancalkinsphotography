<?php session_start();
				
				if (!(isset($_SESSION['isVerified']))) {
				
header("Location: passCode.php");
				exit();
}

//load the XML document....for using DOM
$doc = new DOMDocument;
$doc->load('xml/photoGalleries.xml');
$xpath = new DOMXPath($doc);

//get the gallery ID then name
$galleryID = $_POST['galleryID'];
$galleries = $xpath->query('//gallery[@id="'.$galleryID.'"]');
foreach($galleries as $gallery){
	$targetGalleryName=$gallery->getAttribute('name');
}

//get the image to be moved
$imageToMove=$_POST['imageID'];


//find the target gallery (result is a list)
$galleries = $xpath->query('//photos/gallery[@name="'.$targetGalleryName.'"]');

//store gallery node
foreach ($galleries as $gallery) {
    $targetGalleryNode = $gallery;
}

//find the # of images in the gallery
$allImages = $xpath->query('//photos/gallery[@name="'.$targetGalleryName.'"]/image');
$numImages = $allImages->length;

//find the target image (result is a list)
$imageNodes = $xpath->query('//photos/gallery[@name="'.$targetGalleryName.'"]/image[@id="'.$imageToMove.'"]');

//get the position value of the targetted image and store as $x

foreach ($imageNodes as $imageNode) {
	$targetNode = $imageNode;
	$positions=$imageNode->getElementsByTagName('position');
	foreach($positions as $position){
		$currentPosition = $position->nodeValue;
		$followingPosition = $currentPosition+1;
	}
}

//if the target image is the last image, increment all image positions and
//then set target image position to 1
if($followingPosition > $numImages) {
	foreach ($allImages as $image) {
		$newValue = $image->getElementsByTagName("position")->item(0)->nodeValue;
		$newValue++;
		$image->getElementsByTagName("position")->item(0)->nodeValue=$newValue;
	
	}
	$targetNode->getElementsByTagName("position")->item(0)->nodeValue=1;
}
else {

//find the following image
$imageNodes = $xpath->query('//photos/gallery[@name="'.$targetGalleryName.'"]/image[position ="'.$followingPosition.'"]');

//decrement the position value of the node found above
foreach ($imageNodes as $imageNode) {
	$imageNode->getElementsByTagName("position")->item(0)->nodeValue=$currentPosition;
}

//increment the position value of the target node
$targetNode->getElementsByTagName("position")->item(0)->nodeValue=$followingPosition;
}


//save the XML file
$doc->save("xml/photoGalleries.xml");


//after the move up button is pressed the user will see the updated edit page
	session_start();
	$_SESSION['last_post'] = $_POST;
	header("Location: edit.php");
	exit();

?>