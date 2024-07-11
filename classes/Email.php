<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{
    protected $email;
    protected $nombre;
    protected $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion()
    {
        // Configuracion MailTrap
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '9513fdc5f5135d';
        $mail->Password = '8a2bb879758caa';

        // Configuracion personaliada
        $mail->setFrom('cuentas@uptask.com');
        $mail->addAddress('cuentas@uptask.com', 'uptask.com');
        $mail->Subject = 'Confirma tu cuenta';

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        // Cuerpo del Email
        $contenido = '<html>';
        $contenido .= '<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">';
        $contenido .= '<div style="background-color: #ffffff; max-width: 600px; margin: 0 auto; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">';
        $contenido .= '<h2 style="color: #333333;">Hola ' . $this->nombre . ',</h2>';
        $contenido .= '<p style="color: #333333; font-size: 16px;">Gracias por crear tu cuenta en UpTask con el correo electrónico ' . $this->email . '. Para completar el proceso de registro, por favor haz clic en el siguiente enlace:</p>';
        $contenido .= '<p style="text-align: center; margin-top: 20px;"><a style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;" href="http://localhost:3000/confirmar?token=' . $this->token . '">Confirmar Cuenta</a></p>';
        $contenido .= '<p style="color: #333333; font-size: 16px;">Si no creaste esta cuenta, puedes ignorar este mensaje.</p>';
        $contenido .= '</div>';
        $contenido .= '</body>';
        $contenido .= '</html>';

        $mail->Body = $contenido;

        // Enviar el Email
        $mail->send();
    }

    public function enviarInstrucciones()
    {

        // Configuracion MailTrap
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '9513fdc5f5135d';
        $mail->Password = '8a2bb879758caa';

        $mail->setFrom('cuentas@uptask.com');
        $mail->addAddress('cuentas@uptask.com', 'uptask.com');
        $mail->Subject = 'Reestablece tu Password';

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        // Contenido del email
        $contenido = '<html>';
        $contenido .= '<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">';
        $contenido .= '<div style="background-color: #ffffff; max-width: 600px; margin: 0 auto; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">';
        $contenido .= '<h2 style="color: #333333; font-size: 24px;">Hola ' . htmlspecialchars($this->nombre) . ',</h2>'; // Evitar XSS mediante htmlspecialchars
        $contenido .= '<p style="color: #333333; font-size: 16px;">Parece que has olvidado tu contraseña. Sigue el siguiente enlace para restablecerla:</p>';
        $contenido .= '<p style="text-align: center; margin-top: 20px;"><a style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;" href="http://localhost:3000/restablecer?token=' . urlencode($this->token) . '">Restablecer Contraseña</a></p>';
        $contenido .= '<p style="color: #333333; font-size: 16px;">Si no solicitaste el restablecimiento de contraseña, puedes ignorar este mensaje.</p>';
        $contenido .= '</div>';
        $contenido .= '</body>';
        $contenido .= '</html>';

        $mail->Body = $contenido;
        
        // Enviar el email
        $mail->send();
    }
}
