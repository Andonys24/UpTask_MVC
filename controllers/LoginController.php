<?php

namespace Controllers;

use MVC\Router;

class LoginController
{
    public static function login(Router $router)
    {
        echo 'Desde login';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Codigo POST
        }
    }

    public static function logout()
    {
        echo 'Desde Cerrar Sesion';
    }

    public static function crear(Router $router)
    {
        echo 'Desde Crear';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Codigo POST
        }
    }

    public static function olvide(Router $router)
    {
        echo 'Desde Olvide mi Password';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Codigo POST
        }
    }

    public static function restablercer(Router $router)
    {
        echo 'Desde Restablecer password';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Codigo POST
        }
    }

    public static function mensaje()
    {
        echo 'Desde mensaje';
    }

    public static function confirmar()
    {
        echo 'Desde Confirmar';
    }
}
