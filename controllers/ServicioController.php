<?php

namespace Controllers;

use MVC\Router;
use Model\Servicio;

class ServicioController {
	public function __construct()
	{
	}

	public static function index (Router $router) {
		if(!isset($_SESSION)) {
			session_start();
		}

		isAdmin();

		$servicios = Servicio :: all();

		$resultado = $_GET['resultado'] ?? null;

		$router -> render('servicios/index', [
			'nombre' => $_SESSION['nombre'],
			'servicios' => $servicios,
			'resultado' => $resultado
		]);
	}

	public static function create(Router $router) {
		if(!isset($_SESSION)) {
			session_start();
		}

		isAdmin();

		$avisos = Servicio :: getAvisos();
		$servicio = new Servicio();

		if($_SERVER['REQUEST_METHOD'] === 'POST') {
			$servicio -> sincronizar($_POST);

			$avisos = $servicio -> validar();

			if(empty($avisos)) {
				$servicio -> guardar();

				header('Location: /servicios?resultado=1');
			}
		}

		$router -> render('servicios/crear', [
			'nombre' => $_SESSION['nombre'],
			'avisos' => $avisos,
			'servicio' => $servicio
		]);
	}

	public static function update(Router $router) {
		if(!isset($_SESSION)) {
			session_start();
		}

		isAdmin();

		$id = validateId('/servicios', 'servicio');

		$servicio = Servicio :: find($id);
		$avisos = Servicio :: getAvisos();		

		if($_SERVER['REQUEST_METHOD'] === 'POST') {
			$servicio -> sincronizar($_POST);

			$avisos = $servicio -> validar();

			if(empty($avisos)) {
				$servicio -> guardar();

				header('Location: /servicios?resultado=2');
			}
		}

		$router -> render('servicios/actualizar', [
			'nombre' => $_SESSION['nombre'],
			'avisos' => $avisos,
			'servicio' => $servicio
		]);
	}

	public static function eliminate() {
		if(!isset($_SESSION)) {
			session_start();
		}

		isAdmin();

		if($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id = validateId('/servicios', 'servicio');

			if($id) {
				$servicio = Servicio :: find($id);

				$servicio -> eliminar();

				header('Location: /servicios?resultado=3');
			}			
		}
	}
}

