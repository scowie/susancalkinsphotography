<?php session_start();
				
			if (!(isset($_SESSION['isVerified']))) {
				header("Location: passCode.php");
			 }
			else if (isset($_SESSION['isVerified']) && $_SESSION['isVerified'] != true){
				header("Location: passCode.php");
			}
			   
			?>