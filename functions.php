<?php
/**
 * GeneratePress child theme functions and definitions.
 *
 * Add your custom PHP in this file. 
 * Only edit this file if you have direct access to it on your server (to fix errors if they happen).
 */

function generatepress_child_enqueue_scripts() {
	if ( is_rtl() ) {
		wp_enqueue_style( 'generatepress-rtl', trailingslashit( get_template_directory_uri() ) . 'rtl.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'generatepress_child_enqueue_scripts', 100 );

function remove_page_tags_recurso_field() {
	remove_meta_box( 'tagsdiv-recurso_category' , 'post' , 'normal' ); 
}
add_action( 'admin_menu' , 'remove_page_tags_recurso_field' );
