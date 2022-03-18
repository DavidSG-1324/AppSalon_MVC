<?php
	forEach($avisos as $key => $mensajes):
		forEach($mensajes as $mensaje):
?>
			<!-- <div class="aviso <?php echo $key; ?>"><?php echo $mensaje; ?></div> -->
			<input type="hidden" value="<?php echo $mensaje; ?>">
<?php
		endforEach;
	endforEach;
?>

