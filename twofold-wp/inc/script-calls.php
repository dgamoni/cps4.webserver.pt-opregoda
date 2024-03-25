<?php
/* De-register Contact Form 7 styles */
add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );

// Main Styles
function thb_main_styles() {
	global $post;
	
	// Enqueue 
	wp_enqueue_style("thb-fa", 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css', null, null);
	wp_enqueue_style('thb-app', Thb_Theme_Admin::$thb_theme_directory_uri . '/assets/css/app.css', null, esc_attr(Thb_Theme_Admin::$thb_theme_version));
	
	if ( $_SERVER['HTTP_HOST'] !== 'twofold.fuelthemes.net') {
		wp_enqueue_style('style', get_stylesheet_uri(), null, null);	
	}
	wp_enqueue_style( 'thb-google-fonts', thb_google_webfont() );
	wp_add_inline_style( 'thb-app', thb_selection() );
	
	if ( is_page_template( 'template-contact.php' ) ) {
		if ( function_exists( 'wpcf7_enqueue_styles' ) ) {
			wpcf7_enqueue_styles();
		}
	}
}

add_action('wp_enqueue_scripts', 'thb_main_styles');


// Main Scripts
function thb_register_js() {
	
	if (!is_admin()) {
		global $post;
		$thb_api_key = ot_get_option('map_api_key');
		
		// Register 
		wp_enqueue_script('thb-vendor', Thb_Theme_Admin::$thb_theme_directory_uri . 'assets/js/vendor.min.js', array('jquery'), esc_attr(Thb_Theme_Admin::$thb_theme_version), TRUE);
		wp_enqueue_script('thb-app', Thb_Theme_Admin::$thb_theme_directory_uri . 'assets/js/app.min.js', array('jquery', 'thb-vendor', 'underscore'), esc_attr(Thb_Theme_Admin::$thb_theme_version), TRUE);

		// Enqueue
		if ( is_page_template( 'template-contact.php' ) ) {
			wp_enqueue_script('gmapdep', 'https://maps.google.com/maps/api/js?key='.esc_attr($thb_api_key).'', false, null, false);
			
			if ( function_exists( 'wpcf7_enqueue_scripts' ) ) {
				wpcf7_enqueue_scripts();
			}
		}
		if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1) ) {
			wp_enqueue_script('comment-reply');
		}
		
		// Typekit 
		if ($typekit_id = ot_get_option('typekit_id')) {
			wp_enqueue_script('thb-typekit', 'https://use.typekit.net/'.$typekit_id.'.js', array(), NULL, FALSE );
			wp_add_inline_script( 'thb-typekit', 'try{Typekit.load({ async: true });}catch(e){}' );
		}
		
		wp_enqueue_script('thb-vendor');
		wp_enqueue_script('underscore');
		wp_enqueue_script('thb-app');
		wp_localize_script( 'thb-app', 'themeajax', array( 
			'url' => admin_url( 'admin-ajax.php' ),
			'settings' => array (
				'lightbox_autoplay_duration' => ot_get_option('lightbox_autoplay_duration', '5'),
				'lightbox_thumbnails_default' => ot_get_option('lightbox_thumbnails_default', 'on'),
				'map_style' => ot_get_option('map_style'),
				'right_click' => ot_get_option('right_click','on')
			),
			'l10n' => array (
				'loading' => esc_html__("Loading ...", 'twofold'),
				'nomore' => esc_html__("Nothing left to load", 'twofold'),
				'added' => esc_html__("Added To Cart", 'twofold'),
				'added_svg' => thb_load_template_part('assets/svg/arrows_check.svg')
			)
		) );
	}
}
add_action('wp_enqueue_scripts', 'thb_register_js');

/* WooCommerce */
add_filter( 'woocommerce_enqueue_styles', '__return_false' );
/* WooCommerce */
if(thb_wc_supported()) {
	function thb_woocommerce_scripts() {
		wp_dequeue_script( 'prettyPhoto' );
		wp_dequeue_script( 'prettyPhoto-init' );
	}
	add_action('wp_enqueue_scripts', 'thb_woocommerce_scripts');
}