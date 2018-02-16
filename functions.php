<?php require_once 'assets/inc/advanced-custom-fields/init.php' ?>
<?php require_once 'assets/inc/cpt.php' ?>
<?php require_once 'assets/inc/cpf.php' ?>
<?php

function veritae_theme_enqueue_styles() {
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
	wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'));
	
	wp_enqueue_style('veritae-style', get_stylesheet_directory_uri() . '/assets/css/style.min.css', array('nucleus-framework', 'nucleus-theme'));
}
add_action('wp_enqueue_scripts', 'veritae_theme_enqueue_styles');

function veritae_theme_enqueue_scripts() {
	wp_enqueue_script('veritae-main', get_stylesheet_directory_uri() . '/assets/js/main.js', array('jquery'));
	
	if(is_home()) {
		wp_enqueue_script('font-awesome', 'https://use.fontawesome.com/55e074484c.js');
	}
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
	
	if ( filter_has_var(INPUT_GET, 'voe') && $query->is_main_query() ){
		$submitted_voe = filter_input(INPUT_GET, 'voe');

		switch ($submitted_voe) {
			case 'anual':
				$datequery = array(
					'year' => date('Y'),
				);
				break;
			case 'mensal':
				$datequery = array(
					'year' => date('Y'),
					'month' => date('m'),
				);
				break;
			case 'semanal': 
				$weekday = date('w');
				
				$basetime = strtotime("-$weekday day");
				$datequery = array(
					'after' => array(
						'year' => date('Y', $basetime),
						'month' => date('m', $basetime),
						'day' => date('d', $basetime)
					),
					'inclusive' => true
				);
				break;
			case 'ontem':
				$basetime = strtotime("-1 day");
				$datequery = array(
					'year' => date('Y', $basetime),
					'month' => date('m', $basetime),
					'day' => date('d', $basetime)
				);
				break;
			case 'diario':
			default:
				$datequery = array(
					'year' => date('Y'),
					'month' => date('m'),
					'day' => date('d')
				);
				break;
		}

		$query->set('date_query', $datequery);
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

function veritae_voe_edicoes($atts) {
	$mode = "diario";
	
	if(array_key_exists('mode', $atts)) {
		$mode = $atts['mode'];
	}
	
	switch ($mode) {
		case 'anual':
		case 'mensal':
		case 'semanal':
		case 'ontem':
		case 'diario':
		default:
			break;
	}
	
	$args = array(
		'date_query' => array(
			
		)
	);
	$query = new WP_Query($args);
}
add_shortcode( 'veritae-voe-edicoes', 'veritae_voe_edicoes' );

function filter_taxonomy_body_class($wp_classes, $extra_classes) {
	$new_classes = $wp_classes;

	if(is_archive()) {
		$exclude = array('home');
		$new_classes = array_diff($wp_classes, $exclude);
	}

	return array_merge($new_classes, array($extra_classes));
}
add_filter( 'body_class', 'filter_taxonomy_body_class', 10, 2 );