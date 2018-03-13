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

//Quita las metaboxes de areas y licencias en curso y seccion 
function remove_tags_fields() {
	remove_meta_box( 'tagsdiv-area' , 'curso' , 'side' );
	remove_meta_box( 'tagsdiv-licencia' , 'seccion' , 'side' );
	remove_meta_box( 'tagsdiv-recurso_category' , 'recurso' , 'side' );
	remove_meta_box( 'tagsdiv-licencia' , 'recurso' , 'side' );
}
add_action( 'admin_menu' , 'remove_tags_fields' );


//esta función se carga despues del functions.php del parent theme
function generate_press_child_setup() {
	
	
	add_action( 'wp_enqueue_scripts', 'generate_custom_scripts', 10 );
	function generate_custom_scripts() {
		// OJO!!!!!! AQUI SE AGREGAN estilos y scripts nuevos que se quieran agregar al sitio*************************************************!!
		wp_dequeue_script( 'fontawesome' );
		wp_enqueue_script( 'fontawesome-generatepress-child', 'https://use.fontawesome.com/releases/v5.0.8/js/all.js', false, '5.0.8', 'all' );
	}
	
	//agregar tamaños de imagen
	add_image_size('portada-curso', 350, 350, true);
	add_image_size('portada-curso-thumbnail', 270, 270, true);
	add_image_size('portada-video', 840, 473, true);
	add_image_size('portada-recurso', 630, 330, true);
	
	//registrar menu para recursos
	register_nav_menus( array(
		'recursos-nav' => ( 'Menu de recursos' ),
		'cursos-areas' => ( 'Menu de áreas para cursos' ),
	) );
	
	
	
	 // Permite subida de archivos stl (modelos 3D)
	 function custom_upload_mimes($mimes = array()) {
	
		// Add a key and value for the stl file type
		$mimes['stl'] = "object/stl";
	
		return $mimes;
	}
	
	add_action('upload_mimes', 'custom_upload_mimes');
	
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
	
	//Agregar clases a las paginas
	function generatepress_body_classes( $classes ) {
		
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}
	
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
			$classes[] = 'archive-view';
		}
		
		if ( is_singular('recurso') ) {
			$classes[] = 'recurso-post';
		}
		if ( is_front_page() ) {
			$classes[] = 'ocw-front';
		}
		if ( is_post_type_archive('curso') ) {
			$classes[] = 'archivo-cursos';
		}
		if ( is_post_type_archive('recurso') ) {
			$classes[] = 'archivo-recursos';
		}
		return $classes;
		
		
	}
	add_filter( 'body_class', 'generatepress_body_classes' );
	
	//cortar el estracto del post
	function custom_excerpt_length( $length ) {
		return 12;
	}
	add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
	
	
	//generar numero de visitas
	function getPostViews($postID){
	    $count_key = 'post_views_count';
	    $count = get_post_meta($postID, $count_key, true);
	    if($count==''){
	        delete_post_meta($postID, $count_key);
	        add_post_meta($postID, $count_key, '0');
	        return "0 View";
	    }
	    return $count.' Views';
	}
	function setPostViews($postID) {
	    $count_key = 'post_views_count'; //este es el meta key usado en el query de cursos de la página principal
	    $count = get_post_meta($postID, $count_key, true);
	    if($count==''){
	        $count = 0;
	        delete_post_meta($postID, $count_key);
	        add_post_meta($postID, $count_key, '0');
	    }else{
	        $count++;
	        update_post_meta($postID, $count_key, $count);
	    }
	}
	// Remove issues with prefetching adding extra views
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
	
		
		
}
add_action('after_setup_theme', 'generate_press_child_setup');
