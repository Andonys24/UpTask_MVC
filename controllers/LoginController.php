<?php

namespace Controllers;

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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Codigo POST
        }

        // Renderizar la vista
        $router->render('auth/crear', [
            'titulo' => 'Crea Tu Cuenta en UpTask'
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
        $router->render('auth/confirmar', [
            'titulo' => 'Confirma tu cuenta UpTask'
        ]);
    }
}
