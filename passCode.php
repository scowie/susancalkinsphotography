<?php session_start(); ?>

<!doctype html>
<html lang="en">
<head>
	<?php
		include("titleMetaFonts.php");
		include("DOMandFunctions.php");
	?>
	
	<link rel="stylesheet" href="css/scp.css">
	<script type="text/javascript">
		document.write('<style type="text/css">body{display:none}</style>');
	</script>
	
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.lazy.min.js"></script>
	<script type="text/javascript" src="js/scp.js"></script>
	<script type="text/javascript" src="js/changeSize.js"></script>
	
</head>

<body>
	<div id="horizon">
	<div class="wrapBorder">
	<div class="wrap">
		<?php
				include("topContainer.php");
		?>
		
		<div class="pageTitle"><h1>ADMINISTRATIVE CONTROL PANEL</h1><h4 class="admin">(This page is only available to the website administrator)</h4></div>
		
		<h2 class="admin" style="font-size:14px; margin-bottom:-5px;">Enter Password:</h2></br>
		<form action="verify.php" method="POST">
		<input type="password" name="password" value="">
		<input type="submit" name="submit" value="Submit">
		</form>
		
		<?php
			if (isset($_SESSION['isVerified']) && $_SESSION['isVerified'] != true){
				echo "<h3 class=\"admin\">Incorrect Password</h3>";
				unset ($_SESSION['isVerified']);
			}
			else{
			}
		?>
		
		</div>
	</div>
	</div>
</body>

</html>