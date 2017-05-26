<?php session_start();
				
				if (!(isset($_SESSION['isVerified']))) {
				
header("Location: passCode.php");
				exit();
}

//get the phone info from the $_POST data
$phone=$_POST['phoneInfo'];

//get the email info from the $_POST data
$email=$_POST['emailInfo'];

//load the XML document....for using DOM
$doc = new DOMDocument;
$doc->load('xml/photoGalleries.xml');
$xpath = new DOMXPath($doc);

//find the root node
$nodes = $xpath->query('//photos');

foreach ($nodes as $node) {
	$rootNode = $node;
}

$rootNode->getElementsByTagName("phone")->item(0)->nodeValue=$phone;
$rootNode->getElementsByTagName("e-mail")->item(0)->nodeValue=$email;

//save the XML file
$doc->save("xml/photoGalleries.xml");


//after the save button is pressed the user will see the updated edit page
	header("Location: admin.php");

?>