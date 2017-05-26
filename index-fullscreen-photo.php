<!doctype html>
<html lang="en">
<head>
	<?php
		include("titleMetaFonts.php");
		include("DOMandFunctions.php");
	?>
	<link rel="stylesheet" href="css/scp.css">
	
	<script type="text/javascript">

		(function(i){var e=/iPhone/i,n=/iPod/i,o=/iPad/i,t=/(?=.*\bAndroid\b)(?=.*\bMobile\b)/i,r=/Android/i,d=/BlackBerry/i,s=/Opera Mini/i,a=/IEMobile/i,b=/(?=.*\bFirefox\b)(?=.*\bMobile\b)/i,h=RegExp("(?:Nexus 7|BNTV250|Kindle Fire|Silk|GT-P1000)","i"),c=function(i,e){return i.test(e)},l=function(i){var l=i||navigator.userAgent;this.apple={phone:c(e,l),ipod:c(n,l),tablet:c(o,l),device:c(e,l)||c(n,l)||c(o,l)},this.android={phone:c(t,l),tablet:!c(t,l)&&c(r,l),device:c(t,l)||c(r,l)},this.other={blackberry:c(d,l),opera:c(s,l),windows:c(a,l),firefox:c(b,l),device:c(d,l)||c(s,l)||c(a,l)||c(b,l)},this.seven_inch=c(h,l),this.any=this.apple.device||this.android.device||this.other.device||this.seven_inch},v=i.isMobile=new l;v.Class=l})(window);
		

		(function () {
            var MOBILE_SITE = 'mobile/index.php', // site to redirect to
                NO_REDIRECT = 'noredirect'; // cookie to prevent redirect

            // I only want to redirect iPhones, Android phones and a handful of 7" devices
            if (isMobile.apple.phone || isMobile.android.phone) {

                // Only redirect if the user didn't previously choose
                // to explicitly view the full site. This is validated
                // by checking if a "noredirect" cookie exists
                if ( document.cookie.indexOf(NO_REDIRECT) === -1 ) {
                    window.location.href = MOBILE_SITE;
                }
            }
        })();

	</script>
	
	<script type="text/javascript" src="js/scp.js"></script>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/changeSize.js"></script>
	<script type="text/javascript" src="js/jquery.lazy.min.js"></script>
	
</head>

<body>
		
		<?php
					$myfile = fopen("slideshowphotos.php", "w");
					
					//FIRST GET ALL SLIDESHOW IMAGES FOR PRELOADING
					////////////////////////////
					///////////////////////////
					$allSlideShowImages = $xpath->query('//photos/gallery/image[slideshow="1"]');
					//convert DOM node list to array
					$imageArray = array_values(dnl2array($allSlideShowImages));
					
					//define new array for images to be sorted
					$sortedImageArray = array();
					
					//sort the array of images by position
					foreach ($imageArray as $image) {
								
								$slideShowPositions=$image->getElementsByTagName('slideShowPosition');
								foreach($slideShowPositions as $slideShowPosition){
									$slideShowPositionID = $slideShowPosition->nodeValue;
								}
								$sortedImageArray[$slideShowPositionID] = $image;
					}
					ksort($sortedImageArray);
					
					echo "<div style=\"display:none\">";
					
					foreach ($sortedImageArray as $image) {
					
						$imageFullName=$image->getAttribute('filename');
						$imageID = $image->getAttribute('id');
						$imageBaseName=substr($imageFullName, 0, strpos($imageFullName, '.'));
						$imageExtension=substr($imageFullName,strpos($imageFullName, '.'));//including the dot
						$imageThumbName=$imageBaseName."_t".$imageExtension;
						$galleryName=$image->parentNode->getAttribute('name');
						$imageFilePath="images/$galleryName/";
						$fullImagePath=$imageFilePath.$imageFullName;
						$thumbImagePath=$imageFilePath.$imageThumbName;
						$titles=$image->getElementsByTagName('title');
						foreach($titles as $title){
							$imageTitle=$title->nodeValue;
						}
					
					echo "<div><img u=\"image\" src=\" \" data-src=\"$fullImagePath\" height=\"100\"; width=\"100\"; class=\"lazy\" /></div>";	
					
					fwrite($myfile, "<div><img u=\"image\" src=\" \" data-src=\"$fullImagePath\" height=\"100\"; width=\"100\"; class=\"lazy\" /></div>");
					
					} // end of echo loop
					
					fclose($myfile);
					
					echo "</div>";
				?>	
					
		<div id="fullscreen" >
		
		<?php
		//get the background image
		$frontPageImages = $xpath->query('//photos/gallery/image[frontPage="1"]');
		$frontPageImageFullPath="";
		foreach($frontPageImages as $fpi){
			$frontPageImageFileName = $fpi->getAttribute('filename');
			$galleryName=$fpi->parentNode->getAttribute('name');
			$imageFilePath="images/$galleryName/";
			$frontPageImageFullPath=$imageFilePath.$frontPageImageFileName;
		}
		
		?>
		
		<!-- HERE IS THE MAIN IMAGE  -->
		 <a href="home.php" style="display:block; position:fixed; width:100%; height:100%; 
		 z-index:2; background-image: url('<?php echo "$frontPageImageFullPath" ?>'); 
		 background-repeat: no-repeat; background-size: contain; background-position: center; 
		 cursor:pointer;" ></a>
		 
		
			<div id="horizon">
			<div class="wrapIndex" style="z-index:3">
				<?php 

					//find the logo node info
					$logoNodes = $xpath->query('//logo');
					
					foreach($logoNodes as $logoNode){
						$logoName=$logoNode->nodeValue;
					}
				 ?>
			<a id="mainEntry" href="home.php"><img src="images/logo/logoToryIndex.png" id="landing_logo_image" alt=" "></a>

			</div>
			</div>
			
		</div>  
			
	
<script type="text/javascript">

$(window).bind("load", function() {
    var timeout = setTimeout(function() {
        $("img.lazy").each(function(){
			$(this).attr('src', $(this).attr('data-src'));
		})
	}, 100);
});

</script>

</body>
</html>