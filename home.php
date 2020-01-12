<!DOCTYPE html>
<html>
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
	<script type="text/javascript" src="js/jssor.slider.mini.js"></script>
	<script type="text/javascript" src="js/jquery.lazy.min.js"></script>
	
	<script type="text/javascript" src="js/scp.js"></script>
	<script type="text/javascript" src="js/changeSize.js"></script> 
	
<script type="text/javascript">
		jQuery(document).ready(function ($) {
        var _SlideshowTransitions = [
		{$Duration:1200,$Opacity:2}
		];
        var options = {
            $DragOrientation: 3,
            $AutoPlay: true,
            $SlideDuration: 1500,
			$PauseOnHover: 0,
			$ArrowKeyNavigation: true,
            $AutoPlayInterval: 2500,
			$FillMode: 0,
			$Loop: 1,
            $SlideshowOptions: {                         //Options which specifies enable slideshow or not
                $Class: $JssorSlideshowRunner$,          //Class to create instance of slideshow
                $Transitions: _SlideshowTransitions,     //Transitions to play slide, see jssor slideshow transition builder
                $TransitionsOrder: 1,                    //The way to choose transition to play slide, 1 Sequence, 0 Random
                $ShowLink: 2,                            //0 After Slideshow, 2 Always
                $ContentMode: false                      //Whether to trait content as slide, otherwise trait an image as slide
            }
		};
        var jssor_slider1 = new $JssorSlider$('landscape_container', options);
		
		//responsive code begin
        //you can remove responsive code if you don't want the slider scales
        //while window resizes
        function ScaleSlider() {
            var parentWidth = $('#landscape_container').parent().width();
            if (parentWidth) {
                jssor_slider1.$ScaleWidth(parentWidth);
            }
            else
                window.setTimeout(ScaleSlider, 30);
        }
        //Scale slider after document ready
        ScaleSlider();
                                        
        //Scale slider while window load/resize/orientationchange.
        $(window).bind("load", ScaleSlider);
        $(window).bind("resize", ScaleSlider);
        $(window).bind("orientationchange", ScaleSlider);
        //responsive code end
		
		});
</script>

</head>

<body>
		
	<?php
		//FIRST GET THE FIRST IMAGE OF EACH GALLERY
		//FOR PRE-LOADING
		////////////////////////////
		///////////////////////////
		//find the galleries (result is an array)
		$galleryNodes = $xpath->query('//photos/gallery');
		
		$galleryArray = array_values(dnl2array($galleryNodes));
		
		$sortedGalleryArray = array();
		
		//sort the array of galleries by order
		foreach ($galleryArray as $gallery) {
					
					$orders=$gallery->getElementsByTagName('order');
					foreach($orders as $order){
						$orderID = $order->nodeValue;
					}
					$sortedGalleryArray[$orderID] = $gallery;
		}
		ksort($sortedGalleryArray);
		
		echo "<div style=\"display:none;\">";
		
		foreach ($sortedGalleryArray as $gallery) {
			$portfolioName=$gallery->getAttribute('name');
			$imageFilePath="images/$portfolioName/";
			$firstImage = $xpath->query('//photos/gallery[@name="'.$portfolioName.'"]/image[position="1"]');
			foreach($firstImage as $fI){
				$firstImageName=$fI->getAttribute('filename');
			}
			$firstImageBaseName=substr($firstImageName, 0, strpos($firstImageName, '.'));
			$imageExtension=substr($firstImageName,strpos($firstImageName, '.'));//including the dot
			$imageFullName=$firstImageBaseName.$imageExtension;
			
			$imageThumbName1=$firstImageBaseName."_".$imageExtension;
			$imageThumbName2=$firstImageBaseName."_b".$imageExtension;
			$imageThumbName3=$firstImageBaseName."_m".$imageExtension;
			$imageThumbName4=$firstImageBaseName."_n".$imageExtension;
			$imageThumbName5=$firstImageBaseName."_t".$imageExtension;
			$imageThumbName6=$firstImageBaseName."_z".$imageExtension;
		
			$fullImagePath=$imageFilePath.$imageFullName;
								
			$thumbImagePath1=$imageFilePath.$imageThumbName1;
			$thumbImagePath2=$imageFilePath.$imageThumbName2;
			$thumbImagePath3=$imageFilePath.$imageThumbName3;
			$thumbImagePath4=$imageFilePath.$imageThumbName4;
			$thumbImagePath5=$imageFilePath.$imageThumbName5;
			$thumbImagePath6=$imageFilePath.$imageThumbName6;
		
			echo "<div><img u=\"image\" src=\" \" data-src=\"$fullImagePath\" height=\"100\"; width=\"100\"; class=\"lazy\" /></div>";	
			echo "<div><img u=\"image\" src=\" \" data-src=\"$thumbImagePath1\" height=\"100\"; width=\"100\"; class=\"lazy\" /></div>";

			/*
			echo "<div><img u=\"image\" src=\" \" data-src=\"$thumbImagePath2\" height=\"100\"; width=\"100\"; class=\"lazy\" /></div>";	
			echo "<div><img u=\"image\" src=\" \" data-src=\"$thumbImagePath3\" height=\"100\"; width=\"100\"; class=\"lazy\" /></div>";	
			echo "<div><img u=\"image\" src=\" \" data-src=\"$thumbImagePath4\" height=\"100\"; width=\"100\"; class=\"lazy\" /></div>";	
			echo "<div><img u=\"image\" src=\" \" data-src=\"$thumbImagePath5\" height=\"100\"; width=\"100\"; class=\"lazy\" /></div>";	
			echo "<div><img u=\"image\" src=\" \" data-src=\"$thumbImagePath6\" height=\"100\"; width=\"100\"; class=\"lazy\" /></div>";
			*/
		}
		
		echo "</div>";
		
	?>
		
	<div id="horizon">
	<div class="wrapBorder" style="background:white; " >
	<div class="wrap" style="background:white">
	
		<?php
					include("topContainer.php");
					
		?>
	
		<div id="landscape_container" >
		
		<!-- Slides Container -->
		<div id="slides" u="slides" >
	
		<?php
			
			if($galleriesExist){
			
			//access the slideshow images
			$images = $xpath->query('//photos/gallery/image[slideshow="1"]');
			
			//convert DOM node list to array
			$imageArray = array_values(dnl2array($images));
			
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
			
			foreach ($sortedImageArray as $image) {
				$imageFullName=$image->getAttribute('filename');
				$imageID = $image->getAttribute('id');
				$imageBaseName=substr($imageFullName, 0, strpos($imageFullName, '.'));
				$imageExtension=substr($imageFullName,strpos($imageFullName, '.'));//including the dot
				$galleryName=$image->parentNode->getAttribute('name');
				$imageFilePath="images/$galleryName/";
				$fullImagePath=$imageFilePath.$imageBaseName.$imageExtension;	
				echo "<div><img u=\"image\" src=\"$fullImagePath\" /></div>";	
				}
			}
		?>
		<!-- Trigger for responsive design -->
		<!-- <script>jssor_slider1_starter('landscape_container');</script> -->
		
		</div>
		
	</div>	
		<footer></footer> 
	</div> <!--   end of wrapper -->
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