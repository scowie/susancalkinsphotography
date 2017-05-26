<script type="text/javascript">
		jQuery(document).ready(function ($) {
        var _SlideshowTransitions = [
		{}
		];
        var options = {
            $DragOrientation: 3,
            $AutoPlay: true,
            $SlideDuration: 1500,
			$PauseOnHover: 0,
			$ArrowKeyNavigation: true,
            $AutoPlayInterval: 1,
			$FillMode: 0,
            $SlideshowOptions: {                         //Options which specifies enable slideshow or not
                $Class: $JssorSlideshowRunner$,          //Class to create instance of slideshow
                $Transitions: _SlideshowTransitions,     //Transitions to play slide, see jssor slideshow transition builder
                $TransitionsOrder: 1,                    //The way to choose transition to play slide, 1 Sequence, 0 Random
                $ShowLink: 2,                            //0 After Slideshow, 2 Always
                $ContentMode: false                      //Whether to trait content as slide, otherwise trait an image as slide
            }
		};
        var jssor_slider1 = new $JssorSlider$('index_container', options);
		
		
		});
</script>