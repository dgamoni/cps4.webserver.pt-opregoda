<?php 
	$id = get_the_ID();
	$home_slides = get_post_meta($id, 'home_slides', true);
	$home_autoplay = get_post_meta($id, 'home_autoplay', true);
	$home_autoplay_speed = get_post_meta($id, 'home_autoplay_speed', true);
	$total = sizeof($home_slides);
	
	$home_random = get_post_meta($id, 'home_random', true);
	if ($home_random == 'on') {
		shuffle($home_slides);
	}
?>
<a id="slide_linkk" href="">
  <div class="multiscroll" data-autoplay="<?php echo esc_attr($home_autoplay); ?>" data-autoplay-speed="<?php echo esc_attr($home_autoplay_speed); ?>">
      <div id="slide_title"></div>
      <div class="ms-left">
        <?php if (!$home_slides) { 	?>
        		<div class="ms-section page-padding no-slides">
        			<h2><?php esc_html_e('Please assign slides inside Page Settings', 'thevoux'); ?></h2>
        		</div>
        	<?php
        } else { $i = 1; 
        	foreach ($home_slides as $slide) { ?>
        	<?php $slide_link = $slide['slide_link']; ?>
        	<?php $slide_title = $slide['slide_title']; ?>
            		<?php $full_image = wp_get_attachment_image_src($slide['image'], 'full'); ?>
              	<div class="ms-section" data-color="<?php echo esc_attr($slide['logo_color']); ?>" data-title="<?php echo esc_attr($slide['title']); ?>" data-slidelink="<?php echo $slide_link; ?>" data-slidetitle="<?php echo $slide_title; ?>">
              		<div class="ms-section-inner" style="background-image:url(<?php echo esc_attr($full_image[0]); ?>)"></div>
              	</div>
          <?php $i++; } ?>
        <?php } ?>
      </div>
      <div class="ms-right">
    	 	<?php if ($home_slides) { 	?>
  	      <?php $i = 1; foreach ($home_slides as $slide) { ?>
  	      	<?php
  	      		$full_image = wp_get_attachment_image_src($slide['image'], 'full');
  	      	?>
      	      	<div class="ms-section" data-color="<?php echo esc_attr($slide['logo_color']); ?>" data-title="<?php echo esc_attr($slide['title']); ?>">
      	      		<div class="ms-section-inner" style="background-image:url(<?php echo esc_attr($full_image[0]); ?>)"></div>
      	      	</div>
  	      <?php $i++; } ?>
        <?php } ?>
      </div>
      
  </div>
</a>
<?php if (get_post_meta($id, 'home_pagination', true) !== 'off') { ?>
<div id="multiscroll-nav"></div>
<?php } ?>