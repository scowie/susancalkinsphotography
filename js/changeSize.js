function changeSize() {
		
		var wrapHeight = (Math.max(document.documentElement.clientHeight, window.innerHeight || 0))-5;
			if(wrapHeight>740){
				wrapHeight=740;
			}
		var wrapWidth = wrapHeight*1.148;
		var wrapCssMarginLeftRight = -1*(wrapWidth/2);
		var wrapCssTop = -1*(wrapHeight/2);
		
		var wrapExtra = 0.10322*wrapWidth;
		var wrapBorderHeight = wrapHeight;
		var wrapBorderWidth = wrapWidth+wrapExtra;
		var wrapBorderCssTop = wrapCssTop;
		var wrapBorderCssMarginLeftRight = wrapCssMarginLeftRight-(wrapExtra/2);
		
		var font20 = 0.0296*wrapHeight; // for .pageTitle h1
		var font17 = 0.0252*wrapHeight; //for nav menu main items
		var font16 = 0.0237*wrapHeight;	// for h4.portfolioList
		var font14 = 0.0207*wrapHeight; // for nav sub-menu items
		var font12 = 0.018*wrapHeight; // for copyright info
		
		var portfolioCoverButtonHeight = .1481*wrapHeight;
		var portfolioCoverButtonWidth = .1935*wrapWidth;

		$('.wrap').css({
			'height': wrapHeight + 'px',
			'width': wrapWidth + 'px',
			'margin-left': wrapCssMarginLeftRight + 'px',
			'margin-right': wrapCssMarginLeftRight + 'px',
			});
		
		$('.wrapBorder').css({
			'height': wrapBorderHeight + 'px',
			'width': wrapBorderWidth + 'px',
			'margin-left': wrapBorderCssMarginLeftRight + 'px',
			'margin-right': wrapBorderCssMarginLeftRight + 'px',
			'top': wrapBorderCssTop + 'px',
			});
		
		$('ul#navigation li').css({
			'font-size': font17 + 'px',
			});		
		
		$('ul#navigation ul li a').css({
			'font-size': font14 + 'px',
			});		
			
		$('ul#navigation ul li input').css({
			'font-size': font14 + 'px',
			});		
		
		$('.pageTitle h1').css({
			'font-size': font20 + 'px',
			});

		$('.pageTitleC h1').css({
			'font-size': font14 + 'px',
		});		
		
		$('h4.portfolioList').css({
			'font-size': font16 + 'px',
			});		
		
		$('p.about').css({
			'font-size': font16 + 'px',
			});		
		
		$('p.contact').css({
			'font-size': font16 + 'px',
			});		
		
		$('p.copyright').css({
			'font-size': font12 + 'px',
			});		
		
		
		$('.portfolioCoverButton').css({
			'height': portfolioCoverButtonHeight + 'px',
			'width' : portfolioCoverButtonWidth + 'px',
			});		
		
		$('body').css({
			'display' : 'inline',
			});
		
		
		} // end changeSize
		
		
		// make sure everything resizes correctly after window changes
		$(window).resize(function(){
			changeSize();
			//location.reload(true);
			});
		
		
		$(document).ready(function(){
			changeSize();
			});
		
		
		