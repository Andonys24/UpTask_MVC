<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{
    public static function login(Router $router)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Codigo POST
        }

        // Renderizar la vista
        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesion'
        ]);
    }

    public static function logout()
    {
        echo 'Desde Cerrar Sesion';
    }

    public static function crear(Router $router)
    {
        $usuario = new Usuario;
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validadNuevaCuenta();
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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Codigo POST
        }

        $router->render('auth/olvide', [
            'titulo' => 'Olvide mi Password'
        ]);
    }

    public static function restablecer(Router $router)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Codigo POST
        }

        $router->render('auth/restablecer', [
            'titulo' => 'Restablecer Password'
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