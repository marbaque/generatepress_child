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
			if( !$term->slug == 'modelo-3d' || $term->slug == 'manual' || $term->slug == 'interactivo' ): ?>
			
				
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
			
			<!-- aqui van el autor, el boton de descarga y la licencia -->
			<div class="recurso-flexwrap">
				<!-- autor -->
				<?php echo get_the_term_list( $post->ID, 'autor_recurso', '<div class="recurso-flexitem autores"><h4>Creado por</h4><p class="meta-info">', ', ', '</p></div>' ); ?>
				<!-- boton de descargar -->
				
				<?php $file = get_field('archivo_recurso'); ?>
				<?php if( $file ): ?>
			
					<?php 
					
					$mime = $file["mime_type"];
					$url = $file["url"];
					$id = $file["id"];
					$filesize = filesize( get_attached_file( $id ) );
					$filesize = size_format($filesize, 2);
					$title = $file["title"];
					//echo '<pre>';
						//var_dump( $file );
					//echo '</pre>';
					?>
					
					<div class="recurso-flexitem descargar">
						<a class="filelink" title="Enlace de descarga" href="<?php echo $url; ?>">Descargar</a>
					<p><?php echo "<i>" . $title. "</i> (" . $mime . ", " . $filesize . ")"; ?></p>
					</div>
				
				<?php endif; ?>
				
				<!-- licencia -->
				<?php include('inc/licencia.php'); ?>
			</div>
			
			
			<?php the_content(); ?>
			
			<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'generatepress' ),
				'after'  => '</div>',
			) );
			?>
			
			<?php 
			the_tags('<div class="tags"><h5>Palabras clave:</h5><span class="screen-reader-text">Contenido etiquetado como: </span>', ' ', '</div>'); 
			?>
			
			
			
			
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
