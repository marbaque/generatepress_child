<?php
/**
 * The template for displaying single posts.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php generate_article_schema( 'CreativeWork' ); ?>>
	<div class="inside-article">
		
		<?php
		$term = get_field('tipo_recurso');
		
		if( $term ):
			if( $term->slug == 'modelo-3d' || $term->slug == 'manual' || $term->slug == 'interactivo' ): ?>
			
				
				<?php 
				if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
					?>
					<figure class="portada">
						<?php the_post_thumbnail('portada-recurso'); ?>
							<figcaption>
							<?php echo get_post(get_post_thumbnail_id())->post_content; ?>
							</figcaption>
					</figure>
				<?php } ?>
			<?php endif; ?>
		<?php endif; ?>
		
		<?php if ($term){ ?>
			<span class="recurso-category"><?php echo $term->name; ?></span>
		<?php } ?>
		
		<header class="entry-header">
			<?php
			/**
			 * generate_before_entry_title hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_before_entry_title' );

			if ( generate_show_title() ) {
				the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' );
			}

			/**
			 * generate_after_entry_title hook.
			 *
			 * @since 0.1
			 *
			 * @hooked generate_post_meta - 10
			 */
			do_action( 'generate_after_entry_title' );
			?>
		</header><!-- .entry-header -->

		<?php
		/**
		 * generate_after_entry_header hook.
		 *
		 * @since 0.1
		 *
		 * @hooked generate_post_image - 10
		 */
		do_action( 'generate_after_entry_header' );
		?>

		<div class="entry-content" itemprop="text">
			
			<?php
			$file = get_field('archivo_recurso');
			if ($file) {
			?>
			<a href="<?php echo $file; ?>" class="descargar btn"><i class="fa fa-download"></i> Descargar <strong><?php echo get_field('nombre_archivo'); ?></strong></a>
			<?php
			}
			
			echo get_the_term_list( $post->ID, 'autor_recurso', '<p class="meta-info">Hecho por ', ', ', '.</p>' );
			
			the_content();
			

			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'generatepress' ),
				'after'  => '</div>',
			) );
			
			the_tags('<div class="tags"><span class="screen-reader-text">Contenido etiquetado como: </span>', ' ', '</div>'); 
			?>
			
			<?php include('inc/licencia.php'); ?>
			
			
		</div><!-- .entry-content -->

		<?php
		/**
		 * generate_after_entry_content hook.
		 *
		 * @since 0.1
		 *
		 * @hooked generate_footer_meta - 10
		 */
		do_action( 'generate_after_entry_content' );

		/**
		 * generate_after_content hook.
		 *
		 * @since 0.1
		 */
		do_action( 'generate_after_content' );
		?>
	</div><!-- .inside-article -->
</article><!-- #post-## -->
