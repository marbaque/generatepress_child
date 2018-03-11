<?php
/**
 * The template for displaying posts within the loop.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php generate_article_schema( 'CreativeWork' ); ?>>
	<?php 
	$term = get_field('tipo_recurso');
	
	if ( $term ): ?>
		<span class="recurso-category"><?php echo $term->name; ?></span>
	<?php endif; ?>

	<?php if ( has_post_thumbnail() ) : ?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="thumb-recurso">
			<?php the_post_thumbnail( 'thumbnail' ); ?>
		</a>
	<?php else: ?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="thumb-recurso"><span class="recurso-icon"></span></a>
	
	<?php endif; ?>
	
	<div class="inside-article">
		
		<header class="entry-header">
			<?php
			the_title( sprintf( '<p class="entry-title" itemprop="headline"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></p>' );
			?>
		</header><!-- .entry-header -->

		<div class="entry-content" itemprop="text">
			<?php
			the_excerpt();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'generatepress' ),
				'after'  => '</div>',
			) );
			?>
		</div><!-- .entry-content -->
	</div><!-- .inside-article -->
	
	
</article><!-- #post-## -->
