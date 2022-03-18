<h1 class="nombre-pagina">Panel de Administración</h1>

<?php
	include __DIR__ . '/../templates/barra.php';
	include __DIR__ . '/../templates/avisos.php';
?>

<h2>Actualizar Servicio</h2>
<p class="descripcion-pagina">Cambia el Nombre o Precio del Servicio</p>

<form class="formulario" method="POST">
	<?php include 'formulario.php'; ?>

	<div class="derecha">
		<input type="submit" value="Guardar Cambios" class="boton">
	</div>
</form>

<?php
	$script = "
		<script src='../build/JS/actualizar.js'></script>
	";
?>

