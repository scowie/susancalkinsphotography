<?php session_start(); 

//get the password from $_POST data
$enteredPassword=$_POST['password'];

//load the XML document....for using DOM
$doc = new DOMDocument;
$doc->load('xml/photoGalleries.xml');
$xpath = new DOMXPath($doc);


//find the password node
$passwords = $xpath->query('//adminPassword');


foreach ($passwords as $password) {
    $realPassword = $password->nodeValue;
}

if($enteredPassword==$realPassword){
	//set $_SESSION variable to true
	$_SESSION['isVerified']=true;
	header("Location: admin.php");
}
else{
	//set $_SESSION variable to false
	$_SESSION['isVerified']=false;
}

?>

<script type="text/javascript">
      window.location.href = "passCode.php";
</script>