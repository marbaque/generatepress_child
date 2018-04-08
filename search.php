<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

	<section id="primary" <?php generate_content_class(); ?>>
		<main id="main" <?php generate_main_class(); ?>>
			<?php

			if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title">
						<?php
						printf( // WPCS: XSS ok.
							/* translators: 1: Search query name */
							__( 'Search Results for: %s', 'generatepress' ),
							'<span>' . get_search_query() . '</span>'
						);
						?>
					</h1>
				</header><!-- .page-header -->

				<section class="results">				
					<?php while ( have_posts() ) : the_post(); ?>
						
						<h3>
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
								<span>
									<?php $postType = get_post_type_object(get_post_type($post));
										if ($postType) {
										    echo esc_html($postType->labels->singular_name);
										} 
									?>: </span>
								<?php the_title(); ?>
							</a>
						</h3>
						<?php if(the_excerpt()): ?>
							<p><?php the_excerpt(); ?></p>
						<?php endif; ?>
						
	
					<?php endwhile; ?>
				</section>
			<?php
				generate_content_nav( 'nav-below' );

			else :

				get_template_part( 'no-results', 'search' );

			endif;
			?>
		</main><!-- #main -->
	</section><!-- #primary -->

	<?php

	 generate_construct_sidebars();

get_footer();
