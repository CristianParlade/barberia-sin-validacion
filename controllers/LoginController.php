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

                    if ($usuarioDB) {
                        $resultado = $auth->verificarPasswordAndconfirmado($usuarioDB->password);
                        if ($resultado === true) {
                            $auth->iniciarSesion();
                        }

                    } else {
                    Usuario::setAlerta('error', 'El usuario no existe');
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
                if (!$usuarioDB || $usuarioDB->confirmado === '0') {
                    Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
                } else {
                    Usuario::setAlerta('exito', 'Revisa tu email');
                    $usuarioDB->enviarEmail();
                }
            }
        }




        $alertas = Usuario::getAlertas();
        $router->render('auth/olvide', [
            'alertas' => $alertas,

        ]);
    }
    public static function restablecer(Router $router)
    {
        $alertas = [];
        $error = true;
        if ($_GET['token']) {
            $usuarioDB = Usuario::where('token', s($_GET["token"]));
            if (empty($usuarioDB)) {
                Usuario::setAlerta('error', 'Token no valido');
                $error = false;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $password = new Usuario($_POST);
                $alertas = $password->validarPassword();
                if (empty($alertas)) {
                    $usuarioDB->password = s($password->password);
                    $usuarioDB->hashPassword();
                    $usuarioDB->token = null;
                    $resultado = $usuarioDB->guardar();
                    if ($resultado) {
                        header('Location: /');
                    }
                }
            }
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/restablecer', [
            'alertas' => $alertas,
            'error' => $error,
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
        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token . ' ');



        if (!empty($usuario)) {
            $usuario->token = '';
            $usuario->confirmado = 1;
            Usuario::setAlerta('exito', 'Usuario Confirmado');
            $usuario->guardar();
        } else {
            Usuario::setAlerta('error', 'No se pudo confirmar el Usuario');
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/confirmarCuenta', [
            'alertas' => $alertas,
            'token' => $token,
            'usuario' => $usuario
        ]);
    }
}
