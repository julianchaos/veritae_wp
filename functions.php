<?php require_once 'assets/inc/advanced-custom-fields/init.php' ?>
<?php require_once 'assets/inc/cpt.php' ?>
<?php require_once 'assets/inc/cpf.php' ?>
<?php

function veritae_theme_enqueue_styles()
{
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
	wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'));
	
	wp_enqueue_style('veritae-style', get_stylesheet_directory_uri() . '/assets/css/style.min.css');
}
add_action('wp_enqueue_scripts', 'veritae_theme_enqueue_styles');

function my_remove_meta_boxes() {
//	remove_meta_box( 'categorydiv', 'post', 'normal' );
//	remove_meta_box( 'tagsdiv-post_tag', 'post', 'normal' );
	remove_meta_box( 'tagsdiv-area_conhecimento', 'post', 'normal' );
	remove_meta_box( 'tagsdiv-tipo_ato', 'post', 'normal' );
}
add_action( 'admin_menu', 'my_remove_meta_boxes' );

function ev_unregister_taxonomy(){
    register_taxonomy('post_tag', array());
    register_taxonomy('category', array());
	
}
add_action('init', 'ev_unregister_taxonomy');