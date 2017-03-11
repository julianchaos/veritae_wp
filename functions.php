<?php

function veritae_theme_enqueue_styles()
{
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
	wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'));
	
	wp_enqueue_style('veritae-style', get_stylesheet_directory_uri() . '/assets/css/style.min.css');
}
add_action('wp_enqueue_scripts', 'veritae_theme_enqueue_styles');