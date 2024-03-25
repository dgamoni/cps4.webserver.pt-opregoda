<?php
/*
Template Name: About
*/
?>
<?php get_header(); ?>
<?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
<?php 
	$id = get_the_ID();
	$about_layout = get_post_meta($id, 'about_layout', true) ? get_post_meta($id, 'about_layout', true) : 'style1';
	get_template_part( 'inc/templates/about/'.$about_layout );
?>
<?php endwhile; else : endif; ?>
<?php get_footer(); ?>