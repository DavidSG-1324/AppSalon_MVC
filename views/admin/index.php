<h1 class="nombre-pagina">Panel de Administración</h1>

<?php
	include __DIR__ . '/../templates/barra.php';
?>

<h2>Buscar Citas</h2>

<div class="busqueda">
	<form>
		<div class="campo">
			<label for="fecha">Fecha</label>
			<input
				id="fecha"
				type="date"
				value="<?php echo $fecha; ?>"
			>
		</div>
	</form>
</div>

<?php $mensaje = mostrarAviso(intval($resultado));
	  if($mensaje): ?>
		<p class="aviso correcto"><?php echo $mensaje; ?></p>
<?php endif; ?>

<?php if(count($citas) === 0): ?>
		<h3>No se han reservado citas</h3>
<?php endif; ?>

<div class="citas-admin">
	<ul class="citas">

	<?php
		$ID = '0';
		forEach($citas as $key => $cita):
			if(($cita -> id !== $ID) && $ID !== '0'): ?>
				</li>
	  <?php endif;

	    	if($cita -> id !== $ID): ?>
				<li>
  					<p>ID: <span><?php echo $cita -> id; ?></span></p>
					<p>Hora: <span><?php echo horaOrdenada($cita -> hora); ?></span></p>
					<p>Cliente: <span><?php echo $cita -> cliente; ?></span></p>
					<p>Teléfono: <span><?php echo telefonoOrdenado($cita -> telefono); ?></span></p>
					<p>Email: <span><?php echo $cita -> email; ?></span></p>

					<h3>Servicios</h3>
	  
			  <?php $total = 0;
			endif; ?>

			<p class="servicio"><?php echo $cita -> servicio . ", $ " . $cita -> precio; ?></p>
			
		<?php
			$ID = $cita -> id;

			$idActual = $cita -> id;
			$idProximo = $citas[$key + 1] -> id ?? '';

			$cantidadServicio = intval($cita -> precio);
			$total += $cantidadServicio;

			if(isLast($idActual, $idProximo)): ?>
				<p>Total: <span><?php echo "$ " . $total; ?></span></p>

				<form method="POST" action="/API/eliminar">
					<input type="hidden" name="id" value="<?php echo $cita -> id; ?>">
					<input type="submit" value="Eliminar" class="boton-eliminar">
				</form>
	  <?php endif;

		endforEach; ?>

		</li>
	</ul>
</div>

<?php
	$script = "
		<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
		<script src='build/JS/admin.js'></script>		
	";
?>

