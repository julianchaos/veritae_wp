<?php
ob_start();
?><form id='filter-form' method='get'>
	<?php
	if(filter_has_var(INPUT_GET, 's')) { ?>
	<input type='hidden' name='s' value='<?php echo filter_input(INPUT_GET, 's') ?>' />
<?php
	}
	
	if(filter_has_var(INPUT_GET, 'voe')) { ?>
	<input type='hidden' name='voe' value='<?php echo filter_input(INPUT_GET, 'voe') ?>' />
<?php
	}
	?>
	<input type='hidden' name="area-conhecimento" />
	<input type="hidden" name="filter" value="area-conhecimento" />
	<?php
	$submitted_area_conhecimento = array();
	$clear_filter = null;
	
	if (filter_has_var(INPUT_GET, 'area-conhecimento')) {
		$submitted_area_conhecimento = explode(',', filter_input(INPUT_GET, 'area-conhecimento'));
		
		$query_data = filter_input_array(INPUT_GET);
		unset($query_data['area-conhecimento']);
		
		$clear_filter = explode("?", $_SERVER['HTTP_REFERER'])[0];
		$clear_filter .= "?" . http_build_query($query_data);
	}

	$area_conhecimento = array(
		'previdencia-social' => 'Previdência Social',
		'trabalho' => 'Trabalho',
		'seguranca-e-saude-no-trabalho' => 'Segurança e Saúde no Trabalho',
		'correlatos' => 'Correlatos',
	);

	foreach ($area_conhecimento as $key => $label) {
		$checked = (in_array($key, $submitted_area_conhecimento) ? 'checked' : null) ?>
		<label><input type="checkbox" value="<?php echo $key ?>" <?php echo $checked ?>> <?php echo $label ?></label>
		<?php }
	?>
	<input type='button' value='Filtrar' id='filter-form-submit' />
</form><?php
$form_content = ob_get_clean();

$accordion = '[vc_tta_accordion active_section="null" collapsible_all="true"][vc_tta_section title="Filtrar por Área de Conhecimento" tab_id="1508348492992-eb970e03-2378"]'
		. $form_content
		. '[/vc_tta_section][/vc_tta_accordion]';
$filtered_accordion = apply_filters( 'the_content', $accordion); ?>

<div class="col-xl-12 un-page-content-inner un-text-color filter-container filter-area-conhecimento-container">
	<?php
	echo $filtered_accordion;
	
	if(filter_has_var(INPUT_GET, 'tipo')) {
		echo "<a href='$clear_filter' class='clear-filter'>Limpar Filtro</a>";
	} ?>
</div>
