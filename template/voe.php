<?php
/*
 * Template Name: VOE
 */

$date = strtotime("+1 day");
$args = array(
	'post_type' => 'post',
	'date_query' => array(
		'day' => date('d', $date),
		'month' => date('m', $date),
		'year' => date('Y', $date)
	),
);

$query = new WP_Query();
do {
	$date = strtotime("-1 day", $date);
	$args['date_query']['day'] = date('d', $date);
	$args['date_query']['month'] = date('m', $date);
	$args['date_query']['year'] = date('Y', $date);
	
	$query->query($args);
	
} while (!$query->have_posts());


$output = array();
while($query->have_posts()) {
	$query->the_post();
	
	$tipo_postagem = get_post_meta($post->ID, 'tipo_postagem', true);
	if(!array_key_exists($tipo_postagem, $output)) {
		$output[$tipo_postagem] = array();
	}
	
	$area_conhecimento = wp_get_post_terms($post->ID, 'area_conhecimento');
	$area_conhecimento_title = 'GERAL';
	if(
			is_array($area_conhecimento) && 
			count($area_conhecimento) > 0) {
		$area_conhecimento_title = $area_conhecimento[0]->name;
	}
	
	if(!array_key_exists($area_conhecimento_title, $output[$tipo_postagem])) {
		$output[$tipo_postagem][$area_conhecimento_title] = array();
	}
	
	$output[$tipo_postagem][$area_conhecimento_title][] = array(
		'title' => get_the_title(),
		'link' => get_the_permalink(),
	);
}

foreach($output as $tipo => $area_arr) {
	echo "<h2>$tipo</h2>";
	
	foreach($area_arr as $area_title => $post_arr) {
		if($area_title !== 'GERAL') {
			echo "<h3>$area_title</h3>";
		}
		
		
		foreach($post_arr as $item) {
			echo "<a href='{$item['link']}'>{$item['title']}</a><br />";
		}
	}
}