<?php session_start();
				
				if (!(isset($_SESSION['isVerified']))) {
				
header("Location: passCode.php");
				exit();
}

if(isset($_POST['title'])){
	$imageTitle = $_POST['title'];
}
else{
	$imageTitle = "";
}

if(isset($_POST['description'])){
	$description = $_POST['description'];
}
else{
	$description = "";
}

if(isset($_POST['imgID'])){
	$targetImageID = $_POST['imgID'];
}
else{
	$targetImageID = 0;
}

if(isset($_POST['slideshow'])){
	$slideshow = $_POST['slideshow'];
}
else{
	$slideshow = "no";
}

if(isset($_POST['frontpage'])){
	$frontPage = $_POST['frontpage'];
}
else{
	$frontPage = "no";
}

//load the XML document....for using DOM
$doc = new DOMDocument;
$doc->load('xml/photoGalleries.xml');
$xpath = new DOMXPath($doc);

//find the target image (result is a list)
$imageNodes = $xpath->query('//image[@id="'.$targetImageID.'"]');

//add code to set the image title and description
foreach ($imageNodes as $imageNode) {
	$image = $imageNode;
}

$image->getElementsByTagName("title")->item(0)->nodeValue=$imageTitle;
$image->getElementsByTagName("description")->item(0)->nodeValue=$description;

if($slideshow == "yes") {
	//find the next slide show position
	$slideShowImages = $xpath->query('//photos/gallery/image[slideshow="1"]');
	$numSlideShowImages = $slideShowImages->length;
	$nextSlideShowPosition = ($numSlideShowImages + 1);
	$image->getElementsByTagName("slideshow")->item(0)->nodeValue=true;
	$image->getElementsByTagName("slideShowPosition")->item(0)->nodeValue=$nextSlideShowPosition;
}

if($frontPage == "yes") {
	//find the current front page photo if one exists
	$currentFrontPageImages = $xpath->query('//photos/gallery/image[frontPage="1"]');
	//remove current image from background
	foreach ($currentFrontPageImages as $fpi){
		$fpi->getElementsByTagName("frontPage")->item(0)->nodeValue=false;
	}
	//set the new image as background
	$image->getElementsByTagName("frontPage")->item(0)->nodeValue=true;
}

//save the XML file
$doc->save("xml/photoGalleries.xml");


//after the save button is pressed the user will see the updated edit page
	
	session_start();
	$_SESSION['last_post'] = $_POST;
	header("Location: edit.php");
	exit();


?>