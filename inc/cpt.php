<?php
function cptui_register_my_cpts() {

/**
 * Post Type: Cursos abiertos (opencourseware).
 */

$labels = [
    "name" => __( "Cursos abiertos (opencourseware)", "custom-post-type-ui" ),
    "singular_name" => __( "Curso", "custom-post-type-ui" ),
    "menu_name" => __( "Cursos", "custom-post-type-ui" ),
    "all_items" => __( "Todos los cursos", "custom-post-type-ui" ),
    "add_new" => __( "Nuevo Curso", "custom-post-type-ui" ),
    "add_new_item" => __( "Añadir Curso", "custom-post-type-ui" ),
    "edit_item" => __( "Editar Curso", "custom-post-type-ui" ),
    "new_item" => __( "Nuevo Curso", "custom-post-type-ui" ),
    "view_item" => __( "Ver Curso", "custom-post-type-ui" ),
    "view_items" => __( "Ver Cursos", "custom-post-type-ui" ),
    "search_items" => __( "Buscar Curso", "custom-post-type-ui" ),
    "not_found" => __( "No se encontró ningún curso", "custom-post-type-ui" ),
    "not_found_in_trash" => __( "No se encontró en la papelera", "custom-post-type-ui" ),
    "parent" => __( "Ancestro", "custom-post-type-ui" ),
    "featured_image" => __( "Imagen destacada", "custom-post-type-ui" ),
    "set_featured_image" => __( "Cambiar imagen destacada", "custom-post-type-ui" ),
    "remove_featured_image" => __( "Quitar imagen destacada", "custom-post-type-ui" ),
    "use_featured_image" => __( "Usar imagen destacada", "custom-post-type-ui" ),
    "archives" => __( "Cursos abiertos (opencourseware)", "custom-post-type-ui" ),
    "insert_into_item" => __( "Insertar en curso", "custom-post-type-ui" ),
    "uploaded_to_this_item" => __( "Subido a este curso", "custom-post-type-ui" ),
    "filter_items_list" => __( "Filtrar", "custom-post-type-ui" ),
    "items_list_navigation" => __( "Navegar", "custom-post-type-ui" ),
    "items_list" => __( "Lista de cursos", "custom-post-type-ui" ),
    "attributes" => __( "Atributos", "custom-post-type-ui" ),
    "parent_item_colon" => __( "Ancestro", "custom-post-type-ui" ),
];

$args = [
    "label" => __( "Cursos abiertos (opencourseware)", "custom-post-type-ui" ),
    "labels" => $labels,
    "description" => "Contenido específico para un curso",
    "public" => true,
    "publicly_queryable" => true,
    "show_ui" => true,
    "delete_with_user" => false,
    "show_in_rest" => false,
    "rest_base" => "",
    "rest_controller_class" => "WP_REST_Posts_Controller",
    "has_archive" => true,
    "show_in_menu" => true,
    "show_in_nav_menus" => true,
    "delete_with_user" => false,
    "exclude_from_search" => false,
    "capability_type" => "page",
    "map_meta_cap" => true,
    "hierarchical" => true,
    "rewrite" => [ "slug" => "curso", "with_front" => true ],
    "query_var" => true,
    "menu_position" => 5,
    "menu_icon" => "dashicons-welcome-learn-more",
    "supports" => [ "title", "editor", "publicize" ],
    "taxonomies" => [ "area" ],
];

register_post_type( "curso", $args );

/**
 * Post Type: Secciones.
 */

$labels = [
    "name" => __( "Secciones", "custom-post-type-ui" ),
    "singular_name" => __( "Sección", "custom-post-type-ui" ),
    "all_items" => __( "Todas las Secciones", "custom-post-type-ui" ),
    "add_new" => __( "Agregar", "custom-post-type-ui" ),
    "add_new_item" => __( "Agregar Sección", "custom-post-type-ui" ),
    "edit_item" => __( "Editar Sección", "custom-post-type-ui" ),
    "new_item" => __( "Nueva Sección", "custom-post-type-ui" ),
    "view_item" => __( "Ver Sección", "custom-post-type-ui" ),
    "view_items" => __( "Ver Secciones", "custom-post-type-ui" ),
    "search_items" => __( "Buscar Sección", "custom-post-type-ui" ),
    "not_found" => __( "No se encontró ninguna sección", "custom-post-type-ui" ),
    "not_found_in_trash" => __( "No hay secciones en la papelera", "custom-post-type-ui" ),
    "parent" => __( "Superior", "custom-post-type-ui" ),
    "featured_image" => __( "Imagen principal", "custom-post-type-ui" ),
    "set_featured_image" => __( "Especificar imagen principal", "custom-post-type-ui" ),
    "remove_featured_image" => __( "Remocer imagen principal", "custom-post-type-ui" ),
    "use_featured_image" => __( "Usar imagen principal", "custom-post-type-ui" ),
    "archives" => __( "Archivo", "custom-post-type-ui" ),
    "insert_into_item" => __( "Insertar en la seccion", "custom-post-type-ui" ),
    "uploaded_to_this_item" => __( "Subido a esta sección", "custom-post-type-ui" ),
    "filter_items_list" => __( "Filtrar secciones", "custom-post-type-ui" ),
    "items_list_navigation" => __( "Navegación de secciones", "custom-post-type-ui" ),
    "items_list" => __( "Lista de secciones", "custom-post-type-ui" ),
    "attributes" => __( "Atributos de sección", "custom-post-type-ui" ),
    "parent_item_colon" => __( "Superior", "custom-post-type-ui" ),
];

$args = [
    "label" => __( "Secciones", "custom-post-type-ui" ),
    "labels" => $labels,
    "description" => "Secciones que contiene cada curso",
    "public" => true,
    "publicly_queryable" => true,
    "show_ui" => true,
    "delete_with_user" => false,
    "show_in_rest" => true,
    "rest_base" => "",
    "rest_controller_class" => "WP_REST_Posts_Controller",
    "has_archive" => false,
    "show_in_menu" => true,
    "show_in_nav_menus" => true,
    "delete_with_user" => false,
    "exclude_from_search" => true,
    "capability_type" => "page",
    "map_meta_cap" => true,
    "hierarchical" => false,
    "rewrite" => [ "slug" => "seccion", "with_front" => true ],
    "query_var" => true,
    "menu_position" => 6,
    "menu_icon" => "dashicons-networking",
    "supports" => [ "title", "editor", "thumbnail", "revisions", "page-attributes" ],
    "taxonomies" => [ "licencia" ],
];

register_post_type( "seccion", $args );

/**
 * Post Type: Recursos educativos abiertos.
 */

$labels = [
    "name" => __( "Recursos educativos abiertos", "custom-post-type-ui" ),
    "singular_name" => __( "Recurso", "custom-post-type-ui" ),
    "menu_name" => __( "Recursos", "custom-post-type-ui" ),
    "all_items" => __( "Todos los recursos", "custom-post-type-ui" ),
    "add_new" => __( "Recurso nuevo", "custom-post-type-ui" ),
    "add_new_item" => __( "Agregar nuevo", "custom-post-type-ui" ),
    "new_item" => __( "Recursos nuevo", "custom-post-type-ui" ),
    "view_item" => __( "Ver recurso", "custom-post-type-ui" ),
    "view_items" => __( "Ver recursos", "custom-post-type-ui" ),
    "search_items" => __( "Buscar recurso", "custom-post-type-ui" ),
    "not_found" => __( "Recurso no encontrado", "custom-post-type-ui" ),
    "not_found_in_trash" => __( "No se encontró en la papelera", "custom-post-type-ui" ),
    "parent" => __( "Ancestro", "custom-post-type-ui" ),
    "featured_image" => __( "Imagen destacada", "custom-post-type-ui" ),
    "set_featured_image" => __( "Agregar imagen destacada", "custom-post-type-ui" ),
    "remove_featured_image" => __( "Quitar imagen destacada", "custom-post-type-ui" ),
    "use_featured_image" => __( "Usar imagen destacada", "custom-post-type-ui" ),
    "archives" => __( "Recursos", "custom-post-type-ui" ),
    "insert_into_item" => __( "Insertar", "custom-post-type-ui" ),
    "uploaded_to_this_item" => __( "Subir al recurso", "custom-post-type-ui" ),
    "filter_items_list" => __( "Filtrar", "custom-post-type-ui" ),
    "items_list_navigation" => __( "Navegar", "custom-post-type-ui" ),
    "items_list" => __( "Lista", "custom-post-type-ui" ),
    "attributes" => __( "Atributos", "custom-post-type-ui" ),
    "parent_item_colon" => __( "Ancestro", "custom-post-type-ui" ),
];

$args = [
    "label" => __( "Recursos educativos abiertos", "custom-post-type-ui" ),
    "labels" => $labels,
    "description" => "Recursos educativos abiertos",
    "public" => true,
    "publicly_queryable" => true,
    "show_ui" => true,
    "delete_with_user" => false,
    "show_in_rest" => true,
    "rest_base" => "",
    "rest_controller_class" => "WP_REST_Posts_Controller",
    "has_archive" => true,
    "show_in_menu" => true,
    "show_in_nav_menus" => true,
    "delete_with_user" => false,
    "exclude_from_search" => false,
    "capability_type" => "post",
    "map_meta_cap" => true,
    "hierarchical" => false,
    "rewrite" => [ "slug" => "recursos", "with_front" => true ],
    "query_var" => true,
    "menu_position" => 7,
    "menu_icon" => "dashicons-format-gallery",
    "supports" => [ "title", "editor", "thumbnail", "comments", "revisions", "author" ],
    "taxonomies" => [ "post_tag" ],
];

register_post_type( "recurso", $args );
}

