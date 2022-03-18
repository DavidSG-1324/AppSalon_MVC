<?php

// require_once __DIR__ . '/../includes/app.php';
require_once __DIR__ . '/../includes/app_deployment.php';

use MVC\Router;
use Controllers\LoginController;
use Controllers\CitaController;
use Controllers\APIController;
use Controllers\AdminController;
use Controllers\ServicioController;

$router = new Router();

// Inicio de Sesión
$router -> get('/', [LoginController :: class, 'login']);
$router -> post('/', [LoginController :: class, 'login']);
$router -> get('/logout', [LoginController :: class, 'logout']);

// Creación de Cuenta
$router -> get('/create-account', [LoginController :: class, 'create']);
$router -> post('/create-account', [LoginController :: class, 'create']);

// Confirmar Cuenta
$router -> get('/message', [LoginController :: class, 'message']);
$router -> get('/confirm-account', [LoginController :: class, 'confirm']);

// Recuperación de Password
$router -> get('/forgotten', [LoginController :: class, 'forgotten']);
$router -> post('/forgotten', [LoginController :: class, 'forgotten']);
$router -> get('/recover', [LoginController :: class, 'recover']);
$router -> post('/recover', [LoginController :: class, 'recover']);

// Área Privada
$router -> get('/cita', [CitaController :: class, 'index']);
$router -> get('/admin', [AdminController :: class, 'index']);

// API
$router -> get('/API/servicios', [APIController :: class, 'index']);
$router -> post('/API/citas', [APIController :: class, 'create']);
$router -> post('/API/eliminar', [APIController :: class, 'eliminate']);

// CRUD Servicios
$router -> get('/servicios', [ServicioController :: class, 'index']);
$router -> get('/servicios/crear', [ServicioController :: class, 'create']);
$router -> post('/servicios/crear', [ServicioController :: class, 'create']);
$router -> get('/servicios/actualizar', [ServicioController :: class, 'update']);
$router -> post('/servicios/actualizar', [ServicioController :: class, 'update']);
$router -> post('/servicios/eliminar', [ServicioController :: class, 'eliminate']);

$router -> comprobarRutas();

