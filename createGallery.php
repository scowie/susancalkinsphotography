<?php 

//get the name for the new Gallery
$newGalleryName = $_POST['newGalleryName'];

if(strlen($newGalleryName) > 0) {
	//load the XML document....for using DOM
	$doc = new DOMDocument;
	$doc->load('xml/photoGalleries.xml');
	$xpath = new DOMXPath($doc);

	//get largest existing id number.  they will be listed in numerical order
	$existingGalleryIDs = $xpath->query('//photos/galleryIDs/idNum[last()]');
	if($existingGalleryIDs->length==0){
		$nextGalleryID = 1;
	}
	else{
	foreach($existingGalleryIDs as $lastAssignedGalleryID) {
		$nextGalleryID = ($lastAssignedGalleryID->nodeValue)+1;
	}
	} 

	//get the number of existing galleries 
	$existingGalleries = $xpath->query('//gallery');
	$numExistingGalleries = $existingGalleries->length;
	$newGalleryOrderNo = ++$numExistingGalleries;

	//create a node

	$gallery = $doc->createElement('gallery','');
	$gallery->setAttribute('name',$newGalleryName);
	$gallery->setAttribute('id',$nextGalleryID);
	$order = $doc->createElement('order', $newGalleryOrderNo);
	$gallery->appendChild($order);
	$photos = $xpath->query('//photos');

	foreach($photos as $photo){
		$root = $photo;
	}

	$root->appendChild($gallery);

	//add assigned id to the list of id's used so it won't be double used
	$newIDNode = $doc->createElement('idNum', $nextGalleryID);
	$doc->getElementsByTagName("galleryIDs")->item(0)->appendChild($newIDNode);

	//save the XML file
	$doc->save("xml/photoGalleries.xml");

	//create the folder for the gallery's images
	mkdir('images/'.$newGalleryName.'');
}

?>

<script type="text/javascript">
      window.location.href = "admin.php";
</script>
