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
	$arquivo_url = get_permalink() . "?format=pdf";
	if($tipo_arquivo === 'remoto') {
		$arquivo_url = get_post_meta($post->ID, 'arquivo_url', true);
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

	                    <div class="un-page-div"></div>

	                    <article>
							<h5 class="ato-titulo" style="color: #222;">Ato</h5>
							<p class="ato-content">
								<strong>Tipo:</strong> <?php echo $ato['tipo'] ?><br />
								<strong>Número:</strong> <?php echo $ato['numero'] ?><br />
								<strong>Informações:</strong> <?php echo $ato['informacoes'] ?><br />
							</p>
							<p>
								<strong>Ementa:</strong> <?php echo $ementa ?>
							</p>
							<h5 class="titulo-alternativo" style='color: #222'><?php echo $titulo_alternativo ?></h5>
							
							<?php the_content(); ?>
							
							<p>
								<strong>Fonte: </strong> <?php echo $fonte['titulo'] . ' em ' . $fonte['data'] ?><br />
								<strong>Autor:</strong> <?php echo $autor_artigo ?>
							</p>
							<p>
								<div class="btn un-btn-12">
									<a target="_blank" rel="noindex,nofollow" href="<?php echo $arquivo_url ?>" 
									   <?php if($tipo_arquivo === 'remoto') { echo 'download';} ?>>Download PDF</a>
								</div>
							</p>
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


	