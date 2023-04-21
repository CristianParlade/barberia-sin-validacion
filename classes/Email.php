<?php 
namespace Classes;
use PHPMailer\PHPMailer\PHPMailer;


class Email {
    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }
    public function enviarConfirmacion(){
        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Port = 587;
        $mail->Priority = 1;
        $mail->Username = 'parladecristian.19972020@gmail.com';
        $mail->Password = 'dxkgbwzuilocxrcs';
        
        $mail->SMTPSecure = 'tls';
            //configurar el contenido del mail
        $mail->setFrom('parladecristian.19972020@gmail.com', 'Cristian'); //esto quiere decir quien envia el email. 
        $mail->addAddress('parladecristian.19972020@gmail.com');//direccion donde se van a recibir 
        $mail->Subject = 'Tienes un nuevo mensaje';//este es el mensaje que nos avisara de una nuevo email en mailtrap

        //habilitar HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $contenido = "<html>";
        $contenido .= "<p>Confirma tu email presionando en el siguiente enlace</p>";
        $contenido .= "<p><a href='http://localhost:3000/confirmarCuenta?token=".$this->token."'>Pulsa el aquí</a></p>";
        $contenido .= "<p>Si no has solicitado este cambio ignora este mensaje</p>";
        $contenido .= "</html>";

        $mail->Subject = 'Tienes un nuevo mensaje';
        $mail->Body = $contenido;
        $mail->AltBody = 'esto es texto alternativo sin utilizar html';

        $mail->send();
    }
}