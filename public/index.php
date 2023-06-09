<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\LoginController;
use Controllers\CitaController;

$router = new Router();
//iniciar sesion 
$router->get('/',[LoginController::class, 'login']);
$router->get('/logout',[LoginController::class, 'logout']);
$router->post('/',[LoginController::class, 'login']);

//recuperar Password

$router->get('/olvide',[LoginController::class, 'olvide']);
$router->post('/olvide',[LoginController::class, 'olvide']);
$router->get('/recuperar',[LoginController::class, 'recuperar']);
$router->post('/recuperar',[LoginController::class, 'recuperar']);

//crear cuenta

$router->get('/crear',[LoginController::class, 'crear']);
$router->post('/crear',[LoginController::class, 'crear']);
$router->get('/crear-cuenta',[LoginController::class, 'crear-cuenta']);

$router->get('/mensaje',[LoginController::class, 'mensaje']);
$router->get('/confirmarCuenta',[LoginController::class, 'confirmarCuenta']);

//restablecer password
$router->get('/restablecer', [LoginController::class, 'restablecer']);
$router->post('/restablecer', [LoginController::class, 'restablecer']);

//login cliente and admin 
$router->get('/cita',[CitaController::class, 'index']);
$router->post('/cita',[CitaController::class, 'index']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();