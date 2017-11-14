<?php get_header(); ?>

<?php
if (have_posts()) {
	the_post();

	// Post Data

	$head_data = un_page_head_builder();

	$head_style = $head_data['bg'] . 'height:' . $head_data['height'] . ';';

	if ($head_data['color']) {
		$head_style .= 'color:' . $head_data['color'] . ';';
	}

	$layout_data = un_page_layout_builder();

	if ($layout_data['layout'] == 'full_small') {
		$wrap_class = 'wrap-boxed-narrow';
	} else {
		$wrap_class = 'wrap-boxed';
	}

	$format = get_post_format();
	if ($format == 'gallery') {
		$gallery_type = un_redux_opt(UN, 'm_post_gallery_type', 'gallery');
		if ($gallery_type == 'slider') {
			$format = 'slider';
		}
	}
	
	/* Custom Fields */
	$area_conhecimento = wp_get_post_terms($post->ID, 'area_conhecimento');
	$area_conhecimento_title = null;
	if(
			is_array($area_conhecimento) && 
			count($area_conhecimento) > 0) {
		
		$area_conhecimento_title = $area_conhecimento[0]->name;
	}
	
	$tipo_postagem = get_post_meta($post->ID, 'tipo_postagem', true);
	$titulo_alternativo = get_post_meta($post->ID, 'titulo_alternativo', true);
	$ato = array(
		'tipo' => get_term_by('id', get_post_meta($post->ID, 'tipo_ato', true), 'tipo_ato')->name,
		'numero' => get_post_meta($post->ID, 'numero_ato', true),
		'informacoes' => get_post_meta($post->ID, 'informações_ato', true),
	);
	$ementa = get_post_meta($post->ID, 'ementa', true);
	$fonte = array(
		'titulo' => get_post_meta($post->ID, 'fonte', true),
		'data' => date('d/m/Y', strtotime(get_post_meta($post->ID, 'data_fonte', true))),
		);
	$autor_artigo = get_post_meta($post->ID, 'autor_artigo', true);
	
	$tipo_arquivo = get_post_meta($post->ID, 'tipo_arquivo', true);
	
	switch ($tipo_arquivo) {
		case 'local':
			$arquivo_url = wp_get_attachment_url( get_post_meta($post->ID, 'arquivo', true) );
			break;
		
		case 'remoto' :
			$arquivo_url = get_post_meta($post->ID, 'arquivo_url', true);
			break;
	}
	?>
	<div class="un-page-wrap">
		<div class="un-page-head wrap-full d-flex" style="<?php un_echo($head_style, 'attr'); ?>">

			<div class="wrap-boxed text-c">

				<div class="un-page-head-title un-title-l fade-in-down appear"><?php un_echo($head_data['title'], 'html'); ?></div>
				<div class="un-page-head-exc fade-in-up appear"><?php echo $tipo_postagem ?></div>

	<?php if ($head_data['arrow']) { ?>
					<i class="un-page-head-ico fa-icon-angle-down go-to" data-goto="#un-page-content"></i>
	<?php } ?>

			</div>

		</div>

		<div id="un-page-content" class="un-page-content <?php un_echo($wrap_class, 'attr'); ?>">

			<div class="row gutter-30">

					<?php if ($layout_data['layout'] == 'side_L') { ?>

					<div class="col-xl-3 col-s-12 un-page-side-left un-page-side">

						<?php
						if (isset($layout_data['sidebar']) && $layout_data['sidebar'] && is_dynamic_sidebar($layout_data['sidebar'])) {

							dynamic_sidebar($layout_data['sidebar']);
						}
						?>

					</div>

	<?php } ?>

					<?php if ($layout_data['layout'] == 'side_L' || $layout_data['layout'] == 'side_R') { ?>

					<div class="col-xl-9 col-s-12 un-page-content-inner un-sided un-text-color">

						<?php } else { ?>

		                <div class="col-xl-12 un-page-content-inner un-text-color">

						<?php } ?>

						<?php
						// Format MEDIA Switcher
						switch ($format) {

							default: // Standard Post
								get_template_part('parts/single/post-media', 'standard');
								break;

							case 'gallery': // Gallery Post
								get_template_part('parts/single/post-media', 'gallery');
								break;

							case 'slider': // Slider Post
								get_template_part('parts/single/post-media', 'slider');
								break;

							case 'video': // Video Post
								get_template_part('parts/single/post-media', 'video');
								break;

							case 'audio': // Audio Post
								get_template_part('parts/single/post-media', 'audio');
								break;
						}
						?>

	                    <article class="<?php echo $tipo_postagem ?>">
							<img src='<?php echo get_stylesheet_directory_uri() ?>/assets/img/logos/veritae-15-azul.jpg' alt="Veritae 15 anos"
								 class='veritae-logo'/>
							
							<p class='veritae-voe-data'>Ano XIV - Edição Diária - VOE <?php the_date('Y/M/d') ?></p>
							
							<div class='veritae-voe-tipo'>
								<h2><?php echo $tipo_postagem ?></h2>
								<h3><?php echo $area_conhecimento_title ?></h3>
							</div>
							
							<h4 class="titulo-alternativo"><?php echo $titulo_alternativo ?></h4>
							
							<?php if(!empty($ato['informacoes'])) { ?>
							<div class="veritae-voe-ato h5">
								<?php echo $ato['informacoes'] ?>
							</div>
							<?php } ?>
							
							<?php if(!empty($ementa)) { ?>
							<div class="veritae-voe-ementa h5">
								<?php echo $ementa ?>
							</div>
							<?php } ?>
							
							<?php the_content(); ?>
							
							<?php if( !empty($fonte['titulo']) && !empty($fonte['data']) ) { ?>
							<div class="veritae-voe-fonte">
								<?php if(!empty($fonte['titulo'])) { ?>
								<span style="display: block">Fonte: <?php echo $fonte['titulo'] ?></span>
								<?php } ?>

								<?php if(!empty($fonte['data'])) { ?>
								<span style="display: block">Data da Fonte: <?php echo $fonte['data'] ?></span>
								<?php } ?>
							</div>
							<?php } ?>
							
							<?php if( !empty($autor_artigo)) { ?>
							<div class="veritae-voe-autor">
								Autor: <?php echo $autor_artigo ?>
							</div>
							<?php } ?>
							
							<div class="btn un-btn-12">
								<a target="_blank" rel="noindex,nofollow" href="<?php echo $arquivo_url ?>" 
								   class="download-pdf" download >Download PDF</a>
							</div>
							
						</article>

						<?php
						// Post Tags
						if (un_redux_opt(UN, 'opt_post_tags')) {
							get_template_part('parts/single/post', 'tags');
						}
						?>

	                </div>

	<?php if ($layout_data['layout'] == 'side_R') { ?>

						<div class="col-xl-3 col-s-12 un-page-side-right un-page-side">

							<?php
							if (isset($layout_data['sidebar']) && $layout_data['sidebar'] && is_dynamic_sidebar($layout_data['sidebar'])) {

								dynamic_sidebar($layout_data['sidebar']);
							}
							?>

						</div>

	<?php } ?>

	            </div>

	        </div>

			<?php
			// Post navy
			if (un_redux_opt(UN, 'opt_post_navy')) {
				get_template_part('parts/single/post', 'navy');
			}
			?>

	        <!-- UN-PAGE-ABOUT-AUTHOR -->
	<?php if (un_redux_opt(UN, 'opt_post_author')) { ?>

				<div class="un-page-author">

					<div class="<?php un_echo($wrap_class, 'attr'); ?>">

						<?php
						// Post author
						get_template_part('parts/single/post', 'author');
						?>

					</div>

				</div>

			<?php } ?>
	        <!-- /UN-PAGE-ABOUT-AUTHOR -->

	<?php if (comments_open() && post_type_supports(get_post_type(), 'comments') && un_redux_opt(UN, 'opt_post_comments')) { // IF COMMENTS  ?>

				<div class="un-page-comments-wrap <?php un_echo($wrap_class, 'attr'); ?>" id="comments">

					<div class="un-page-comments">

		<?php comments_template(); ?>

					</div>

				</div>

			<?php } // END IF COMMENTS ?>

			<?php
			// Related Posts
			if (un_redux_opt(UN, 'opt_post_related')) {
				get_template_part('parts/single/post', 'related');
			}
			?>

	    </div>

	<?php } // end of if have post. ?>

<?php
get_footer();


	