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


//find the target gallery
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
$preceedingOrderNo=$currentOrderNo-1;

//if the target gallery is the first gallery, decrement all gallery order Nos and
//then set first gallery order No to the # of galleries
if($preceedingOrderNo == 0) {
	foreach ($allGalleries as $gallery) {
		$newValue = $gallery->getElementsByTagName("order")->item(0)->nodeValue;
		$newValue--;
		$gallery->getElementsByTagName("order")->item(0)->nodeValue=$newValue;
	
	}
	$targetGalleryNode->getElementsByTagName("order")->item(0)->nodeValue=$numGalleries;
}
else {

//find the preceeding gallery
$galleryNodes = $xpath->query('//gallery[order="'.$preceedingOrderNo.'"]');

//increment the order value of the node found above
foreach ($galleryNodes as $galleryNode) {
	$galleryNode->getElementsByTagName("order")->item(0)->nodeValue=$currentOrderNo;
}

//decrement the order value of the target node
$targetGalleryNode->getElementsByTagName("order")->item(0)->nodeValue=$preceedingOrderNo;
}

//save the XML file
$doc->save("xml/photoGalleries.xml");

	header("Location: admin.php");
?>