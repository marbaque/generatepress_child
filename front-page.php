<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

		<main id="main" <?php generate_main_class(); ?>>
			<?php

			while ( have_posts() ) : the_post();
				$image = get_stylesheet_directory_uri() . '/img/dibujo.png';
				//echo '<div class="dibujo"><img src="'. $image . '"></div>';
				echo '<div class="dibujo"></div>';

				echo '<div class="texto">';
				the_title( '<h2 class="entry-title">', '</h2>' );
				the_content( sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', '_s' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				) );
				echo '</div>';
			endwhile;

			/**
			 * generate_after_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_after_main_content' );
			?>
		</main><!-- #main -->


		<section class="cursos-container">
			<h2 class="fs-title">Cursos más visitados</h2>

			<div class="cursos-flex">
				<?php $custom_query = new WP_Query( array(
					'posts_per_page' => 3,
					'meta_key' => 'post_views_count',
					'order' => 'DESC',
					'orderby' => 'meta_value_num',
					'post_type' => 'curso',
					) );
				while($custom_query->have_posts()) : $custom_query->the_post(); ?>

					<?php echo get_template_part( 'content', 'cursoitem' ); ?>

				<?php endwhile; ?>
				<?php wp_reset_postdata(); // reset the query ?>
			</div>
			<div align="center"><a class="btn1" href="<?php echo get_post_type_archive_link('curso'); ?>" title="Todos los cursos">Ver todos los cursos</a></div>
		</section>


		<section class="recursos-section">

			<h2 class="fs-title">Recursos recientes</h2>
			<div class="recursos-container">
				<?php $custom_query = new WP_Query( array(
					'post_type' => 'recurso',
					'orderby' => 'date',
					'order'   => 'DESC',
					'posts_per_page' => '8',
					) );
				while($custom_query->have_posts()) : $custom_query->the_post(); ?>

					<?php echo get_template_part( 'content', 'recursoitem' ); ?>

				<?php endwhile; ?>
				<?php wp_reset_postdata(); // reset the query ?>
			</div>
			<div align="center"><a class="btn1" href="<?php echo get_post_type_archive_link('recurso'); ?>" title="Todos los recursos">Ver todos los recursos</a></div>
		</section>


	<?php
	/**
	 * generate_after_primary_content_area hook.
	 *
	 * @since 2.0
	 */
	 do_action( 'generate_after_primary_content_area' );

	 //generate_construct_sidebars();

get_footer();
