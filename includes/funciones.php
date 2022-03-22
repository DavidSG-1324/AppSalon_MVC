<?php

use Model\Cita;
use Model\Servicio;

// Debuguear
function debug($variable) : string {
	echo "<pre>";
	var_dump($variable);
	echo "</pre>";
	exit;
}

function debug2($variable) {
	echo "<pre>";
	var_dump($variable);
	echo "</pre>";
}

// Escapar y Sanitizar HTML
function sInput($html) : string {
	$sanitizado = htmlspecialchars($html);
	return $sanitizado;
}

// Revisar usuario autenticado
function isAuth() : void {
	// if(!isset($_SESSION['login'])) {
	// 	header('Location: /');
	// }
	if(!$_SESSION['login']) {
		header('Location: /');
	}
}

// Revisar administrador autenticado
function isAdmin() : void {
	if(!$_SESSION['admin']) {
		header('Location: /');
	}
}

// Revisar si es el último elemento del grupo en la Base de Datos
function isLast(string $actual, string $siguiente) : bool {
	if($actual !== $siguiente) {
		return true;		
	}
	return false;
}

// Validar id
function validateId($url, $tipo) {
	$id = $_GET['id'] ?? $_POST['id'];
	$id = filter_var($id, FILTER_VALIDATE_INT);

	if($tipo === 'cita') {
		if(!$id || !Cita :: find($id)) {
			header("Location: $url");
		}
	} elseif($tipo === 'servicio') {
		if(!$id || !Servicio :: find($id)) {
			header("Location: $url");
		}
	}

	return $id;
}

// Ordenar Hora
function horaOrdenada($hora) {
	$horaOrdenActual = explode(":", $hora);
	if($horaOrdenActual[0] < 12) {
		$horaOrdenNuevo = $horaOrdenActual[0] . ':' . $horaOrdenActual[1] . ' a.m.';
	} else if($horaOrdenActual[0] === '12') {
		$horaOrdenNuevo = $horaOrdenActual[0] . ':' . $horaOrdenActual[1] . ' p.m.';
	} else {
		$horaOrdenNuevo = $horaOrdenActual[0] - 12 . ':' . $horaOrdenActual[1] . ' p.m.';
	}

	return $horaOrdenNuevo;
}

//Ordenar Teléfono
function telefonoOrdenado($telefono) {
	for($i = 0; $i < 10; $i++) {
		$num[] = substr($telefono, $i, 1);
	}

	$telefonoOrdenNuevo = $num[0] . $num[1];
	$telefonoOrdenNuevo .= '-';
	$telefonoOrdenNuevo .= $num[2] . $num[3] . $num[4] . $num[5];
	$telefonoOrdenNuevo .= '-';
	$telefonoOrdenNuevo .= $num[6] . $num[7] . $num[8] . $num[9];

	return $telefonoOrdenNuevo;
}

// Seleccionar Mensaje
function mostrarAviso($resultado) {
	$mensaje = "";

	switch($resultado) {
		case 1:
			$mensaje = "Servicio creado correctamente";
			break;
		case 2:
			$mensaje = "Actualización correcta";
			break;
		case 3:
			$mensaje = "Servicio eliminado";
			break;
		case 4:
			$mensaje = "Cita eliminada";			
		default:
			break;	
	}

	return $mensaje;
}

