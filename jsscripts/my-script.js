// JavaScript Document
jQuery(document).on('click', '#upload_no_image_button', function(){ 
		formfield = jQuery('#default_no_image').attr('name');
		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		return false;
 });

jQuery(document).ready(function() {
	jQuery('#upload_no_image_button').on("click",function() {
		formfield = jQuery('#default_no_image').attr('name');
		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		return false;
	});
	window.send_to_editor = function(html) {
		
		imgurl = jQuery('img',html).attr('src');
		jQuery('#default_no_image').val(imgurl);
		tb_remove();
	}
});

