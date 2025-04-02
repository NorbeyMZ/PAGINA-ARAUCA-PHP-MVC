<?php
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{

    public $email;
    public $nombre;
    public $token;


    public function  __construct($nombre, $email, $token){
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;

    }
    public function enviarConfirmacion(){
        //crea el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username =$_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('arauca@arauca.com');
        $mail->addAddress('arauca@arauca.com','Arauca.com' );
        $mail->Subject = 'Confirma tu cuenta';
        
        //html
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<p><strong>hola " . $this->nombre . "</strong> has creado tu cuenta en Aracua.com, confirma tu cuenta dando clik aqui</p>";
        $contenido .= "<p>Presiona aqui: <a href='" . $_ENV['APP_URL'] . "/confirmar-cuenta?token=".$this->token."'>Confirmar Cuenta</a> </p>";
        $contenido.="<p>Si tu no solicitaste esta cuenta, ignora el mensaje</p>";
        $contenido .= '</html>';
        $mail->Body = $contenido;
        //enviar el email
        $mail->send();
    }

    public function enviarInstrucciones(){
        $mail = new PHPMailer();
        $mail->isSMTP();
         
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username =$_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('arauca@arauca.com');
        $mail->addAddress('arauca@arauca.com','Arauca.com' );
        $mail->Subject = 'Restablecer tu contraseña';
        
        //html
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<p><strong>hola " . $this->nombre . "</strong> has solicitado reestablecer tu contraseña, sigue el siguente enlace</p>";
        $contenido .= "<p>Presiona aqui: <a href='" . $_ENV['APP_URL'] . "/recuperar?token=".
        $this->token."'>Restablecer contraseña</a> </p>";
        $contenido.="<p>Si tu no solicitaste esta cuenta, ignora el mensaje</p>";
        $contenido .= '</html>';
        $mail->Body = $contenido;
        //enviar el email
        $mail->send();
    }


}


?>