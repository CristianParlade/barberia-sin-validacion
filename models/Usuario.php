<?php

namespace Model;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Classes\Email;
use Model\ActiveRecord;
use PHPMailer\PHPMailer\PHPMailer;

class Usuario extends ActiveRecord
{

    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
    }
    public function validarNuevaCuenta()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }
        if (!$this->apellido) {
            self::$alertas['error'][] = 'El apellido es obligatorio';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'El password es obligatorio';
        }
        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El password debe tener al menos 6 caracteres';
        }

        return self::$alertas;
    }
    public function validarExisteUsuario()
    {
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query);

        if ($resultado->num_rows) {
            self::$alertas['error'][] = 'El usuario ya existe';
        }
        return $resultado;
    }

    public function validarEmail()
    {
        if (!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        return self::$alertas;
    }
    public function enviarEmail()
    {   
        $token = $this->crearToken();
        $email = new Email($this->email, $this->nombre, $this->token);
        $this->guardar();
        $email->enviarEmailParaRestablecer();
    }

    public function hashPassword()
    {

        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function auth()
    {
        $atributos = $this->sanitizarAtributos();

        $query = "INSERT INTO " . self::$tabla . " (";
        $query .= join(' ,', array_keys($atributos));
        $query .= ") VALUES ( '";
        $query .= join("' ,'", array_values($atributos));
        $query .= "')";
    }

    public function crearToken()
    {
        $this->token = uniqid();
    }

    public function validarCamposLogin()
    {
        if (!$this->email) {
            self::$alertas['error'][] = '¿Cuál es tu email?';
        }
        if (!$this->password) {
            self::$alertas['error'][] = '¿Cuál es el password?';
        }

        return self::$alertas;
    }


    public function verificarPasswordAndconfirmado($password)
    {
       $resultado = password_verify($this->password, $password);
       if(!$resultado){
        self::$alertas['error'][] = 'El password o el usuario no son correctos';
        return self::$alertas;
       }
       return $resultado;
    }

    public function validarPassword()
    {
        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
        }
        return self::$alertas;
    }

    public function iniciarSesion(){
        
        session_start();
        $_SESSION['id'] = $this->id;
        $_SESSION['nombre'] = $this->nombre . " " . $this->apellido;
        $_SESSION['email'] = $this->email;
        $_SESSION['login'] = true;

        if ($this->admin === '1') {
            $_SESSION['admin'] = $this->admin ?? null;

            header('Location: /admin');
        } else {

            header('Location: /citas');
        }
    }
}

    // public function crearUsuario(){
    //     $atributos = self::sanitizarAtributos();


    //     $query = "INSERT INTO " .static::$tabla. "(";
    //     $query.= join(', ', array_keys($atributos));
    //     $query.= ") VALUES ('";
    //     $query.= join("', '", array_keys($atributos));
    //     $query.= ")" ;

    // }
