<?php session_start();
				
				if (!(isset($_SESSION['isVerified']))) {
				
header("Location: passCode.php");
				exit();
}

//get the copyright info from the $_POST data
$copyrightInfo = $_POST['copyright'];

//load the XML document....for using DOM
$doc = new DOMDocument;
$doc->load('xml/photoGalleries.xml');
$xpath = new DOMXPath($doc);

//get the node and set the value
$copyrightInfoNodes = $xpath->query('//copyright');

foreach ($copyrightInfoNodes as $copyrightInfoNode) {
	$copyrightInfoNode->nodeValue=$copyrightInfo;
}

//save the XML file
$doc->save("xml/photoGalleries.xml");


//after the save button is pressed the user will see the updated edit page
	header("Location: admin.php");

?>