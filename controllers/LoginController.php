<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{
    public static function login(Router $router)
    {
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);

            $alertas = $usuario->validarLogin();

            if (empty($alertas)) {
                // Verificar si el usuario existe
                $usuario = Usuario::where('email', $usuario->email);

                if (!$usuario || !$usuario->confirmado) {
                    Usuario::setAlerta('error', 'Usuario no encontrado o no esta confirmado');
                } else {
                    // El usuario existe
                    // Comprobar Password
                    if (password_verify($_POST['password'], $usuario->password)) {
                        // Iniciar sesion
                        session_start();
                        // Llenar la session con datos que necesitaremos
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        // Redireccionar
                        header('Location: /dashboard');
                    } else {
                        Usuario::setAlerta('error', 'Password Incorrecto.');
                    }
                }
            }
        }

        $alertas = Usuario::getAlertas();
        // Renderizar la vista
        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesion',
            'alertas' => $alertas
        ]);
    }

    public static function logout()
    {
        session_start();
        $_SESSION = [];
        header('Location: /');
    }

    public static function crear(Router $router)
    {
        $usuario = new Usuario;
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();
            if (empty($alertas)) {
                $existeUsuario = Usuario::where('email', $usuario->email);
                if ($existeUsuario) {
                    Usuario::setAlerta('error', 'El usuario ya esta registrado');
                    $alertas = Usuario::getAlertas();
                } else {
                    // Hashear Password
                    $usuario->hashPassword();
                    // Eliminar Password2
                    unset($usuario->password2);
                    // Generar Token
                    $usuario->crearToken();
                    // Crear un nuevo usuario
                    $resultado = $usuario->guardar();
                    // Enviar Email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();

                    if ($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
        }

        // Renderizar la vista
        $router->render('auth/crear', [
            'titulo' => 'Crea Tu Cuenta en UpTask',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function olvide(Router $router)
    {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();
            if (empty($alertas)) {
                // Buscar el usuario
                $usuario = Usuario::where('email', $usuario->email);
                if ($usuario && $usuario->confirmado) {     // Encontro el usuario
                    // Generar Token
                    $usuario->crearToken();
                    unset($usuario->password2);
                    // Actualizar el usuario
                    $usuario->guardar();
                    // Enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();
                    // Imprimir la alerta
                    Usuario::setAlerta('exito', 'Hemos enviado las intrucciones a tu Email.');
                } else {
                    Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado.');
                }
            }
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide', [
            'titulo' => 'Olvide mi Password',
            'alertas' => $alertas
        ]);
    }

    public static function restablecer(Router $router)
    {
        $alertas = [];
        $mostrar = true;
        $token = s($_GET['token']);
        if (!$token) header('Location: /');
        // Identificar el usuario con este token
        $usuario = Usuario::where('token', $token);
        if (empty($usuario)) {
            Usuario::setAlerta('error', 'Token no Valido.');
            // Esconder Input
            $mostrar = false;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Anadir nuevo password
            $usuario->sincronizar($_POST);
            // Validar nuevo password
            $alertas = $usuario->validarPassword($usuario->password);

            if (empty($alertas)) {
                // Hashear nuevo password
                $usuario->hashPassword();
                unset($usuario->password2);
                // Eliminar token
                $usuario->token = null;
                // Guardar cambios en la BD
                $usuario->guardar();
                // Redireccionar
                header('Location: /');
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/restablecer', [
            'titulo' => 'Restablecer Password',
            'alertas' => $alertas,
            'mostrar' => $mostrar
        ]);
    }

    public static function mensaje(Router $router)
    {
        $router->render('auth/mensaje', [
            'titulo' => 'Cuenta creda Exitosamente'
        ]);
    }

    public static function confirmar(Router $router)
    {
        $alertas = [];
        $token = s($_GET['token']);
        if (!$token) header('Location: /');

        // Encontrar al usuario con este token
        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            // No se encontro el token
            Usuario::setAlerta('error', 'Token No valido');
        } else {
            // Confirmar la cuenta
            $usuario->confirmado = 1;
            $usuario->token = null;
            unset($usuario->password2);
            // Guardar en la base de datos
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta Comprobada Correctamente');
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/confirmar', [
            'titulo' => 'Confirma tu cuenta UpTask',
            'alertas' => $alertas
        ]);
    }
}
