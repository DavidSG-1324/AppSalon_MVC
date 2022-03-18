<?php

namespace Model;

class ActiveRecord {
	// Base de Datos
	protected static $db;
	protected static $tabla = '';
	protected static $columnasDB = [];	

	// Errores
	protected static $avisos = [];

	public function __construct($args = [])
	{
	}

	// Definir la conexión a la Base de Datos
	public static function setDB($database) {
		self :: $db = $database;
	}

	// Crear un Arreglo con los Atributos del Objeto / Mapea las columnas de la Base de Datos con el Objeto en memoria
	public function datos() {
		$datos = [];
		forEach(static :: $columnasDB as $columna) {
			if($columna === 'id') continue;
			$datos[$columna] = $this -> $columna;
		}
		return $datos;
	}

	// Sanitización
	public function sanitizarDatos() {
		$datos = $this -> datos();
		$datosSanitizados = [];
		forEach($datos as $key => $value) {
			$datosSanitizados[$key] = self :: $db -> escape_string($value);
		}
		return $datosSanitizados;
	}

	public function guardar() {
		if(!$this -> id) {
			// Crear nuevo registro
			$resultado = $this -> crear();
		} else {
			// Actualizar registro
			$resultado = $this -> actualizar();
		}

		return $resultado;
	}

	public function crear() {
		$datos = $this -> sanitizarDatos();

		$stringDatosKeys = join(', ', array_keys($datos));
		$stringDatosValues = join("', '", array_values($datos));

		// Insertar en la Base de Datos
		$queryInsercion = "INSERT INTO " . static :: $tabla . " (";		
		$queryInsercion .= $stringDatosKeys;
		$queryInsercion .= ") VALUES ('";
		$queryInsercion .= $stringDatosValues;
		$queryInsercion .= "');";
		// return ['query' => $queryInsercion];
		$insercion = self :: $db -> query($queryInsercion);

		$resultado = [
			'insercion' => $insercion,
			'id' => self :: $db -> insert_id
		];

		return $resultado;
	}

	public function actualizar() {
		$datos = $this -> sanitizarDatos();

		$valores = [];
		forEach($datos as $key => $value) {
			$valores[] = "$key = '$value'";
		}
		$stringValores = join(', ', array_values($valores));

		// Insertar en la Base de Datos
		$queryActualizacion = "UPDATE " . static :: $tabla . " SET ";
		$queryActualizacion .= $stringValores;
		$queryActualizacion .= " WHERE id = " . self :: $db -> escape_string($this -> id);
		$queryActualizacion .= " LIMIT 1;";

		$actualizacion = self :: $db -> query($queryActualizacion);

		return $actualizacion;
	}

	public function eliminar() {
		$queryEliminacion = "DELETE FROM " . static :: $tabla . " WHERE id = " . self :: $db -> escape_string($this -> id);
		$queryEliminacion .= " LIMIT 1;";

		$eliminacion = self :: $db -> query($queryEliminacion);

		if($eliminacion) {
			// Redireccionar al usuario
			// header('Location: /admin?resultado1=3&resultado2=true');
			header('Location: ../admin?resultado1=3&resultado2=true');			
		}	
	}

	public static function setAviso($tipo, $mensaje) {
		static :: $avisos[$tipo][] = $mensaje; 
	}

	public static function getAvisos() {
		return static :: $avisos;
	}

	// Listar todos los registros
	public static function all() {
		$queryConsulta = "SELECT * FROM " . static :: $tabla . ";"; // "static" modificador de acceso, busca un Atributo en la clase que hereda el Método

		$resultado = self :: consultaSQL($queryConsulta);;
		return $resultado;
	}

	// Listar cierta cantidad de registros
	public static function get($limite) {
		$queryConsulta = "SELECT * FROM " . static :: $tabla . " LIMIT $limite;";

		$resultado = self :: consultaSQL($queryConsulta);;
		return $resultado;
	}

	// Listar registros por id
	public static function find($id) {
		$queryConsulta = "SELECT * FROM " . static :: $tabla . " WHERE id = $id;";

		$resultado = self :: consultaSQL($queryConsulta);
		return array_shift($resultado);
	}

	// Listar registros por valor
	public static function where($columna, $valor) {
		$queryConsulta = "SELECT * FROM " . static :: $tabla . " WHERE $columna = '$valor';";

		$resultado = self :: consultaSQL($queryConsulta);
		return array_shift($resultado);
	}

	// Listar registros por consulta específica, Consulta Plana de SQL, cuando los métodos del Modelo no son suficientes
	public static function specificQuery($query) {
		$queryConsulta = $query;

		$resultado = self :: consultaSQL($queryConsulta);
		return $resultado;
	}

	public static function consultaSQL($query) {
		// Consultar la Base de Datos
		$resultado = self :: $db -> query($query);

		// Iterar
		$array = [];
		while($registro = $resultado -> fetch_assoc()) {
			$array[] = self :: crearObjeto($registro);
		}

		// Liberar memoria
		$resultado -> free();

		// Devolver resultados
		return $array;
	}

	protected static function crearObjeto($registro) {
		$objeto = new static;

		forEach($registro as $key => $value) {
			if(property_exists($objeto, $key)) {
				$objeto -> $key = $value;
			}
		}
		return $objeto;
	}

	// Sincronizar el Objeto en memoria con los cambios realizados
	public function sincronizar($args = []) {
		forEach($args as $key => $value) {
			if(property_exists($this, $key) && !is_null($value)) {
				$this -> $key = $value;
			}
		}
	}
}

