<?php
/*
Description: The Index
Theme: Maya Reloaded
*/

get_header(); ?>
    <?php
    // Loop Page Data
    $head_data = un_page_head_builder();

    $head_style = $head_data['bg'].' height:'.$head_data['height'].'; ';

    if($head_data['color']){ $head_style .= 'color:'.$head_data['color'].'; '; }

    $layout_data = un_page_layout_builder();

    if( $layout_data['layout'] == 'full_small' ){
        $wrap_class = 'wrap-boxed-narrow';
    }else{
        $wrap_class = 'wrap-boxed';
    }
    ?>

    <!-- UN-PAGE -->
	<?php
	$voeclass = filter_has_var(INPUT_GET, "voe") ? 'voe-edicao' : null;
	?>
    <div class="un-page-wrap un-loop <?php echo $voeclass ?>">

        <div class="un-page-head wrap-full d-flex" style="<?php un_echo( $head_style, 'attr' ); ?>">

            <div class="wrap-boxed text-c">

                <div class="un-page-head-title un-title-s font-w-600 fade-in-down appear"><?php un_echo( $head_data['title'], 'html' ); ?></div>

                <?php if( $head_data['subtitle'] ){ ?>
                    <div class="un-page-head-exc fade-in-up appear"><?php un_echo( $head_data['subtitle'], 'html' ); ?></div>
                <?php } ?>

                <?php if( $head_data['arrow'] ){ ?>
                    <i class="un-page-head-ico fa-icon-angle-down go-to" data-goto="#un-page-content"></i>
                <?php } ?>

            </div>

        </div>
		
		<?php if(is_home()) {get_template_part('template/home', 'header');} ?>
		

        <div class="<?php un_echo( $wrap_class, 'attr' ); ?>" id="un-page-content">

            <div class="un-page-loop row gutter-30">
				
				<?php get_template_part('template/filter', 'tipo') ?>
				
                <?php if( $layout_data['layout'] == 'side_L' ){ ?>

                <div class="col-xl-3 col-s-12 un-page-side-left un-page-side">

                    <?php
                    if( isset($layout_data['sidebar']) && $layout_data['sidebar'] && is_dynamic_sidebar($layout_data['sidebar']) ){

                        dynamic_sidebar($layout_data['sidebar']);

                    } ?>

                </div>

                <?php } ?>

                <?php if( $layout_data['layout'] == 'side_L' || $layout_data['layout'] == 'side_R' ){ ?>

                <div class="col-xl-9 col-s-12 un-sided">

                <?php }else{ ?>

                <div class="col-xl-12">

                <?php } ?>
		    
		    <?php if( have_posts() ){ ?>
	                    <?php while ( have_posts() ) { the_post(); // LOOP ?>

	                        <?php
	                        // Post Format
	                        $format = get_post_format();
	                        if( $format == 'gallery' ){
	                            $gallery_type = un_redux_opt( UN, 'm_post_gallery_type', 'gallery' );
	                            if( $gallery_type == 'slider' ){
	                                $format = 'slider';
	                            }
	                        }
	                        ?>
	
	                        <div class="un-post-wrap">
	
	                            <div class="un-post">
	
	                                <div class="un-post-image">
	
	                                    <?php
	                                    // Format MEDIA Switcher
	                                    switch( $format ) {
	
	                                        default: // Standard Post
	                                            get_template_part( 'parts/single/post-media', 'standard' ); ?>
	                                            <div class="un-post-cat">
	                                                <?php the_category(); ?>
	                                            </div>
	                                            <?php
	                                            break;
	
	                                        case 'gallery': // Gallery Post
	                                            get_template_part( 'parts/single/post-media', 'gallery' ); ?>
	                                            <div class="un-post-cat">
	                                                <?php the_category(); ?>
	                                            </div>
	                                            <?php
	                                            break;
	
	                                        case 'slider': // Slider Post
	                                            get_template_part( 'parts/single/post-media', 'slider' ); ?>
	                                            <div class="un-post-cat">
	                                                <?php the_category(); ?>
	                                            </div>
	                                            <?php
	                                            break;
	
	                                        case 'video': // Video Post
	                                            get_template_part( 'parts/single/post-media', 'video' );
	                                            break;
	
	                                        case 'audio': // Audio Post
	                                            get_template_part( 'parts/single/post-media', 'audio' );
	                                            break;
	
	                                    }
	                                    ?>
	
	
	                                </div>
	
	                                <div class="un-post-caption">
	
	                                    <div class="un-post-title">
	                                        <a href="<?php the_permalink(); ?>">
	                                            <?php the_title(); ?>
	                                        </a>
	                                    </div>
	
	                                    <div class="un-post-exc"><?php un_echo( un_post_exerpt(null, 40), 'html' ); ?></div>
	
	                                    <?php
	
	                                    // Post Meta
	                                    $date = get_the_date( 'd M Y' );
	                                    $author = '<a href="'.get_author_posts_url( get_the_author_meta('ID') ).'">'.get_the_author().'</a>';
										
										$area_conhecimento = wp_get_post_terms($post->ID, 'area_conhecimento');
										$area_conhecimento_links = array();
										if(
												is_array($area_conhecimento) && 
												count($area_conhecimento) > 0) {
											foreach($area_conhecimento as $term) {
												$area_conhecimento_links[] = "<a href='".get_term_link($term->term_id)."'>{$term->name}</a>";
											}
											
										}
	                                    ?>
	
	                                    <!-- UN-POST-META -->
	                                    <div class="un-post-meta">
	
	                                        <div class="un-post-date"><?php un_echo( $date, 'html' ); ?></div>
											<?php
											if( count($area_conhecimento_links) > 0 ) {
												echo '<div class="un-post-author">';
													echo '<span>em </span>';
													echo implode(", ", $area_conhecimento_links);
												echo '</div>';
											}
											?>
											
	
	                                    </div>
	                                    <!-- /UN-POST-META -->
	
	                                    <div class="clear"></div>
	
	
	                                    <div class="un-post-links">
	
	                                        <ul class="no-style">
	
	                                            <li class="first"><i class="en-icon-share"></i></li>
	                                            <li>
	                                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php un_echo( get_the_permalink(), 'url' ); ?>" target="_blank">
	                                                    <i class="en-icon-facebook"></i>
	                                                </a>
	                                            </li>
	                                            <li>
	                                                <a href="https://twitter.com/home?status=<?php un_echo( get_the_permalink(), 'url' ); ?>" target="_blank">
	                                                    <i class="en-icon-twitter"></i>
	                                                </a>
	                                            </li>
	                                            <li>
	                                                <a href="https://plus.google.com/share?url=<?php un_echo( get_the_permalink(), 'url' ); ?>" target="_blank">
	                                                    <i class="en-icon-google"></i>
	                                                </a>
	                                            </li>
	
	                                        </ul>
	
	                                    </div>
	
	                                </div>
	
	                            </div>
	
	                        </div>
	
	                    <?php } // END LOOP ?>
	            
	            <?php }else{ ?>
	            	
	            	<div class="un-no-items">
	            		<?php esc_html_e('No items found', 'maya'); ?>
	            		<small><?php esc_html_e('Please try another search key or use the menu.', 'maya'); ?></small>
	            	</div>
	            	
	            <?php } ?>

                    <div class="clear"></div>

                </div>

                <?php if( $layout_data['layout'] == 'side_R' ){ ?>

                    <div class="col-xl-3 col-s-12 un-page-side-right un-page-side">

                        <?php
                        if( isset($layout_data['sidebar']) && $layout_data['sidebar'] && is_dynamic_sidebar($layout_data['sidebar']) ){

                            dynamic_sidebar($layout_data['sidebar']);

                        } ?>

                    </div>

                <?php } ?>

            </div>

            <?php un_echo( un_full_pagination(null, 5), 'html' ); ?>

        </div>

    </div>
    <!-- /UN-PAGE -->


<?php get_footer();