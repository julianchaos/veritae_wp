<?php
/*
Description: The Header
Theme: Maya Reloaded
*/
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

    <title><?php wp_title('', true); ?></title>
    
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

    <?php wp_head(); ?>
    
</head>

<body <?php body_class(); ?>>

<?php if( un_redux_opt(UN, 'opt_adv_loading') ){ ?>

    <!-- PAGE LOADING -->
    <div class="load-wrap">
    	
    	<?php 
		$opt_adv_loading_custom_html = un_redux_opt(UN, 'opt_adv_loading_custom_html');
    	if( !empty($opt_adv_loading_custom_html) ){ ?> 
    	
    		<style>
    		<?php un_echo( un_redux_opt(UN, 'opt_adv_loading_custom_css'), 'full' ); ?>
    		</style> 
    		
    		<div class="load-item-custom">
        		<?php un_echo( un_redux_opt(UN, 'opt_adv_loading_custom_html'), 'full' ); ?>
        	</div>
        	
        <?php }else{ ?>
        
        	<div class="load-item"></div>   
        	     	
        <?php } ?>
        
    </div>

<?php } ?>

<!-- wrap-full -->
<div class="wrap-full">

    <?php

    // Global data
    global $is_redirect;

    // Menu Type
    $menu_type = un_menu_type();
    $type_class = $menu_type['class'];
    $logo_url = $menu_type['logo'];
    $sticky_class = $menu_type['sticky'];

    ?>

    <?php if( !$is_redirect ){ ?>
        <header class="<?php un_echo( $type_class, 'attr' ); ?> <?php un_echo( $sticky_class, 'attr' ); ?>">

        <div class="un-logo">
            <a href="<?php un_echo( get_site_url(), 'url' ); ?>"><img src="<?php un_echo( $logo_url, 'url' ); ?>" alt=""></a>
        </div>

        <?php
        if( is_page_template('page-vc.php') ) {

            $menu_loc = get_post_meta(get_the_ID(), 'm_page_vc_menu_loc', true);
            if( $menu_loc && $menu_loc == 'onepage' ) {
                un_echo(un_onepage_menu(), 'html');
            }else{
                un_echo(un_main_menu(), 'html');
            }

        }elseif( is_page() ){

            $menu_loc = get_post_meta(get_the_ID(), 'm_page_menu_loc', true);
            if( $menu_loc && $menu_loc == 'onepage' ) {
                un_echo(un_onepage_menu(), 'html');
            }else{
                un_echo(un_main_menu(), 'html');
            }

        }else{

            un_echo(un_main_menu(), 'html');

        }
        ?>

        <!-- Header Icons-->
        <div class="un-header-icons">

            <?php if( class_exists( 'WooCommerce' ) && un_is_woocommerce() && wc_get_cart_url() ){ ?>
            <div class="un-btn-cart">
                <a href="<?php un_echo( wc_get_cart_url(), 'url'); ?>" title="<?php esc_html_e( 'View your shopping cart', 'maya' ); ?>">
                    <i class="fe-icon-bag"></i>
                    <span class="un-wc-total">
                        <?php //un_echo( sprintf ( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'maya' ), WC()->cart->get_cart_contents_count() ), 'html' ); ?> <?php un_echo( WC()->cart->get_cart_total(), 'html' ); ?>
                    </span>
                </a>
            </div>
            <?php } ?>

            <?php if( un_redux_opt( UN, 'opt_menu_email' ) && un_redux_opt( UN, 'opt_menu_email_address' ) ){ ?>
                <div class="un-btn-git">
                    <a title="<?php esc_html_e('Get in Touch', 'maya'); ?>" href="mailto:<?php un_echo( un_redux_opt( UN, 'opt_menu_email_address' ), 'html' ); ?>"><i class="fe-icon-mail"></i></a>
                </div>
            <?php } ?>

            <?php if( un_redux_opt( UN, 'opt_menu_search' ) ){ ?>
                <div class="un-btn-search" id="un-btn-search">
                    <i class="fe-icon-search"></i>
                </div>
            <?php } ?>

            <div class="un-modal-search" id="un-modal-search">

                <form method="get" class="un-search-form" id="un-top-search" action="<?php un_echo( home_url('/'), 'url' ); ?>">

                    <div class="wrap-boxed">
                        <input class="un-search-field" placeholder="Procure por uma palavra chave" value="" name="s" title="Search for:" type="search">
                    </div>

                </form>

                <div class="un-btn-close" id="un-btn-search-close">
                    <i class="fe-icon-cross"></i>
                </div>

            </div>

            <div class="un-btn-menu" id="un-btn-menu"><i class="fe-icon-menu"></i></div>
            
            <div class="clear"></div>

        </div>

        <!-- Mobile Menu -->
        <?php
        if( is_page_template('page-vc.php') ) {

            $menu_loc = get_post_meta(get_the_ID(), 'm_page_vc_menu_loc', true);
            if( $menu_loc && $menu_loc == 'onepage' ) {
                un_echo(un_onepage_mobile_menu(), 'html');
            }else{
                un_echo(un_mobile_menu(), 'html');
            }

        }elseif( is_page() ){

            $menu_loc = get_post_meta(get_the_ID(), 'm_page_menu_loc', true);
            if( $menu_loc && $menu_loc == 'onepage' ) {
                un_echo(un_onepage_mobile_menu(), 'html');
            }else{
                un_echo(un_mobile_menu(), 'html');
            }

        }else{

            un_echo(un_mobile_menu(), 'html');

        }
        ?>

        <div class="clear"></div>

    </header>
    <?php } ?>