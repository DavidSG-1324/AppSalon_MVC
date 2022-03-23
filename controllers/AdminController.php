<?php

namespace Controllers;

use MVC\Router;
use Model\AdminCita;

class AdminController {
	public function __construct()
	{
	}

	public static function index(Router $router) {
		if(!isset($_SESSION)) {
			session_start();
		}

		isAdmin();

		$fecha = $_GET['fecha'] ?? date('Y-m-d');
		$fechaArray = explode('-', $fecha);

		if(!checkdate($fechaArray[1], $fechaArray[2], $fechaArray[0])) {
			header('Location: /404');
		}

		$resultado = $_GET['resultado'] ?? null;

		$queryConsulta = "SELECT ";
		$queryConsulta .= "citas.id, citas.hora, concat(usuarios.nombre,' ',usuarios.apellido) as cliente, ";
		$queryConsulta .= "usuarios.telefono, usuarios.email, servicios.nombre as servicio, servicios.precio ";
		$queryConsulta .= "FROM citas ";
		$queryConsulta .= "LEFT OUTER JOIN usuarios ";
		$queryConsulta .= "ON citas.usuarioId = usuarios.id ";
		$queryConsulta .= "LEFT OUTER JOIN citasservicios ";
		$queryConsulta .= "ON citasservicios.citaId = citas.id ";
		$queryConsulta .= "LEFT OUTER JOIN servicios ";
		$queryConsulta .= "ON citasservicios.servicioId = servicios.id ";
		$queryConsulta .= "WHERE fecha = '$fecha';";

		$citas = AdminCita :: specificQuery($queryConsulta);

		$router -> render('admin/index', [
			'nombre' => $_SESSION['nombre'],
			'fecha' => $fecha,
			'citas' => $citas,
			'resultado' => $resultado
		]);
	}
}

