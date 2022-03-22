<?php

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv :: createImmutable(__DIR__);
$dotenv -> safeLoad();

require 'funciones.php';
require 'database_deployment.php';

// Conexión a la Base de Datos

use Model\ActiveRecord;

ActiveRecord :: setDB($db);

