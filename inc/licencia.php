<?php 
		
$licencia = get_field('seleccionar_licencia');
$icono = get_field('icono_licencia', $licencia);
		
if( $licencia && $licencia->slug != 'sin-licencia' ): ?>
	<?php if ( is_singular('recurso') ): ?> 
		<div class="recurso-flexitem licencia"> 
	<?php endif; ?>
	<h4>Licencia</h4>
	<?php if ($icono): ?>
	<img class="aligh-left" src="<?php echo $icono; ?>">
	<?php endif; ?>
	<p><strong><?php echo $licencia->name; ?></strong></p>
	<p><?php echo $licencia->description; ?></p>
	
	<?php if ( is_singular('recurso') ): ?> 
		</div> 
	<?php endif; ?>
<?php endif; ?>