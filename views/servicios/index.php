<h1 class="nombre-pagina">Panel de Administración</h1>

<?php
	include __DIR__ . '/../templates/barra.php';
?>

<h2>Servicios</h2>
<p class="descripcion-pagina">Administración de Servicios</p>

<?php $mensaje = mostrarAviso(intval($resultado));
	  if($mensaje): ?>
		<p class="aviso correcto"><?php echo $mensaje; ?></p>
<?php endif; ?>

<div class="servicios-admin">
	<ul class="servicios">
		<?php forEach($servicios as $key => $servicio): ?>
			<li>
				<p># <span><?php echo $key + 1; ?></span></p>
				<p>Nombre: <span><?php echo $servicio -> nombre; ?></span></p>
				<p>Precio: <span><?php echo "$ " . $servicio -> precio; ?></span></p>

				<div class="acciones">
					<a href="/servicios/actualizar?id=<?php echo $servicio -> id; ?>" class="boton">Actualizar</a>

					<form method="POST" action="/servicios/eliminar">
						<input type="hidden" name="id" value="<?php echo $servicio -> id; ?>">
						<input type="submit" value="Eliminar" class="boton-eliminar">
					</form>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
</div>

<?php
	$script = "
		<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
		<script src='build/JS/servicios.js'></script>
	";
?>

