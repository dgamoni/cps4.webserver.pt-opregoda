<?php


add_action('wp_footer', 'add_custom_css');
function add_custom_css() {
	global $current_user;
	?>
	<script>
		jQuery(document).ready(function($) {
			var slides = $('.ms-section');
			var slidelink = slides.eq(0).data('slidelink');
			var slidetitle = slides.eq(0).data('slidetitle');
			console.log(slidelink);
			console.log(slidetitle);
			if(slidetitle) {
				$('#slide_title').text(slidetitle);
			} 
			if(slidelink) {
				$('.multiscroll').removeClass('pointer');
				$('#slide_linkk').attr('href', slidelink);
			} 
			
		});

	</script>
	<style>

	</style>
	<?php
} 