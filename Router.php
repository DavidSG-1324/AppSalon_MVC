<?php

namespace MVC;

class Router {
	public $rutasGET = [];
	public $rutasPOST = [];

	public function __construct() {
	}

	public function get($url, $fn) {
		$this -> rutasGET[$url] = $fn;
	}

	public function post($url, $fn) {
		$this -> rutasPOST[$url] = $fn;
	}

	public function comprobarRutas() {
		// $urlActual = $_SERVER['PATH_INFO'] ?? '/';
		$urlActual = $_SERVER['REQUEST_URI'] === '' ? '/' : $_SERVER['REQUEST_URI']; // para Deployment

		$metodo = $_SERVER['REQUEST_METHOD'];

		if($metodo === "GET") {
			$fn = $this -> rutasGET[$urlActual] ?? null;
		} else {
			$fn = $this -> rutasPOST[$urlActual] ?? null;
		}

		// Protección de Rutas
		session_start();
		$auth = $_SESSION['login'] ?? null;

		$rutas_protegidas = [
			'/API/servicios',
			'/API/citas',
			'/API/eliminar'
		];

		if(in_array($urlActual, $rutas_protegidas) && !$auth) {
			header('Location: /');
		}

		if($fn) {
			call_user_func($fn, $this);
		} else {
			echo "Página no Encontrada";
		}
	}

	// Mostrar Vista
	public function render($view, $datos = []) {
		forEach($datos as $key => $value) {
			$$key = $value;
		}

		ob_start(); // Almacena en memoria el código subsecuente

		// include __DIR__ . '/views/' . $view . '.php';
		include __DIR__ . "/views/$view.php";

		$contenido = ob_get_clean(); // Asigna el código a la variable y limpia el buffer

		include __DIR__ . '/views/layout.php';
	}
}

