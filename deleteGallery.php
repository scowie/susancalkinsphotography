<?php
//get the gallery name
foreach ($_POST as $key=>$val) {
	
	if($val == "DELETE"){
		$targetGalleryID=$key;
	}
	
	else{
		
	}
}

//load the XML document....for using DOM
$doc = new DOMDocument;
$doc->load('xml/photoGalleries.xml');
$xpath = new DOMXPath($doc);


//find the target gallery
$galleries = $xpath->query('//photos/gallery[@id="'.$targetGalleryID.'"]');

//store gallery node
foreach ($galleries as $gallery) {
    $targetGalleryNode = $gallery;
	$targetGalleryName = $targetGalleryNode->getAttribute("name");
}

//find the order# of the gallery to be deleted
$targetGalleryOrderNo = $targetGalleryNode->GetElementsByTagName("order")->item(0)->nodeValue;

//find out how many galleries there are in total
$allGalleries = $xpath->query('//gallery');
$numGalleries = $allGalleries->length;

//if the target gallery is not the last gallery,
//decrement the order # of all the galleries that follow after the target gallery
if($targetGalleryOrderNo<$numGalleries){
	for($i=$targetGalleryOrderNo+1; $i<$numGalleries+1; $i++){
		//find the gallery with the order# == $i
		$gals = $xpath->query('//photos/gallery[order="'.$i.'"]');
		foreach($gals as $gal){
			$galleryToDecrement = $gal;
		}
		//decrement the order #
		$galleryToDecrement->GetElementsByTagName("order")->item(0)->nodeValue=($i-1);
	}	
}

//find the root 
$photos = $xpath->query('//photos');

foreach($photos as $photo) {
	$rootNode = $photo;
}

//remove the gallery from XML
$deletedGallery = $rootNode->removeChild($targetGalleryNode);

//save the XML file
$doc->save("xml/photoGalleries.xml");

//delete all files in the gallery folder
$files = glob('images/'.$targetGalleryName.'/*'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    unlink($file); // delete file
}

//delete the gallery folder from the file system
rmdir('images/'.$targetGalleryName.'');

?>

<script type="text/javascript">
      window.location.href = "admin.php";
</script>