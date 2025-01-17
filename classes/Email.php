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
        // Configuracion Gmail
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->SMTPSecure = $_ENV['EMAIL_SECURE'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        // Configuracion personalizada
        $mail->setFrom('cuentas@uptask.com', 'UpTask');
        $mail->addAddress($this->email, $this->nombre); 
        $mail->Subject = 'Confirma tu cuenta';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        // Cuerpo del Email
        $contenido = '<html>';
        $contenido .= '<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">';
        $contenido .= '<div style="background-color: #ffffff; max-width: 600px; margin: 0 auto; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">';
        $contenido .= '<h2 style="color: #333333;">Hola ' . $this->nombre . ',</h2>';
        $contenido .= '<p style="color: #333333; font-size: 16px;">Gracias por crear tu cuenta en UpTask con el correo electrónico ' . $this->email . '. Para completar el proceso de registro, por favor haz clic en el siguiente enlace:</p>';
        $contenido .= '<p style="text-align: center; margin-top: 20px;"><a style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;" href="' . $_ENV['APP_URL'] . '/confirmar?token=' . $this->token . '">Confirmar Cuenta</a></p>';
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

        // Configuracion Gmail
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->SMTPSecure = $_ENV['EMAIL_SECURE'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        // Configuracion personalizada
        $mail->setFrom('recuperacion@uptask.com', 'UpTask');
        $mail->addAddress($this->email, $this->nombre); 
        $mail->Subject = 'Reestablece tu Password';

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        // Contenido del email
        $contenido = '<html>';
        $contenido .= '<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">';
        $contenido .= '<div style="background-color: #ffffff; max-width: 600px; margin: 0 auto; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">';
        $contenido .= '<h2 style="color: #333333; font-size: 24px;">Hola ' . htmlspecialchars($this->nombre) . ',</h2>'; // Evitar XSS mediante htmlspecialchars
        $contenido .= '<p style="color: #333333; font-size: 16px;">Parece que has olvidado tu contraseña. Sigue el siguiente enlace para restablecerla:</p>';
        $contenido .= '<p style="text-align: center; margin-top: 20px;"><a style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;" href="' . $_ENV['APP_URL'] . '/restablecer?token=' . urlencode($this->token) . '">Restablecer Contraseña</a></p>';
        $contenido .= '<p style="color: #333333; font-size: 16px;">Si no solicitaste el restablecimiento de contraseña, puedes ignorar este mensaje.</p>';
        $contenido .= '</div>';
        $contenido .= '</body>';
        $contenido .= '</html>';

        $mail->Body = $contenido;

        // Enviar el email
        $mail->send();
    }
}
