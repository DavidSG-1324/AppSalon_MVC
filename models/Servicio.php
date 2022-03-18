<?php

namespace Model;

class Servicio extends ActiveRecord {

	protected static $tabla = 'servicios';
	protected static $columnasDB = ['id', 'nombre', 'precio'];

	public $id;
	public $nombre;
	public $precio;

	public function __construct($args = [])
	{
		$this -> id = $args['id'] ?? null;
		$this -> nombre = $args['nombre'] ?? '';
		$this -> precio = $args['precio'] ?? '';
	}

	public function validar() {
		if(!$this -> nombre) {
			self :: $avisos['error'][] = "Es necesario ingresar un Nombre de Servicio";
		} elseif(is_numeric($this -> nombre)) {
			self :: $avisos['error'][] = "Nombre no válido";
		}

		if(!$this -> precio) {
			self :: $avisos['error'][] = "Es necesario ingresar un Precio";
		} elseif(!is_numeric($this -> precio) || $this -> precio <= 0) {
			self :: $avisos['error'][] = "Precio no válido";
		}

		return self :: $avisos;
	}
}

