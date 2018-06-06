<?php
/*
 * Template Name: VOE
 */

$model = "voe";
if(filter_has_var(INPUT_GET, 'action')) {
	header('Content-Type: text/html');
	header('Content-Disposition: attachment; filename="voe.html"');
	
	$model = "voe-download";
}

get_header($model);

if($model === "voe") {
?>

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
}

if(filter_has_var(INPUT_GET, 'after')) {
	$start = filter_input(INPUT_GET, 'after');
	$end = filter_input(INPUT_GET, 'before');
	
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

		$tipo_postagem_id = get_post_meta($post->ID, 'tipo_postagem', true);
		$tipo_postagem = get_term($tipo_postagem_id, 'tipo_postagem')->name;
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

if( $query->have_posts() && $model === 'voe') {
	$querystring = http_build_query(array_merge($_GET, array('action'=>'download')));
	
	echo "<a href='?$querystring' class='btn btn-filter' >Download</a>";
}

get_footer($model);