<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia Sesión con tus Datos</p>

<?php
	include __DIR__ . '/../templates/avisos.php';
?>

<form class="formulario" method="POST" action="/">
	<div class="campo">
		<label for="email">Email</label>
		<input type="email" name="email" placeholder="Tu Correo Electrónico" id="email" value="<?php echo sInput($auth -> email); ?>">
	</div>

	<div class="campo">
		<label for="password">Contraseña</label>
		<input type="password" name="password" placeholder="Tu Contraseña" id="password">
	</div>

	<input type="submit" value="Iniciar Sesión" class="boton">
</form>

<div class="acciones">
	<a href="/create-account">¿Aún no tienes una Cuenta? Crea una</a>
	<a href="/forgotten">¿Olvidaste tu Contraseña?</a>
</div>

<?php
	$script = "
		<script src='build/JS/login.js'></script>
	";
?>

