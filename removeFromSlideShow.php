<?php session_start();
				
				if (!(isset($_SESSION['isVerified']))) {
				
header("Location: passCode.php");
				exit();
}

$prevPost = null;

if(isset($_SESSION['prevPost'])){
$prevPost = $_SESSION['prevPost'];
}

if($prevPost == $_POST){
	header ("Location:index.php");
}

//load the XML document....for using DOM
$doc = new DOMDocument;
$doc->load('xml/photoGalleries.xml');
$xpath = new DOMXPath($doc);

//get the filename of the image
$imageToRemove=$_POST['imageID'];

//find the target image
$filenames = $xpath->query('//photos/gallery/image[@id="'.$imageToRemove.'"]');

//store image node
//get the file name so the deleted image can be moved in the file system
foreach ($filenames as $filename) {
    $imageNodeToRemove = $filename;
	$fileNameText = $filename->getAttribute('filename');
}

//find the slide show position# of the image to be removed
$targetImagePositionNo = $imageNodeToRemove->GetElementsByTagName("slideShowPosition")->item(0)->nodeValue;

//find out how many images there are in total in the slide show
$allSlideShowImages = $xpath->query('//photos/gallery/image[slideshow="1"]');
$numImages = $allSlideShowImages->length;

//if the target image is not the last image,
//decrement the position # of all the images that follow after the target image
if($targetImagePositionNo<$numImages){
	for($i=$targetImagePositionNo+1; $i<$numImages+1; $i++){
		//find the image with the position# == $i
		$images = $xpath->query('//photos/gallery/image[slideShowPosition="'.$i.'"]');
		foreach($images as $image){
			$imageToDecrement = $image;
		}
		//decrement the position #
		$imageToDecrement->GetElementsByTagName("slideShowPosition")->item(0)->nodeValue=($i-1);
	}	
}

//remove the image from the slide show
$imageNodeToRemove->GetElementsByTagName("slideShowPosition")->item(0)->nodeValue="";
$imageNodeToRemove->GetElementsByTagName("slideshow")->item(0)->nodeValue=false;

//save the XML file
$doc->save("xml/photoGalleries.xml");

?>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.lazy.min.js"></script>
<script type="text/javascript" src="js/scp.js"></script>
<script type="text/javascript">
      window.location.href = "admin.php";
</script>