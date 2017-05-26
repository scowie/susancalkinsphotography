<?php session_start();
				
				if (!(isset($_SESSION['isVerified']))) {
				
header("Location: passCode.php");
				exit();
}

//get the photo info from the $_POST data
$photo=$_POST['adminAddPhotoName'];

//load the XML document....for using DOM
$doc = new DOMDocument;
$doc->load('xml/photoGalleries.xml');
$xpath = new DOMXPath($doc);

//find the root node
$nodes = $xpath->query('//photos');

foreach ($nodes as $node) {
	$rootNode = $node;
}

$rootNode->getElementsByTagName("susanPhoto")->item(0)->nodeValue=$photo;

//save the XML file
$doc->save("xml/photoGalleries.xml");



	header("Location: admin.php");
	
?>