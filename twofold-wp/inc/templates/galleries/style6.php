<?php
	$id = get_the_ID();
	$page_padding = get_post_meta($id, 'page_padding', true);
	$photo_proof = get_post_meta($id, 'photo_proof', true);
	$album_photos_array = explode(',', get_post_meta($id, 'gallery_photos', true));
?>
	<?php if ($page_padding == 'on') { ?><div class="page-padding"><?php } ?>
	<div class="side_padding">
		<div class="masonry isotope-grid row expanded gallery-style6 <?php if ($photo_proof == 'on') { echo 'photo-proof-enabled'; } ?> gallery-style6">
		<?php
			if ($album_photos_array) {
				$i = 0;
				foreach ($album_photos_array as $photo) {
					$rand = rand(0, 1000);
					$full_url = wp_get_attachment_image_src($photo, 'full');
					$image_url = wp_get_attachment_image_src($photo, 'twofold-2');
					$photo_post = get_post($photo);
					$exif = thb_get_exif_data($full_url[0]);
					$image_width = $image_url[1] / 2;
					$padding = (220 / $image_width) * 100;
					$proof_class = $photo_proof == 'on' ? thb_proof_class($photo) : '';
					?>
					<div class="item columns">
						<figure class="no-padding" style="width: <?php echo esc_attr($image_width); ?>px; padding-bottom: <?php echo esc_attr($padding); ?>%;">
							<?php do_action('thb_render_photo', $photo_proof, $proof_class, $photo, $image_url, $full_url, $rand, false); ?>
							<div id="photo-caption-<?php echo esc_attr($rand); ?>" style="display: none;">
							  <div class="row image-information no-padding expanded">
							  	<div class="small-12 medium-6 columns image-caption">
							  		<?php echo apply_filters('the_excerpt', $photo_post->post_excerpt); ?>
							  	</div>
							  	<?php do_action('thb_render_buynow', $photo); ?>
							  	<div class="small-12 medium-6 columns image-exif">
							  		<ul>
							  		<?php foreach ($exif as $value) { ?>
							  			<li> <span><?php echo esc_attr($value["title"]); ?></span>
							  					<?php echo esc_attr($value["data"]); ?>
							  			</li>
							  		<?php } ?>
							  		</ul>
							  	</div>
							  </div>
							</div>
						</figure>
					</div>
					<?php
					$i++;
				}
			}
		?>
		</div>
	</div>
	<?php if ($page_padding == 'on') { ?></div><?php } ?>