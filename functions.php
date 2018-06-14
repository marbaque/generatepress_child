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
	

	function generate_custom_scripts() {
		// OJO!!!!!! AQUI SE AGREGAN estilos y scripts nuevos que se quieran agregar al sitio*************************************************!!
				
		//importar js para navegación responsive
		wp_enqueue_script( 'wpb_togglemenu', get_stylesheet_directory_uri() . '/js/responsive-nav.js', array('jquery'), '20180314', true );
		
		//incluir script para iconos fontawesome
		wp_enqueue_script('ocw-fontawesome', 'https://use.fontawesome.com/releases/v5.0.6/js/all.js');
	}
	add_action( 'wp_enqueue_scripts', 'generate_custom_scripts', 10 );
	
	//agregar tamaños de imagen
	add_image_size('portada-curso', 350, 350, true);
	add_image_size('portada-curso-thumbnail', 270, 270, true);
	add_image_size('portada-video', 840, 473, true);
	add_image_size('portada-recurso', 800, 420, true);
	
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
		$pages = wp_dropdown_pages( array( 'post_type' => 'curso', 'post_status' => array( 'pending', 'draft', 'publish' ), 'selected' => $post->post_parent, 'name' => 'parent_id', 'show_option_none' => __( '(no parent)' ), 'sort_column'=> 'menu_order, post_title', 'echo' => 0 ) );
		if ( ! empty( $pages ) ) {
			echo $pages;
		}
	}
	
	//Setting the exactly URL structure
	function my_add_rewrite_rules() {
		add_rewrite_tag('%seccion%', '([^/]+)', 'seccion=');
		add_permastruct('seccion', '/seccion/%curso%/%seccion%/', false);
		add_rewrite_rule('seccion/([^/]+)/([^/]+)/?/page/([0-9]{1,})/?','index.php?seccion=$matches[2]&paged=$matches[3]','top');
		
		//add_rewrite_rule('region/([^/]+)/type/([^/]+)/page/([0-9]{1,})/?', 'index.php?taxonomy=region&term=$matches[1]&post_type=$matches[2]&paged=$matches[3]', 'top' );
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
	
	
	//*************Agregar opción para filtrar secciones por curso (parent id)*************
	function fws_admin_posts_filter( $query ) {
	    global $pagenow;
	    if ( is_admin() && $pagenow == 'edit.php' && !empty($_GET['my_parent_pages'])) {
	        $query->query_vars['post_parent'] = $_GET['my_parent_pages'];
	    }
	}
	add_filter( 'parse_query', 'fws_admin_posts_filter' );
	 
	function admin_page_filter_parentpages() {
	    global $wpdb;
	    if (isset($_GET['post_type']) && $_GET['post_type'] == 'seccion') {
			$sql = "SELECT ID, post_title FROM ".$wpdb->posts." WHERE post_type = 'curso' AND post_parent = 0 AND post_status = 'publish' OR post_status = 'pending' ORDER BY post_title";
			$parent_pages = $wpdb->get_results($sql, OBJECT_K);
			$select = '<select name="my_parent_pages">
				<option value="">Curso asignado</option>';
			
			$current = isset($_GET['my_parent_pages']) ? $_GET['my_parent_pages'] : '';
			
			foreach ($parent_pages as $page) {
				$select .= sprintf('<option value="%s"%s>%s</option>', $page->ID, $page->ID == $current ? ' selected="selected"' : '', $page->post_title);
			}
			
			$select .= '</select>';
			echo $select;
		} else {
			return;
		}
	}
	add_action( 'restrict_manage_posts', 'admin_page_filter_parentpages' );
	//**************************************************************************************
	
	
	
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
		return 10;
	}
	add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
	
	
	//generar numero de visitas
	function getPostViews($postID){
	    $count_key = 'post_views_count';
	    $count = get_post_meta($postID, $count_key, true);
	    if($count==''){
	        delete_post_meta($postID, $count_key);
	        add_post_meta($postID, $count_key, '0');
	        return "0 visitas";
	    }
	    return $count.' visitas';
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
	
	//permitir que los cursom posts tengan archivos de categorias y etiquetas
	function wpa_cpt_tags( $query ) {
	    if ( $query->is_tag() && $query->is_main_query() ) {
	        $query->set( 'post_type', array( 'post', 'object', 'recurso', 'curso' ) );
	    } 
	}
	add_action( 'pre_get_posts', 'wpa_cpt_tags' );
	
	
	// quitar palabra "archivo" del titulo
	function my_theme_archive_title( $title ) {
		if ( is_category() ) {
			$title = single_cat_title( '', false );
	    } elseif ( is_tag() ) {
		    $title = single_tag_title( '', false );
	    } elseif ( is_author() ) {
		    $title = '<span class="vcard">' . get_the_author() . '</span>';
		} elseif ( is_post_type_archive() ) {
			$title = post_type_archive_title( '', false );
		} elseif ( is_tax() && !is_tax('autor_recurso') ) {
			$title = single_term_title( '', false );
	    }
	    return $title;
    }	 
	add_filter( 'get_the_archive_title', 'my_theme_archive_title' );
	
	//agregar los estilos personalizados del tema al editor
	add_editor_style( 'inc/editor-style-2.css' );		
		
		
	
	
	
}
add_action('after_setup_theme', 'generate_press_child_setup');



