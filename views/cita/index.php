<?php
	include __DIR__ . '/../templates/barra.php';
?>

<h1 class="nombre-pagina">Crear Cita</h1>

<div id="app">
	<nav class="tabs">
		<button type="button" data-paso="1">Servicios</button>
		<button type="button" data-paso="2">Información Cita</button>
		<button type="button" data-paso="3">Resumen</button>
	</nav>

	<div class="seccion" id="paso-1">
		<h2>Servicios</h2>
		<p class="descripcion-paso">Elige los Servicios que Necesites</p>
		<div class="listado-servicios" id="servicios">

		</div>
	</div>

	<div class="seccion" id="paso-2">
		<h2>Datos</h2>
		<p class="descripcion-paso">Elige la Fecha y Hora de la Cita</p>

		<form class="formulario">
			<div class="campo">
				<label for="nombre">Nombre</label>
				<input
					id="nombre" 
					type="text"
					placeholder="Tu Nombre" 
					value="<?php echo $nombreApellido; ?>"
					disabled
				>
			</div>

			<div class="campo">
				<label for="fecha">Fecha</label>
				<input
					id="fecha"
					type="date"
					min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>"
				>
			</div>

			<div class="campo">
				<label for="hora">Hora</label>
				<input
					id="hora"
					type="time"
				>
			</div>

			<input id="id" type="hidden" value="<?php echo $id; ?>">	
		</form>
	</div>

	<div class="seccion contenido-resumen" id="paso-3">
		<h2>Resumen</h2>
		<p class="descripcion-paso">Verifica que la Información sea correcta</p>
	</div>

	<div class="paginacion">
		<button class="boton" id="anterior">&laquo; Anterior</button>
		<button class="boton" id="siguiente">Siguiente &raquo;</button>
	</div>
</div>

<?php
	$script = "
		<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
		<script src='build/JS/app.js'></script>
	";
?>

