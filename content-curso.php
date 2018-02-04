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
			
			<?php 

			$image = get_field('portada_del_curso');
			$size = 'portada-curso';
			$thumb = $image['sizes'][ $size ];
			$width = $image['sizes'][ $size . '-width' ];
			$height = $image['sizes'][ $size . '-height' ];
			
			if( !empty($image) ): ?>
			
				<img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" />
			<?php endif; ?>
			
			<ul>
				<?php the_title( '<li class="entry-title" itemprop="headline">', '</li>' ); ?>
				
				<?php 
				$term = get_field('area_curso');
				if( $term ): ?>
				
					<li>Área: <?php echo $term->name; ?></li>
				<?php endif; ?>
				
				
				<?php 
				$codigo = get_field('codigo_del_curso');
				if( $codigo ): ?>
					<li>Código del curso: <?php echo $codigo; ?></li>
				<?php endif; ?>
				
				<?php 
				$profe = get_field('profe');
				if( $profe ): ?>
					<li>Profesor: <?php echo $profe; ?></li>
				<?php endif; ?>
			</ul>
			
			<?php 
	
			$info = get_field('informacion_adicional');
			
			if( $info ): ?>
				<div><?php echo $info; ?></div>
			<?php endif; ?>
			
			
			<?php 
	
			$desc = get_field('descripcion_general');
			
			if( $desc ): ?>
				<h3>Descripción general del curso</h3>
				<div><?php echo $desc; ?></div>
			<?php endif; ?>
			
			
			
			
			
			
				
			
			
			
			
			
			
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
