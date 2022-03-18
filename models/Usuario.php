<?php

namespace Model;

class Usuario extends ActiveRecord {

	protected static $tabla = 'usuarios';
	protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono', 'email', 'password', 'admin', 'confirmado', 'token'];

	// Atributos del Objeto
	public $id;
	public $nombre;
	public $apellido;
	public $telefono;
	public $email;
	public $password;
	public $admin;
	public $confirmado;
	public $token;

	public function __construct($args = [])
	{
		$this -> id = $args['id'] ?? null;
		$this -> nombre = $args['nombre'] ?? '';
		$this -> apellido = $args['apellido'] ?? '';
		$this -> telefono = $args['telefono'] ?? '';
		$this -> email = $args['email'] ?? '';
		$this -> password = $args['password'] ?? '';
		$this -> admin = $args['admin'] ?? '0';
		$this -> confirmado = $args['confirmado'] ?? '0';
		$this -> token = $args['token'] ?? '';
	}

	// Validación Login
	public function validarLogin() {
		if(!$this -> email) {
			self :: $avisos['error'][] = "Es necesario ingresar un Email";
		} else {
			$email = self :: $db -> escape_string(filter_var($this -> email, FILTER_VALIDATE_EMAIL));
			if(!$email) {
				self :: $avisos['error'][] = "El Email no es válido";
			}
		}

		if(!$this -> password) {
			self :: $avisos['error'][] = "Es necesario ingresar la Contraseña";
		}

		return self :: $avisos;
	}

	// Validación Create
	public function validarNuevaCuenta() {
		if(!$this -> nombre) {
			self :: $avisos['error'][] = "Es necesario ingresar un Nombre";
		} elseif(strlen($this -> nombre) < 3 || is_numeric($this -> nombre)) {
			self :: $avisos['error'][] = "Nombre no válido";
		}

		if(!$this -> apellido) {
			self :: $avisos['error'][] = "Es necesario ingresar un Apellido";
		} elseif(strlen($this -> apellido) < 3 || is_numeric($this -> nombre)) {
			self :: $avisos['error'][] = "Apellido no válido";
		}

		if(!$this -> telefono) {
			self :: $avisos['error'][] = "El Número de Teléfono no se ha ingresado";
		} else {
			$this -> telefono = preg_replace('/\D/', '', $this -> telefono);
			if(strlen($this -> telefono) != 10) {
				self :: $avisos['error'][] = "El Número de Teléfono debe tener 10 dígitos";
			}
		}

		if(!$this -> email) {
			self :: $avisos['error'][] = "Es necesario agregar un Email";
		} else {
			$email = self :: $db -> escape_string(filter_var($this -> email, FILTER_VALIDATE_EMAIL));
			if(!$email) {
				self :: $avisos['error'][] = "El Email no es válido";
			}
		}

		if(!$this -> password) {
			self :: $avisos['error'][] = "Es necesario agregar una Contraseña";
		} elseif(strlen($this -> password) < 8) {
			self :: $avisos['error'][] = "La Contraseña debe ser de al menos 8 caracteres";
		}

		return self :: $avisos;
	}

	// Validación Forgotten
	public function validarEmail() {
		if(!$this -> email) {
			self :: $avisos['error'][] = "Es necesario agregar un Email";
		} else {
			$email = self :: $db -> escape_string(filter_var($this -> email, FILTER_VALIDATE_EMAIL));
			if(!$email) {
				self :: $avisos['error'][] = "El Email no es válido";
			}
		}

		return self :: $avisos;		
	}

	// Validación Recover
	public function validarPassword() {
		if(!$this -> password) {
			self :: $avisos['error'][] = "Es necesario agregar una Contraseña";
		} elseif(strlen($this -> password) < 8) {
			self :: $avisos['error'][] = "La Contraseña debe ser de al menos 8 caracteres";
		}

		return self :: $avisos;
	}

	public function comprobarUsuario($metodo) {
		$queryConsultaEmail = "SELECT * FROM " . self :: $tabla . " WHERE email = '" . $this->email . "' LIMIT 1;";

		if($metodo === 'login' || $metodo === 'forgotten') {
			$resultado = self :: consultaSQL($queryConsultaEmail);

			if(!$resultado) {
				self :: $avisos['error'][] = "El Usuario no está registrado";

				return;
			}
			return array_shift($resultado);
		}
		else if($metodo === 'create') {
			$resultado = self :: $db -> query($queryConsultaEmail);

			if($resultado -> num_rows) {
				self :: $avisos['error'][] = "El Usuario ya está registrado";

				return $resultado;
			}
		}
	}

	public function comprobarPasswordAndConfirmada($passwordAlmacenado, $confirmacion) {
		$resultado = password_verify($this -> password, $passwordAlmacenado);

		// if(!$resultado) {
		// 	self :: $avisos['error'][] = "El Password es incorrecto";

		// 	return;

		// } else if(!$confirmacion) {
		// 	self :: $avisos['error'][] = "La Cuenta aún no está confirmada";

		// 	return;
		// }

		if(!$resultado || !$confirmacion) {
			self :: $avisos['error'][] = "El Password es incorrecto o la Cuenta aún no está confirmada";

			return;
		}

		return true;
	}

	public function comprobarConfirmada($confirmacion) {
		if(!$confirmacion) {
			self :: $avisos['error'][] = "La Cuenta aún no está confirmada";

			return;
		}

		return true;
	}

	public function hashPassword() {
		$this -> password = password_hash($this -> password, PASSWORD_BCRYPT);
	}

	public function generarToken() {
		$this -> token = uniqid();
	}
}

