<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Ingresa tus datos para crear una Cuenta</p>

<?php
	include __DIR__ . '/../templates/avisos.php';
?>

<form class="formulario" method="POST" action="/create-account">
	<div class="campo">
		<label for="nombre">Nombre</label>
		<input type="text" name="nombre" placeholder="Tu Nombre" id="nombre" value="<?php echo sInput($usuario -> nombre)?>">
	</div>

	<div class="campo">
		<label for="apellido">Apellido</label>
		<input type="text" name="apellido" placeholder="Tu Apellido" id="apellido" value="<?php echo sInput($usuario -> apellido)?>">
	</div>

	<div class="campo">
		<label for="telefono">Teléfono</label>
		<input type="tel" name="telefono" placeholder="Número Telefónico" id="telefono" value="<?php echo sInput($usuario -> telefono)?>">
	</div>

	<div class="campo">
		<label for="email">Email</label>
		<input type="email" name="email" placeholder="Correo Electrónico" id="email" value="<?php echo sInput($usuario -> email)?>">
	</div>

	<div class="campo">
		<label for="password">Contraseña</label>
		<input type="password" name="password" placeholder="Contraseña" id="password">
	</div>	

	<input type="submit" value="Crear Cuenta" class="boton">
</form>

<div class="acciones">
	<a href="/">¿Ya tienes una Cuenta? Inicia Sesión</a>
	<a href="/forgotten">¿Olvidaste tu Contraseña?</a>
</div>

<?php
	$script = "
		<script src='build/JS/create-account.js'></script>
	";
?>

