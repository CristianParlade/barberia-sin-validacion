<?php 

namespace Controllers;

use MVC\Router;
use Model\Usuario;
use Model\ActiveRecord;

class LoginController{
    public static function login(Router $router){

        $router->render('auth/login');
    
    }

    
    public static function logout(){
        echo 'desde logout';
    }
    public static function olvide(Router $router){
        $router->render('auth/olvide',[

        ]);
    }
    public static function recuperar(){
        echo 'recuperar';
    }
    
    public static function crear( Router $router){

        $usuario = new Usuario;

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            }
        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
    
            
            
        ]);

    }
}