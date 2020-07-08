<?php

/**
 * The template for displaying posts within the loop.
 *
 * @package GeneratePress
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php generate_article_schema('CreativeWork'); ?>>

	<?php $term = get_field('tipo_recurso'); ?>

	<div class="thumb-recurso">
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
			<?php if (has_post_thumbnail()) : ?>

				<?php the_post_thumbnail('thumbnail'); ?>
			<?php else : ?>
				<div class="recurso-icon" aria-hidden="true"></div>
			<?php endif; ?>
		</a>

		<?php if ($term) : ?>
			<span class="recurso-category"><?php echo $term->name; ?></span>
		<?php endif; ?>
	</div>

	<div class="inside-article">

		<?php
		the_title(sprintf('<h3 class="entry-title" itemprop="headline"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h3>');
		?>

		<div class="entry-content" itemprop="text">
			<?php
			the_excerpt();
			?>
		</div><!-- .entry-content -->
	</div><!-- .inside-article -->


</article><!-- #post-## -->