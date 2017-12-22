<?php require_once 'assets/inc/advanced-custom-fields/init.php' ?>
<?php require_once 'assets/inc/cpt.php' ?>
<?php require_once 'assets/inc/cpf.php' ?>
<?php

function veritae_theme_enqueue_styles()
{
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
	wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'));
	
	wp_enqueue_style('veritae-style', get_stylesheet_directory_uri() . '/assets/css/style.min.css', array('nucleus-framework', 'nucleus-theme'));
}
add_action('wp_enqueue_scripts', 'veritae_theme_enqueue_styles');

function veritae_theme_enqueue_scripts() {
	wp_enqueue_script('veritae-main', get_stylesheet_directory_uri() . '/assets/js/main.js', array('jquery'));
} 
add_action('wp_enqueue_scripts', 'veritae_theme_enqueue_scripts');

function veritae_theme_remove_meta_boxes() {
	remove_meta_box( 'tagsdiv-area_conhecimento', 'post', 'normal' );
	remove_meta_box( 'tagsdiv-tipo_ato', 'post', 'normal' );
}
add_action( 'admin_menu', 'veritae_theme_remove_meta_boxes' );

function veritae_theme_unregister_taxonomy(){
    register_taxonomy('category', array());
}
add_action('init', 'veritae_theme_unregister_taxonomy');

function veritae_theme_filter_tipo_post($query) {
	if( filter_has_var(INPUT_GET, 'tipo') && $query->is_main_query() ) {
		$submitted_tipo = explode(',', filter_input(INPUT_GET, 'tipo'));
		
		$query->set('meta_query', array(
							array(
								'key' => 'tipo_postagem',
								'value' => $submitted_tipo,
								'compare' => 'IN'
							)
						));
	}
}
add_action('pre_get_posts','veritae_theme_filter_tipo_post');

function veritae_theme_change_post_order($query) {
	if($query->is_main_query()) {
		$args =  array( 'post_date' => 'DESC', 'title' => 'ASC' );
		$query->set( 'orderby', $args );
	}
}
add_action('pre_get_posts','veritae_theme_change_post_order');

function veritae_theme_force_post_zerohour($data, $postarr) {
	$post_date = strtotime($data['post_date']);
	$data['post_date'] = date("Y-m-d 12:00:00", $post_date);
	$data['post_date_gmt'] = date("Y-m-d 12:00:00", $post_date);

	return $data;
}
add_filter( 'wp_insert_post_data' , 'veritae_theme_force_post_zerohour' , '99', 2 );