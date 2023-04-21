<?php
namespace Controllers;


use MVC\Router;
use Model\Usuario;
use Classes\Email;


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

        $usuario = new Usuario($_POST);

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $usuario->sincronizar();
            $alertas = $usuario->validarNuevaCuenta();
            
            if(empty($alertas)){
               $resultado = $usuario->validarExisteUsuario();

               $alertas = Usuario::getAlertas();
               
               if(!$resultado->num_rows){
                $usuario->hashPassword();

                $usuario->auth();

                $usuario->creartoken();
                
                $email = new Email($usuario->nombre, $usuario->email, $usuario->token);

                $email->enviarConfirmacion();

                $resultado = $usuario->guardar();

                if($resultado){
                    header('Location: /mensaje');
                }
                

               }
            }
        
            
            }
        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas,
            'resultado' => $resultado
        ]);

    }

    public static function mensaje(Router $router){

        $router->render('auth/mensaje');
    }

    public static function confirmarCuenta(Router $router){
        $alertas = [];
        $token = $_GET['token'];
        $resultado = Usuario::where('token', $token.' ');
        
        if(!empty($resultado)){
            Usuario::setAlerta('exito', 'Usuario Confirmado');
            $alertas = Usuario::getAlertas();
        }else{
            Usuario::setAlerta('error', 'No se pudo confirmar el Usuario');
            $alertas = Usuario::getAlertas();
        }

        $router->render('auth/confirmarCuenta', [
            'alertas' => $alertas,
            'token' => $token,
            'resultado' => $resultado
        ]);

    }


}


