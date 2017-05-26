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

//toggle the visible attribute
$visibility = $targetGalleryNode -> getAttribute("visible");

if ($visibility == "false") {
    $targetGalleryNode -> setAttribute('visible', "true");
} else {
    $targetGalleryNode -> setAttribute('visible', "false");
}


//save the XML file
$doc->save("xml/photoGalleries.xml");


//after the move up button is pressed the user will see the updated admin page
	header("Location: admin.php");
?>