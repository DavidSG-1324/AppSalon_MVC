<h1 class="nombre-pagina">Recuperar Cuenta</h1>

<?php if(!$correcto) { ?>
	<p class="descripcion-pagina">Ingresa el Email con el que te registraste</p>
<?php } ?>

<?php
	include __DIR__ . '/../templates/avisos.php';
?>

<?php if(!$correcto) { ?>
	<form class="formulario" method="POST" action="/forgotten">
		<div class="campo">
			<label for="email">Email</label>
			<input type="email" name="email" placeholder="Tu Correo Electrónico" id="email"
			value="<?php echo $key === 'error' ? sInput($auth -> email) : ''; ?>">
		</div>

		<input type="submit" value="Recuperar Cuenta" class="boton">
	</form>
<?php } ?>

<div class="acciones">
	<a href="/">¿Ya tienes una Cuenta? Inicia Sesión</a>
	<a href="/create-account">¿Aún no tienes una Cuenta? Crea una</a>
</div>

<?php
	$script = "
		<script src='build/JS/forgotten.js'></script>
	";
?>

