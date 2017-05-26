<?php session_start();
				
				if (!(isset($_SESSION['isVerified']))) {
				
header("Location: passCode.php");
				exit();
}

//get the gallery name $_POST data
$targetGalleryName=$_POST['galleryName'];

//load the XML document....for using DOM
$doc = new DOMDocument;
$doc->load('xml/photoGalleries.xml');
$xpath = new DOMXPath($doc);


//find the target gallery (result is a list)
$galleries = $xpath->query('//photos/gallery[@name="'.$targetGalleryName.'"]');

//store gallery node
foreach ($galleries as $gallery) {
    $targetGalleryNode = $gallery;
}

//find the # of galleries
$allGalleries = $xpath->query('//gallery');
$numGalleries = $allGalleries->length;

//get the order value of the targetted gallery
$currentOrderNo=$targetGalleryNode->getElementsByTagName("order")->item(0)->nodeValue;
$followingOrderNo=$currentOrderNo+1;



//if the target gallery is the last gallery, increment all gallery order Nos and
//then set target gallery order No to 1
if($followingOrderNo > $numGalleries) {
	foreach ($allGalleries as $gallery) {
		$newValue = $gallery->getElementsByTagName("order")->item(0)->nodeValue;
		$newValue++;
		$gallery->getElementsByTagName("order")->item(0)->nodeValue=$newValue;
	
	}
	$targetGalleryNode->getElementsByTagName("order")->item(0)->nodeValue=1;
}
else {

//find the following gallery
$galleryNodes = $xpath->query('//gallery[order="'.$followingOrderNo.'"]');

//decrement the order No value of the node found above
foreach ($galleryNodes as $galleryNode) {
	$galleryNode->getElementsByTagName("order")->item(0)->nodeValue=$currentOrderNo;
}

//increment the order No value of the target node
$targetGalleryNode->getElementsByTagName("order")->item(0)->nodeValue=$followingOrderNo;
}


//save the XML file
$doc->save("xml/photoGalleries.xml");


//after the move up button is pressed the user will see the updated admin page
	header("Location: admin.php");
?>