<?php
/**
 * The template for displaying Tag archive.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>
	<div class="page-header"><h1 class="page-title">Recursos educativos abiertos</h1></div>
	<?php 
	//do_action( 'generate_archive_title' );
	the_archive_title('<div class="page-header"><h2 class="page-title">Palabra clave: ', '</div></h2>');
	?>
	
	<section id="primary" <?php generate_content_class(); ?>>
		<main id="main" <?php generate_main_class(); ?>>
			<?php
			/**
			 * generate_before_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_before_main_content' );

			if ( have_posts() ) :
				?>
				<div class="recursos-container">
				<?php
				
					while ( have_posts() ) : the_post();
	
						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', 'recursoitem' );
	
					endwhile;
				?>
				</div>
				<?php
				generate_content_nav( 'nav-below' );

			else :

				get_template_part( 'no-results', 'archive' );

			endif;

			/**
			 * generate_after_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_after_main_content' );
			?>
		</main><!-- #main -->
	</section><!-- #primary -->

	<?php
	/**
	 * generate_after_primary_content_area hook.
	 *
	 * @since 2.0
	 */
	 do_action( 'generate_after_primary_content_area' );

	 //generate_construct_sidebars();

get_footer();
