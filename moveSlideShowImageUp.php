<?php session_start();
				
				if (!(isset($_SESSION['isVerified']))) {
				
header("Location: passCode.php");
				exit();
}

//load the XML document....for using DOM
$doc = new DOMDocument;
$doc->load('xml/photoGalleries.xml');
$xpath = new DOMXPath($doc);

//get the image to be moved
$imageToMove=$_POST['imageID'];

//find the target image
$filenames = $xpath->query('//photos/gallery/image[@id="'.$imageToMove.'"]');

//store image node
//get the file name so the deleted image can be moved in the file system
foreach ($filenames as $filename) {
    $imageNodeToMove = $filename;
	$fileNameText = $filename->getAttribute('filename');
}

//find the slide show position# of the image to be removed
$targetImagePositionNo = $imageNodeToMove->GetElementsByTagName("slideShowPosition")->item(0)->nodeValue;

//find out how many images there are in total in the slide show
$allSlideShowImages = $xpath->query('//photos/gallery/image[slideshow="1"]');
$numImages = $allSlideShowImages->length;

//find the target image (result is a list)
$imageNodes = $xpath->query('//photos/gallery/image[@id="'.$imageToMove.'"]');

//get the position value of the targetted image and store
foreach ($imageNodes as $imageNode) {
	$targetNode = $imageNode;
	$positions=$imageNode->getElementsByTagName('slideShowPosition');
	foreach($positions as $position){
		$currentPosition = $position->nodeValue;
		$preceedingPosition = $currentPosition-1;
	}
}

//if the target image is the first image, decrement all image positions and
//then set first image position to the # of images
if($preceedingPosition == 0) {
	foreach ($allSlideShowImages as $image) {
		$newValue = $image->getElementsByTagName("slideShowPosition")->item(0)->nodeValue;
		$newValue--;
		$image->getElementsByTagName("slideShowPosition")->item(0)->nodeValue=$newValue;
	
	}
	$targetNode->getElementsByTagName("slideShowPosition")->item(0)->nodeValue=$numImages;
}
else {

//find the preceeding image
$imageNodes = $xpath->query('//photos/gallery/image[slideShowPosition ="'.$preceedingPosition.'"]');

//increment the position value of the node found above
foreach ($imageNodes as $imageNode) {
	$imageNode->getElementsByTagName("slideShowPosition")->item(0)->nodeValue=$currentPosition;
}

//decrement the position value of the target node
$targetNode->getElementsByTagName("slideShowPosition")->item(0)->nodeValue=$preceedingPosition;
}

//save the XML file
$doc->save("xml/photoGalleries.xml");

?>

<script type="text/javascript">
      window.location.href = "admin.php";
</script>