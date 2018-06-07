<?php 
		
$licencia = get_field('seleccionar_licencia');
$icono = get_field('icono_licencia', $licencia);
		
if( $licencia && $licencia->slug != 'sin-licencia' ): ?>
	<?php if ( is_singular('recurso') ): ?> 
		<div class="recurso-flexitem licencia"> 
	<?php else: ?>
		<footer class="licencia-block">
	<?php endif; ?>
	<?php if ($icono): ?>
	<img class="aligh-left" src="<?php echo $icono; ?>">
	<?php endif; ?>
	
	<p><?php echo $licencia->description; ?></p>
	
	<?php if ( is_singular('recurso') ): ?> 
		</div> 
		<?php else: ?>
		</footer>
	<?php endif; ?>
<?php endif; ?>