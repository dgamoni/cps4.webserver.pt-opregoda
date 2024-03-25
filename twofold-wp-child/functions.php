<?php

define('CORE_PATH', get_stylesheet_directory() . '/core');
define('CORE_URL', get_stylesheet_directory_uri()  . '/core');


$dirs = array(
    CORE_PATH . '/shortcodes/',
    CORE_PATH . '/functions/',
);
foreach ($dirs as $dir) {
    $other_inits = array();
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (false !== ($file = readdir($dh))) {
                if ($file != '.' && $file != '..' && stristr($file, '.php') !== false) {
                    list($nam, $ext) = explode('.', $file);
                    if ($ext == 'php')
                        $other_inits[] = $file;
                }
            }
            closedir($dh);
        }
    }
    asort($other_inits);
    foreach ($other_inits as $other_init) {
        if (file_exists($dir . $other_init))
            include_once $dir . $other_init;
    }
}


// Before VC Init
add_action( 'vc_before_init', 'vc_before_init_actions' );
function vc_before_init_actions() {
    if( function_exists('vc_set_shortcodes_templates_dir') ){ 
        vc_set_shortcodes_templates_dir( get_stylesheet_directory() . '/vc-elements' );
    }
}

function remove_vc_prettyphoto(){
  wp_dequeue_script( 'prettyphoto' );
  wp_deregister_script( 'prettyphoto' );
  wp_dequeue_style( 'prettyphoto' );
  wp_deregister_style( 'prettyphoto' );
}
add_action( 'wp_enqueue_scripts', 'remove_vc_prettyphoto', 9999 );

add_action('wp_footer', 'add_custom_css');
function add_custom_css() {
	global $current_user;
	?>
	<script>


		jQuery(document).ready(function($) {
			var slides = $('.ms-section');
			var slidelink = slides.eq(0).data('slidelink');
			var slidetitle = slides.eq(0).data('slidetitle');
			//console.log(slidelink);
			console.log(slidetitle);
			if(slidetitle) {
				$('#slide_title').text(slidetitle);
			} 
			if(slidelink) {
				$('.multiscroll').removeClass('pointer');
				$('#slide_linkk').attr('href', slidelink);
			} 
			

            $('.add_link').each(function(index, el) {
               var add_link = $(el).find('h1 a').attr('href');
                console.log(add_link); 
                $(el).attr('data-href', add_link);
            });
            
            $(".add_link").click(function() {

                window.location = $(this).attr('data-href');
            });

		});



	</script>
	<style>
    .add_link:hover {
        cursor: pointer;
    }
        .vc_gitem-is-link {
            cursor: default;
        }
        a.vc_gitem-link:hover {
            cursor: default;
        }
        .page-id-12 .vc_pageable-slide-wrapper {
        	    margin-bottom: -450px;
        }
        .page-id-435 .vc_pageable-slide-wrapper {
                margin-bottom: -450px;
        }
        @media screen and (min-width: 1347px) {
                    .page-id-12 .vc_pageable-slide-wrapper {
                    	    margin-bottom: -542px;
                    }
        
            }
	</style>
	<?php
} 