add_action( 'init', 'cptui_register_my_cpts' );


function cptui_register_my_taxes() {
/**
 * Taxonomy: Áreas.
 */

	$labels = [
		"name" => __( "Áreas", "custom-post-type-ui" ),
		"singular_name" => __( "Área", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Áreas", "custom-post-type-ui" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'area', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => false,
		"rest_base" => "area",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		];
	register_taxonomy( "area", [ "curso" ], $args );

	/**
	 * Taxonomy: Recursos.
	 */

	$labels = [
		"name" => __( "Recursos", "custom-post-type-ui" ),
		"singular_name" => __( "Recurso", "custom-post-type-ui" ),
		"menu_name" => __( "Tipos de recurso", "custom-post-type-ui" ),
		"all_items" => __( "Todos los tipos", "custom-post-type-ui" ),
		"edit_item" => __( "Editar tipo de recurso", "custom-post-type-ui" ),
		"view_item" => __( "Ver tipo de recurso", "custom-post-type-ui" ),
		"update_item" => __( "Actualizar tipo", "custom-post-type-ui" ),
		"add_new_item" => __( "Agregar nuevo tipo", "custom-post-type-ui" ),
		"new_item_name" => __( "Nombre del tipo de recurso", "custom-post-type-ui" ),
		"parent_item" => __( "Ítem padre", "custom-post-type-ui" ),
		"parent_item_colon" => __( "Ítem padre:", "custom-post-type-ui" ),
		"search_items" => __( "Buscar tipos de recurso", "custom-post-type-ui" ),
		"popular_items" => __( "Tipos de recurso más populares", "custom-post-type-ui" ),
		"separate_items_with_commas" => __( "Separar ítems con comas", "custom-post-type-ui" ),
		"add_or_remove_items" => __( "Agregar o quitar tipos de recurso", "custom-post-type-ui" ),
		"choose_from_most_used" => __( "Escoger entre los más utilizados", "custom-post-type-ui" ),
		"not_found" => __( "No se encontraron", "custom-post-type-ui" ),
		"no_terms" => __( "No hay términos", "custom-post-type-ui" ),
		"items_list_navigation" => __( "Navegar ítems", "custom-post-type-ui" ),
		"items_list" => __( "Lista de ítems", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Recursos", "custom-post-type-ui" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'recurso', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => false,
		"rest_base" => "recurso_category",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		];
	register_taxonomy( "recurso_category", [ "recurso" ], $args );

	/**
	 * Taxonomy: Licencias.
	 */

	$labels = [
		"name" => __( "Licencias", "custom-post-type-ui" ),
		"singular_name" => __( "Licencia", "custom-post-type-ui" ),
		"menu_name" => __( "Licencias", "custom-post-type-ui" ),
		"all_items" => __( "Todas las licencias", "custom-post-type-ui" ),
		"edit_item" => __( "Editar", "custom-post-type-ui" ),
		"view_item" => __( "Ver licencia", "custom-post-type-ui" ),
		"update_item" => __( "Actualizar nombre", "custom-post-type-ui" ),
		"add_new_item" => __( "Agregar nueva", "custom-post-type-ui" ),
		"new_item_name" => __( "Nombre nuevo", "custom-post-type-ui" ),
		"parent_item" => __( "Elemento original", "custom-post-type-ui" ),
		"parent_item_colon" => __( "Elemento original:", "custom-post-type-ui" ),
		"search_items" => __( "Buscar", "custom-post-type-ui" ),
		"popular_items" => __( "Populares", "custom-post-type-ui" ),
		"separate_items_with_commas" => __( "Separar con comas", "custom-post-type-ui" ),
		"add_or_remove_items" => __( "Agregar o remover elementos", "custom-post-type-ui" ),
		"choose_from_most_used" => __( "Escoger entre los más utilizados", "custom-post-type-ui" ),
		"not_found" => __( "No se encontraron", "custom-post-type-ui" ),
		"no_terms" => __( "No hay términos", "custom-post-type-ui" ),
		"items_list_navigation" => __( "Navegar", "custom-post-type-ui" ),
		"items_list" => __( "Lista de ítems", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Licencias", "custom-post-type-ui" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => false,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'licencia', 'with_front' => true, ],
		"show_admin_column" => true,
		"show_in_rest" => true,
		"rest_base" => "licencia",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		];
	register_taxonomy( "licencia", [ "seccion", "recurso" ], $args );

	/**
	 * Taxonomy: Autores de recursos.
	 */

	$labels = [
		"name" => __( "Autores de recursos", "custom-post-type-ui" ),
		"singular_name" => __( "Autor de recurso", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Autores de recursos", "custom-post-type-ui" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'autor_recurso', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => false,
		"rest_base" => "autor_recurso",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		];
	register_taxonomy( "autor_recurso", [ "recurso" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes' );