

function isMobile() {
if(window.screen.width < 500 || window.screen.height < 500){
return true;
}
else{
	return false;
}
}


//lazy image loading for better load time	
$(document).ready(function() {
   $("img.lazy").lazy({
delay: 2,
});
});		
	

function confirmDeleteImage() {
	if(confirm("Are you sure you want to delete the image?")==true){
		 document.forms["deleteImage"].submit();
	}
	else{
		return false;
	}
}

function confirmRemoveImage() {
	if(confirm("Are you sure you want to remove the image from the slideshow?")==true){
		 document.forms["removeImage"].submit();
	}
	else{
		return false;
	}
}




function confirmDeleteGallery() {
	if(confirm("Are you sure you want to delete the gallery and all images?")==true){
		 document.forms["deleteGallery"].submit();
	}
	else{
		return false;
	}
}