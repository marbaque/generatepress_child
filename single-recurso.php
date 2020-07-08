<?php

/**
 * The Template for displaying all single posts.
 *
 * @package GeneratePress
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

get_header();
?>
<?php

$term = get_field('tipo_recurso');
$oEmbed = get_field('video_url');

if (get_field('video_url')) : ?>
	<div class="video-wrap">
		<div class="video-contenedor">
			<?php the_field('video_url'); ?>
		</div>
		<div class="video-dark-background" aria-hidden></div>
	</div>
<?php endif; ?>

<div id="primary" <?php generate_content_class(); ?>>
	<main id="main" <?php generate_main_class(); ?>>

		<?php
		while (have_posts()) : the_post();

			get_template_part('content', 'recurso');

			// If comments are open or we have at least one comment, load up the comment template.
			if (comments_open() || '0' != get_comments_number()) : ?>

				<div class="comments-area">
					<?php comments_template(); ?>
				</div>

		<?php endif;

		endwhile;

		/**
		 * generate_after_main_content hook.
		 *
		 * @since 0.1
		 */
		do_action('generate_after_main_content');
		?>
	</main><!-- #main -->
</div><!-- #primary -->

<?php
/**
 * generate_after_primary_content_area hook.
 *
 * @since 2.0
 */
do_action('generate_after_primary_content_area');

generate_construct_sidebars();

get_footer();
