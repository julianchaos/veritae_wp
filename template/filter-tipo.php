<form id='tipo-form' method='get'>
	<input type='hidden' name="tipo" />
<?php
$submitted_tipo = array();

if(filter_has_var(INPUT_GET, 'tipo')) {
	$submitted_tipo = explode(',', filter_input(INPUT_GET, 'tipo'));
}

$tipo_postagem = array (
	'lex' => 'Lex',
	'noticia' => 'Notícia',
	'artigo' => 'Artigo',
	'materia' => 'Matéria',
	'informacao' => 'Informação',
	'jurisprudencia' => 'Jurisprudência',
);

foreach($tipo_postagem as $key=>$label) { 
	$checked = (in_array($key, $submitted_tipo) ? 'checked' : null) ?>
	<label><input type="checkbox" value="<?php echo $key ?>" <?php echo $checked ?>> <?php echo $label ?></label>
<?php
} ?>
	<input type='button' value='Filtrar' id='tipo-submit' />
</form>