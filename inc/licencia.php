<?php 
		
$licencia = get_field('seleccionar_licencia');
$icono = get_field('icono_licencia', $licencia);
		
if( $licencia ): ?>
	<footer class="licencia-block">
		<h4>Licencia</h4>
		<?php if ($icono): ?>
		<img class="aligh-left" src="<?php echo $icono; ?>">
		<?php endif; ?>
		<p><strong><?php echo $licencia->name; ?></strong></p>
		<p><?php echo $licencia->description; ?></p>
	</footer>
<?php endif; ?>