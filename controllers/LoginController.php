<?php

namespace Controllers;

use MVC\Router;
use Model\Usuario;
use Clases\Email;

class LoginController {
	public function __construct()
	{
	}
		
	public static function login(Router $router) {
		$avisos = Usuario :: getAvisos();
		$auth = new Usuario();

		if($_SERVER['REQUEST_METHOD'] === 'POST') {
			$auth -> sincronizar($_POST);

			$avisos = $auth -> validarLogin();

			if(empty($avisos)) {

				// Revisar si el Usuario existe
				$existeUsuario = $auth -> comprobarUsuario('login');

				if($existeUsuario) {
					$usuarioDatos = $existeUsuario;

					// Revisar si el Password es correcto y la Cuenta está confirmada
					$verificacion = $auth -> comprobarPasswordAndConfirmada($usuarioDatos -> password, $usuarioDatos -> confirmado);

					if($verificacion) {

						// Autenticar al Usuario
						session_start();
						$_SESSION['login'] = true;
						$_SESSION['id'] = $usuarioDatos -> id;
						$_SESSION['nombre'] = $usuarioDatos -> nombre;
						$_SESSION['nombreApellido'] = $usuarioDatos -> nombre . " " . $usuarioDatos -> apellido;
						$_SESSION['admin'] = $usuarioDatos -> admin ?? null;

						// Redireccionar
						if($_SESSION['admin']) {
							header('Location: /admin');
						} else {
							header('Location: /cita');
						}

					} else {
						$avisos = Usuario :: getAvisos();
					}			

				} else {
					$avisos = Usuario :: getAvisos();
				}
			}
		}

		$router -> render('auth/login' , [
			'avisos' => $avisos,
			'auth' => $auth
		]);
	}

	public static function logout() {
		$_SESSION = [];

		header('Location: /');
	}

	public static function create(Router $router) {
		$avisos = Usuario :: getAvisos();
		$usuario = new Usuario();

		if($_SERVER['REQUEST_METHOD'] === "POST") {
			$usuario -> sincronizar($_POST);

			$avisos = $usuario -> validarNuevaCuenta();

			if(empty($avisos)) {

				// Revisar si el Usuario existe
				$existeUsuario = $usuario -> comprobarUsuario('create');

				if(!$existeUsuario) {

					// Hashear Password
					$usuario -> hashPassword();

					// Crear Token
					$usuario -> generarToken();

					// Guardar en la Base de Datos
					$usuario -> guardar();

					// Enviar Email
					$email = new Email($usuario -> nombre, $usuario -> email, $usuario -> token);
					$email -> enviarConfirmacion();

					// Redireccionar al Usuario
					header('Location: /message');

				} else {
					$avisos = Usuario :: getAvisos();
				}
			}
		}

		$router -> render('auth/create-account', [
			'avisos' => $avisos,
			'usuario' => $usuario
		]);
	}

	public static function message(Router $router) {
		$router -> render('auth/message' , [

		]);
	}

	public static function confirm(Router $router) {
		$token = sInput($_GET['token']);

		if(!$token) {
			header('Location: /');
		}

		$usuario = Usuario :: where('token', $token);

		if($usuario) {

			// Modificar Registro
			$usuario -> confirmado = '1';
			$usuario -> token = '';

			$usuario -> guardar();

			Usuario :: setAviso('correcto', 'Cuenta confirmada');

		} else {
			Usuario :: setAviso('error', 'Token no válido');
		}

		$avisos = Usuario :: getAvisos();

		$router -> render('auth/confirm-account' , [
			'avisos' => $avisos
		]);
	}

	public static function forgotten(Router $router) {
		$auth = new Usuario();
		$correcto = false;

		if($_SERVER['REQUEST_METHOD'] === 'POST') {
			$auth -> sincronizar($_POST);

			$avisos = $auth -> validarEmail();

			if(empty($avisos)) {

				// Revisar si el Usuario existe
				$existeUsuario = $auth -> comprobarUsuario('forgotten');
				// if($existeUsuario && $existeUsuario -> confirmado)
				if($existeUsuario) {
					$usuarioDatos = $existeUsuario;

					// Revisar si la Cuenta está confirmada
					$verificacion = $auth -> comprobarConfirmada($usuarioDatos -> confirmado);				

					if($verificacion) {

					// Crear Token
					$usuarioDatos -> generarToken();

					// Guardar en la Base de Datos
					$usuarioDatos -> guardar();

					// Enviar Email
					$email = new Email($usuarioDatos -> nombre, $usuarioDatos -> email, $usuarioDatos -> token);
					$email -> enviarInstrucciones();

					Usuario :: setAviso('correcto', 'Hemos enviado las instrucciones de recuperación de Cuenta a tu email');
					$correcto = true;

					} // else {
					// 	$avisos = Usuario :: getAvisos();
					// }

				} // else {
				// 	// Usuario :: setAviso('error', 'El Usuario no existe o la Cuenta aún no está confirmada');
				// 	$avisos = Usuario :: getAvisos();
				// }		
			}
		}

		$avisos = Usuario :: getAvisos();

		$router -> render('auth/forgotten', [
			'avisos' => $avisos,
			'auth' => $auth,
			'correcto' => $correcto
		]);
	}

	public static function recover(Router $router) {
		$token = sInput($_GET['token']);
		$error = false;
		$correcto = false;

		if(!$token) {
			header('Location: /');
		}

		$usuario = Usuario :: where('token', $token);

		if($usuario) {
			if($_SERVER['REQUEST_METHOD'] === 'POST') {
				$auth = new Usuario($_POST);

				$avisos = $auth -> validarPassword();

				if(empty($avisos)) {

					// Hashear Password
					$auth -> hashPassword();

					// Modificar Registro
					$usuario -> password = $auth -> password;
					$usuario -> token = '';

					// Guardar en la Base de Datos
					$usuario -> guardar();

					Usuario :: setAviso('correcto', 'Ahora puedes iniciar Sesión con tu Nueva Contraseña');
					$correcto = true;
				}
			}

		} else {
			Usuario :: setAviso('error', 'Token no válido');
			$error = true;
		}

		$avisos = Usuario :: getAvisos();

		$router -> render('auth/recover', [
			'avisos' => $avisos,
			'error' => $error,
			'correcto' => $correcto
		]);
	}
}

