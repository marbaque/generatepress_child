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
		/**
		 * generate_before_content hook.
		 *
		 * @since 0.1
		 *
		 * @hooked generate_featured_page_header_inside_single - 10
		 */
		do_action( 'generate_before_content' );
		?>




		<div class="entry-content" itemprop="text">
			<?php
			//the_content();
			?>
			<div class="portada__wrap">
				<?php
				$image = get_field('portada_del_curso');
				$size = 'portada-curso';
				$thumb = $image['sizes'][ $size ];
				$placeholder = get_stylesheet_directory_uri() . '/img/placeholder.png';

				if( ($image) ): ?>

					<div class="portada-curso" aria-hideen="true">
						<img src="<?php echo $thumb; ?>" alt="<?php echo $image['alt']; ?>">
						<span><?php echo $image['description']; ?></span>
					</div>

				<?php else: ?>
					<div class="portada-curso" style="background-image: url(<?php echo $placeholder; ?>)" aria-hideen="true"></div>
				<?php endif; ?>

				<div class="curso__info">
					<div class="curso__info-inside">
						<ul>
							<?php the_title( '<li class="seccion-title" itemprop="headline">', '</li>' ); ?>

							<?php
							$codigo = get_field('codigo_del_curso');
							if( $codigo ): ?>
								<li class="curso_codigo">Código del curso: <?php echo $codigo; ?></li>
							<?php endif; ?>

							<?php
							$term = get_field('area_curso');
							if( $term ): ?>

								<li class="curso_area"><?php echo $term->name; ?></li>
							<?php endif; ?>

							<?php
							$profe = get_field('profe');
							if( $profe ): ?>
								<li class="curso_profe"><?php echo $profe; ?></li>
							<?php endif; ?>
						</ul>

						<?php

						$info = get_field('informacion_adicional');
						if( $info ): ?>
							<div class="curso_info"><?php echo $info; ?></div>
						<?php endif; ?>
					</div>
				</div><!-- curso__info -->
			</div><!-- portada__wrap -->

			<h3>Descripción general del curso</h3>
			<?php the_content(); ?>


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
