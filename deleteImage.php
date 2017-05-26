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

//get the gallery ID then name
$galleryID = $_POST['galleryID'];
$galleries = $xpath->query('//gallery[@id="'.$galleryID.'"]');
foreach($galleries as $gallery){
	$targetGalleryName=$gallery->getAttribute('name');
}

foreach($_POST as $key => $value) {
	echo $key, $value;
}

//get the filename of the image to be added
$imageToDelete=$_POST['imageID'];
//find the target image
$filenames = $xpath->query('//photos/gallery[@name="'.$targetGalleryName.'"]/image[@id="'.$imageToDelete.'"]');

//find the target gallery (result is an array)
$galleries = $xpath->query('//photos/gallery[@name="'.$targetGalleryName.'"]');

//store gallery node
foreach ($galleries as $gallery) {
    $targetGalleryNode = $gallery;
}

//store image node
//get the file name so the deleted image can be moved in the file system
foreach ($filenames as $filename) {
    $imageNodeToDelete = $filename;
	$fileNameText = $filename->getAttribute('filename');
}

//find the position# of the image to be deleted
$targetImagePositionNo = $imageNodeToDelete->GetElementsByTagName("position")->item(0)->nodeValue;

//find out how many images there are in total in the gallery
$allImages = $xpath->query('//photos/gallery[@name="'.$targetGalleryName.'"]/image');
$numImages = $allImages->length;

//if the target image is not the last image,
//decrement the position # of all the images that follow after the target image
if($targetImagePositionNo<$numImages){
	for($i=$targetImagePositionNo+1; $i<$numImages+1; $i++){
		//find the image with the position# == $i
		$images = $xpath->query('//photos/gallery[@name="'.$targetGalleryName.'"]/image[position="'.$i.'"]');
		foreach($images as $image){
			$imageToDecrement = $image;
		}
		//decrement the position #
		$imageToDecrement->GetElementsByTagName("position")->item(0)->nodeValue=($i-1);
	}	
}

//remove the image from XML
$deletedImage = $targetGalleryNode->removeChild($imageNodeToDelete);

//save the XML file
$doc->save("xml/photoGalleries.xml");

//move the selected file from the gallery back to "available" folder
rename('images/'.$targetGalleryName.'/'.$fileNameText.'', 'images/available/'.$fileNameText.'');

//delete the thumbnail of the image
$BaseName=substr($fileNameText, 0, strpos($fileNameText, '.'));
$Extension=substr($fileNameText,strpos($fileNameText, '.'));//including the dot

$ThumbIdentifier1='_t';
$ThumbIdentifier2='_m';
$ThumbIdentifier3='_n';
$ThumbIdentifier4='_';
$ThumbIdentifier5='_z';
$ThumbIdentifier6='_b';

$imageThumbNamePath1 = 'images/'.$targetGalleryName.'/'.$BaseName.$ThumbIdentifier1.$Extension.'';
unlink($imageThumbNamePath1);
$imageThumbNamePath2 = 'images/'.$targetGalleryName.'/'.$BaseName.$ThumbIdentifier2.$Extension.'';
unlink($imageThumbNamePath2);
$imageThumbNamePath3 = 'images/'.$targetGalleryName.'/'.$BaseName.$ThumbIdentifier3.$Extension.'';
unlink($imageThumbNamePath3);
$imageThumbNamePath4 = 'images/'.$targetGalleryName.'/'.$BaseName.$ThumbIdentifier4.$Extension.'';
unlink($imageThumbNamePath4);
$imageThumbNamePath5 = 'images/'.$targetGalleryName.'/'.$BaseName.$ThumbIdentifier5.$Extension.'';
unlink($imageThumbNamePath5);
$imageThumbNamePath6 = 'images/'.$targetGalleryName.'/'.$BaseName.$ThumbIdentifier6.$Extension.'';
unlink($imageThumbNamePath6);

	session_start();
	$_SESSION['last_post'] = $_POST;
	$_SESSION['prevPost'] = $_POST;
	header("Location: edit.php");
	exit();

?>
<script type="text/javascript" src="js/scp.js"></script>
