<?php 
	$id = get_the_ID();
	$home_video_type = get_post_meta($id, 'home_video_type', true) ? get_post_meta($id, 'home_video_type', true) : '3rdparty';
	$attributes = $home_video_type === 'hosted' ? thb_video_attributes() : array(''); 
?>
<div class="video-container" <?php echo implode( ' ', $attributes ); ?>>
	<?php 
		if ($home_video_type == '3rdparty') {
			do_action('thb_video_embed', get_post_meta($id, 'home_video_url', true));
		}
	?>
</div>