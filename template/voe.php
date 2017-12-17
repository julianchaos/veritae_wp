<?php
/*
 * Template Name: VOE
 */

get_header('voe') ?>

<form method="get">
	<label>
		A partir de <small>(inclusive)</small>
		<input type="date" name="after" required />
	</label>
	
	<label>
		Até <small>(inclusive)</small>
		<input type="date" name="before" required />
	</label>
		
	<input type="submit" value="Filtrar" class="btn-filter" />
</form>

<?php

if(filter_has_var(INPUT_GET, 'start')) {
	$start = filter_input(INPUT_GET, 'start');
	$end = filter_input(INPUT_GET, 'end');
	
	$args = array(
		'date_query' => array(
			'after' => $start,
			'before' => $end,
			'inclusive' => true
		)
	);
	$query = new WP_Query($args);
}
else {
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
	
}



$output = array();
if($query->have_posts()) {
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
}
else {
	echo "<h1>Não existem postagens no período definido</h1>";
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

get_footer('voe');