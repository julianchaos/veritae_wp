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

function veritae_theme_filter_post($query) {
	if( filter_has_var(INPUT_GET, 'tipo') && $query->is_main_query() ) {
		veritae_theme_filter_post_tipo($query);
	}
	
	if ( filter_has_var(INPUT_GET, 'area-conhecimento') && $query->is_main_query() ){
		veritae_theme_filter_post_area_conhecimento($query);
	}
	
	if ( filter_has_var(INPUT_GET, 'voe') && $query->is_main_query() ){
		veritae_theme_filter_post_voe($query);
	}
}
function veritae_theme_filter_post_tipo($query) {
	$submitted_tipo = explode(',', filter_input(INPUT_GET, 'tipo'));
	
	$tipo_arr = [];
	foreach($submitted_tipo as $tipo_slug) {
		$term = get_term_by('slug', $tipo_slug, 'tipo_postagem');
		$tipo_arr[] = $term->term_id;
	}
	
	$query->set('meta_query', array(
				array(
					'key' => 'tipo_postagem',
					'value' => $tipo_arr,
					'compare' => 'IN'
				)
			));
}
function veritae_theme_filter_post_area_conhecimento($query) {
	$submitted_area = explode(',', filter_input(INPUT_GET, 'area-conhecimento'));
	
	$area_arr = [];
	foreach($submitted_area as $area_slug) {
		$term = get_term_by('slug', $area_slug, 'area_conhecimento');
		$area_arr[] = serialize(array($term->term_id));
	}
	
	$meta_query = array( 
		'relation' => 'OR',
		array(
			'key' => 'area_conhecimento',
			'value' => $area_arr,
			'compare' => 'IN'
		));
	
	if(in_array('correlatos', $submitted_area)) {
		$remove = array(
				'previdencia-social',
				'trabalho',
				'seguranca-e-saude-no-trabalho',
			);
		
		$remove_arr = [];
		foreach($remove as $area_slug) {
			$term = get_term_by('slug', $area_slug, 'area_conhecimento');
			$remove_arr[] = serialize(array($term->term_id));
		}
		
		$meta_query[] = array(
				'key' => 'area_conhecimento',
				'value' => $remove_arr,
				'compare' => 'NOT IN'
			);
	}
	
	$query->set('meta_query', $meta_query);
}
function veritae_theme_filter_post_voe($query) {
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
add_action('pre_get_posts','veritae_theme_filter_post');

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

function veritae_pesquisa_atos_legais() {
	$args = array(
		'taxonomy' => 'tipo_ato',
		'hide_empty' => false,
	);
	$terms = get_terms( $args );
	
	echo "<div class='veritae-pesquisa-atos-legais'>";
	foreach($terms as $term) {
		if ($term->count > 0) {
			$link = get_term_link($term);
			echo "<a href='$link'>{$term->name}</a>";		
		} else {
			echo "<span class='empty'>{$term->name}</span>";
		}
		
	}
	echo "</div>";
}
add_shortcode( 'veritae-pesquisa-atos-legais', 'veritae_pesquisa_atos_legais');