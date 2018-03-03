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
	$image = get_field('portada_del_curso');
	$size = 'portada-curso';
	$thumb = $image['sizes'][ $size ];

	
	if( !empty($image) ): ?>
		<img src="<?php echo $thumb; ?>">
	<?php endif; ?>

	
	<div class="inside-article">
		
		<header class="entry-header">
			<?php
			the_title( sprintf( '<p class="entry-title" itemprop="headline"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></p>' );
			?>
		</header><!-- .entry-header -->

			
			<?php
			$codigo = get_field('codigo_del_curso');
			if( $codigo ): ?>
				<p class="curso_codigo">Código del curso: <?php echo $codigo; ?></p>
			<?php endif; ?>
	</div><!-- .inside-article -->
	
	
</article><!-- #post-## -->
