<?php

namespace Controllers;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use MVC\Router;
use Model\Usuario;
use Classes\Email;


class LoginController
{

    public static function login(Router $router)
    {
        $alertas = [];
        $auth = new Usuario($_POST);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_abort();
            $alertas =  $auth->validarCamposLogin();

            if (empty($alertas)) {
                $usuarioDB = Usuario::where('email', s($auth->email));

                if (!$usuarioDB) {
                    $alertas['error'][] = 'El usuario NO existe';
                } else {
                    if ($resultado = $usuarioDB->verificarPasswordAndConfirmado($auth->password)) {

                        session_start();
                        $_SESSION['id'] = $usuarioDB->id;
                        $_SESSION['nombre'] = $usuarioDB->nombre . " " . $usuarioDB->apellido;
                        $_SESSION['email'] = $usuarioDB->email;
                        $_SESSION['login'] = true;

                        if ($usuarioDB->admin === '1') {
                            $_SESSION['admin'] = $usuarioDB->admin ?? null;

                            header('Location: /admin');
                        } else {

                            header('Location: /cita');
                        }
                    }
                }
            }
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [
            'auth' => $auth,
            'alertas' => $alertas,

        ]);
    }

    public static function logout()
    {
        echo 'desde logout';
    }
    public static function olvide(Router $router)
    {
        $alertas = [];
        $auth = new Usuario($_POST);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $alertas = $auth->ValidarEmail();
            if (empty($alertas)) {
                $usuarioDB = Usuario::where('email', s($auth->email));
                if ($usuarioDB && $usuarioDB->confirmado === "1") {
                    $alertas = $usuarioDB->validarUsuario();
                    $confirmar = new Email($usuarioDB->email, $usuarioDB->nombre, $usuarioDB->token);
                    $confirmar->enviarEmailParaRestablecer();

                }
            }
        }




        Usuario::getAlertas();
        $router->render('auth/olvide', [
            'alertas' => $alertas,

        ]);
    }
    public static function restablecer(Router $router)
    {
        $alertas = [];
        $token = true;
        $exito = false;
        if($_GET['token']){
            $usuarioDB = Usuario::where('token', s($_GET["token"]));
            if($usuarioDB){
                $alertas['exito'][] = 'token valido puedes cambiar tu password';
                $alertas = $usuarioDB->restablecerPassword();
                $usuarioDB->hashPassword();
                $usuarioDB->guardar();
                $exito = true;
            }else{
                $alertas['error'][] = 'token NO valido';
                $token = false;
                
            }
            
        }
        $router->render('auth/restablecer', [
            'alertas' => $alertas,
            'token' => $token,
            'exito' => $exito
        ]);
    }

    public static function crear(Router $router)
    {

        $usuario = new Usuario($_POST);

        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario->sincronizar();
            $alertas = $usuario->validarNuevaCuenta();

            if (empty($alertas)) {
                $resultado = $usuario->validarExisteUsuario();

                $alertas = Usuario::getAlertas();

                if (!$resultado->num_rows) {
                    $usuario->hashPassword();

                    $usuario->auth();

                    $usuario->creartoken();

                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);

                    $email->enviarConfirmacion();

                    $resultado = $usuario->guardar();

                    if ($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
        }
        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas,
        ]);
    }

    public static function mensaje(Router $router)
    {

        $router->render('auth/mensaje');
    }

    public static function confirmarCuenta(Router $router)
    {
        $alertas = [];
        $token = $_GET['token'];
        $usuario = Usuario::where('token', $token . ' ');



        if (!empty($usuario)) {
            $usuario->token = '';
            $usuario->confirmado = 1;
            Usuario::setAlerta('exito', 'Usuario Confirmado');
            $alertas = Usuario::getAlertas();
            $usuario->guardar();
        } else {
            Usuario::setAlerta('error', 'No se pudo confirmar el Usuario');
            $alertas = Usuario::getAlertas();
        }

        $router->render('auth/confirmarCuenta', [
            'alertas' => $alertas,
            'token' => $token,
            'usuario' => $usuario
        ]);
    }
}
