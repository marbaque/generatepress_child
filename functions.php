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
	remove_meta_box( 'tagsdiv-recurso_category' , 'curso' , 'normal' ); 
  }
  add_action( 'admin_menu' , 'remove_page_tags_recurso_field' );


//esta función se carga despues del functions.php del parent theme
function generate_press_child_setup() {
	
	//agregar tamaños de imagen
	add_image_size('portada-curso', 350, 350, true);
	add_image_size('portada-curso-thumbnail', 270, 270, true);
	
	//agregar iconos de fontawesome-com
	wp_enqueue_script('generatepress-fontawesome', 'https://use.fontawesome.com/releases/v5.0.6/js/all.js' );
	
	
	
	//Las siguientes funciones son para agregar un metabox de parent-post
	//o sea, para escoger el curso al que pertenecen las secciones
	
	//Updating the “Parent” meta box
	function my_add_meta_boxes() {
		add_meta_box( 'seccion-parent', 'Curso asignado', 'lesson_attributes_meta_box', 'seccion', 'side', 'high' );
	}
	add_action( 'add_meta_boxes', 'my_add_meta_boxes' );
	
	function lesson_attributes_meta_box( $post ) {
		$post_type_object = get_post_type_object( $post->post_type );
		$pages = wp_dropdown_pages( array( 'post_type' => 'curso', 'selected' => $post->post_parent, 'name' => 'parent_id', 'show_option_none' => __( '(no parent)' ), 'sort_column'=> 'menu_order, post_title', 'echo' => 0 ) );
		if ( ! empty( $pages ) ) {
			echo $pages;
		}
	}
	
	//Setting the exactly URL structure
	function my_add_rewrite_rules() {
		add_rewrite_tag('%seccion%', '([^/]+)', 'seccion=');
		add_permastruct('seccion', '/seccion/%curso%/%seccion%', false);
		add_rewrite_rule('^seccion/([^/]+)/([^/]+)/?','index.php?seccion=$matches[2]','top');
	}
	add_action( 'init', 'my_add_rewrite_rules' );
	
	//Updating the permalink for our custom post type
	function my_permalinks($permalink, $post, $leavename) {
		$post_id = $post->ID;
		if($post->post_type != 'seccion' || empty($permalink) || in_array($post->post_status, array('draft', 'pending', 'auto-draft')))
		 	return $permalink;
		$parent = $post->post_parent;
		$parent_post = get_post( $parent );
		$permalink = str_replace('%curso%', $parent_post->post_name, $permalink);
		return $permalink;
	}
	add_filter('post_type_link', 'my_permalinks', 10, 3);
	
}
add_action('after_setup_theme', 'generate_press_child_setup');
