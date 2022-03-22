<?php

namespace Controllers;

use Model\Servicio;
use Model\Cita;
use Model\CitaServicio;

class APIController {
	public function __construct()
	{
	}

	public static function index() {
		$servicios = Servicio :: all();
		echo json_encode($servicios, JSON_UNESCAPED_UNICODE);
	}

	public static function create() {

		// Crea la Cita y devuelve el id
		$cita = new Cita($_POST);

		$resultado = $cita -> guardar();

		$citaId = $resultado['id'];

		// Relaciona la Cita y los Servicios
		$serviciosId = explode(",", $_POST['serviciosId']);

		forEach($serviciosId as $servicioId) {
			$args = [
				'citaId' => $citaId,
				'servicioId' => $servicioId
			];

			$citaServicio = new CitaServicio($args);

			$citaServicio -> guardar();
		}

		echo json_encode($resultado);
	}

	public static function eliminate() {
		if($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id = validateId($_SERVER['HTTP_REFERER'], 'cita');

			if($id) {
				$cita = Cita :: find($id);

				$cita -> eliminar();

				header('Location: ' . $_SERVER['HTTP_REFERER'] . '&resultado=4');
			}
		}
	}
}

