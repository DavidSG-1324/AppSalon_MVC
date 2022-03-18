<h1 class="nombre-pagina">Panel de Administración</h1>

<?php
	include __DIR__ . '/../templates/barra.php';
	include __DIR__ . '/../templates/avisos.php';
?>

<h2>Crear Servicio</h2>
<p class="descripcion-pagina">Añade un Nuevo Servicio</p>

<form class="formulario" method="POST" action="/servicios/crear">
	<?php include 'formulario.php'; ?>

	<div class="derecha">
		<input type="submit" value="Crear" class="boton">
	</div>
</form>

<?php
	$script = "
		<script src='../build/JS/crear.js'></script>
	";
?>

