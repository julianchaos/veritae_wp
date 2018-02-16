<?php

function cptui_register_my_taxes() {

	/**
	 * Taxonomy: Tipos de postagem.
	 */
	
	$labels = array(
		'name' => __( 'Tipos de postagem', 'Veritae' ),
		'singular_name' => __( 'Tipo de postagem', 'Veritae' )
	);
	
	$args = array(
		'label' => __('Tipos de postagem', 'Veritae'),
		'labels' => $labels,
		'public' => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'tipo_postagem', 'with_front' => true, ),
		"show_admin_column" => false,
		"show_in_rest" => false,
		"rest_base" => "",
		"show_in_quick_edit" => false,
	);
	register_taxonomy( 'tipo_postagem', array( 'post' ), $args );
	
	/**
	 * Taxonomy: Áreas de conhecimento.
	 */

	$labels = array(
		"name" => __( 'Áreas de conhecimento', 'Veritae' ),
		"singular_name" => __( 'Área de conhecimento', 'Veritae' ),
	);

	$args = array(
		"label" => __( 'Áreas de conhecimento', 'Veritae' ),
		"labels" => $labels,
		"public" => true,
		"hierarchical" => false,
		"label" => "Áreas de conhecimento",
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'area_conhecimento', 'with_front' => true, ),
		"show_admin_column" => false,
		"show_in_rest" => false,
		"rest_base" => "",
		"show_in_quick_edit" => false,
	);
	register_taxonomy( "area_conhecimento", array( "post" ), $args );

	/**
	 * Taxonomy: Tipos de ato.
	 */

	$labels = array(
		"name" => __( 'Tipos de ato', 'Veritae' ),
		"singular_name" => __( 'Tipo do ato', 'Veritae' ),
	);

	$args = array(
		"label" => __( 'Tipos de ato', 'Veritae' ),
		"labels" => $labels,
		"public" => true,
		"hierarchical" => false,
		"label" => "Tipos de ato",
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'tipo_ato', 'with_front' => true, ),
		"show_admin_column" => false,
		"show_in_rest" => false,
		"rest_base" => "",
		"show_in_quick_edit" => false,
	);
	register_taxonomy( "tipo_ato", array( "post" ), $args );
}

add_action( 'init', 'cptui_register_my_taxes' );

