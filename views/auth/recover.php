<h1 class="nombre-pagina">Reestablecer Contraseña</h1>

<?php if(!$error && !$correcto) { ?>
	<p class="descripcion-pagina">Ingresa una Nueva Contraseña</p>
<?php } ?>

<?php
	include __DIR__ . '/../templates/avisos.php';
?>

<?php if(!$error && !$correcto) { ?>
	<form class="formulario" method="POST">
		<div class="campo">
			<label for="password">Contraseña</label>
			<input type="password" name="password" placeholder="Tu Nueva Contraseña" id="password">
		</div>

		<input type="submit" value="Guardar Contraseña" class="boton">
	</form>
<?php } ?>

<div class="acciones">
	<?php if(!$correcto) { ?>
		<a href="/">¿Ya tienes una Cuenta? Inicia Sesión</a>
		<a href="/create-account">¿Aún no tienes una Cuenta? Crea una</a>
	<?php } else if($correcto) {?>
		<a href="/">Inicia Sesión</a>
	<?php } ?>
</div>

<?php
	$script = "
		<script src='build/JS/recover.js'></script>
	";
?>

