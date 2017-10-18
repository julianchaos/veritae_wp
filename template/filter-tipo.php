<?php
ob_start();
?><form id='tipo-form' method='get'>
	<input type='hidden' name="tipo" />
	<?php
	$submitted_tipo = array();

	if (filter_has_var(INPUT_GET, 'tipo')) {
		$submitted_tipo = explode(',', filter_input(INPUT_GET, 'tipo'));
	}

	$tipo_postagem = array(
		'lex' => 'Lex',
		'noticia' => 'Notícia',
		'artigo' => 'Artigo',
		'materia' => 'Matéria',
		'informacao' => 'Informação',
		'jurisprudencia' => 'Jurisprudência',
	);

	foreach ($tipo_postagem as $key => $label) {
		$checked = (in_array($key, $submitted_tipo) ? 'checked' : null) ?>
		<label><input type="checkbox" value="<?php echo $key ?>" <?php echo $checked ?>> <?php echo $label ?></label>
		<?php }
	?>
	<input type='button' value='Filtrar' id='tipo-submit' />
</form><?php
$form_content = ob_get_clean();

$accordion = '[vc_tta_accordion active_section="null" collapsible_all="true"][vc_tta_section title="Filtrar por tipo" tab_id="1508348492992-eb970e03-2378"]'
		. $form_content
		. '[/vc_tta_section][/vc_tta_accordion]';
$filtered_accordion = apply_filters( 'the_content', $accordion); ?>

<div class="col-xl-12 un-page-content-inner un-text-color filter-tipo-container">
	<?php echo $filtered_accordion ?>
</div>