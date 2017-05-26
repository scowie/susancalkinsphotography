<?php session_start();
				
				if (!(isset($_SESSION['isVerified']))) {
				
header("Location: passCode.php");
				exit();
}

require_once('addImageDirect.php');
//get the filename of the image to be added
$imageToAdd=$_POST['addImageFileName'];

//get the gallery ID then name
$galleryID = $_POST['galleryID'];


addImageDirect($imageToAdd, $galleryID);


	$_SESSION['last_post'] = $_POST;
	header("Location: edit.php");
	exit();
?>