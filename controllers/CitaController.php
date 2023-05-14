<?php
namespace Controllers;

use MVC\Router;
use Model\citas;
use Model\servicios;
use Model\Usuario;

class CitaController{
    public static function index(Router $router)
    {   
        session_start();
        $nombre = $_SESSION['nombre'];
        $router->render('cita/index', [
            'nombre' => $nombre
        ]);
    }
}