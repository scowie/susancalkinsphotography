<?php session_start();
				
				if (!(isset($_SESSION['isVerified']))) {
				
header("Location: passCode.php");
				exit();
}

//get the previous gallery name and the new gallery name
$targetGalleryName = $_POST['previousGalleryName'];
$newGalleryName = $_POST['newGalleryName'];

//load the XML document....for using DOM
$doc = new DOMDocument;
$doc->load('xml/photoGalleries.xml');
$xpath = new DOMXPath($doc);

//find the target gallery node 
$galleries = $xpath->query('//gallery[@name="'.$targetGalleryName.'"]');

//add code to set the image title and description
foreach ($galleries as $foundGallery) {
	$gallery = $foundGallery;
}

$gallery->setAttribute("name", $newGalleryName);

//save the XML file
$doc->save("xml/photoGalleries.xml");

//rename folder of images to new gallery name
rename('images/'.$targetGalleryName.'', 'images/'.$newGalleryName.'');

	header("Location: admin.php");

?>