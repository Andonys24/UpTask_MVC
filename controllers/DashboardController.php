<?php

namespace Controllers;

use Model\Proyecto;
use Model\Usuario;
use MVC\Router;

class DashboardController
{
    public static function index(Router $router)
    {
        session_start();
        isAuth();
        $proyectos = Proyecto::belogsTo('propietarioId', $_SESSION['id']);
        $router->render('dashboard/index', [
            'titulo' => 'Proyectos',
            'proyectos' => $proyectos
        ]);
    }


    public static function proyecto(Router $router)
    {
        session_start();
        isAuth();
        $token = $_GET['id'];
        if (!$token) header('Location: /dashboard');
        $proyecto = Proyecto::where('url', $token);
        if ($proyecto->propietarioId !== $_SESSION['id']) {
            header('Location: /dashboard');
        }
        // Revisar que la persona que visita el proyecto es quien lo creo
        $router->render('dashboard/proyecto', [
            'titulo' => $proyecto->proyecto
        ]);
    }

    public static function gestionar_proyecto(Router $router)
    {
        session_start();
        isAuth();
        $proyecto = new Proyecto($_POST);

        $router->render('dashboard/gestionar-proyectos', [
            'titulo' => 'Gestiona Tus Proyectos'
        ]);

    }

    public static function perfil(Router $router)
    {
        session_start();
        isAuth();
        $alertas = [];

        $usuario = Usuario::find($_SESSION['id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarPerfil();

            if (empty($alertas)) {
                // Verificar si el email ya existe
                $existeUsuario = Usuario::where('email', $usuario->email);
                if ($existeUsuario && $existeUsuario->id !== $usuario->id) {
                    // Mostrar mensaje de error
                    Usuario::setAlerta('error', 'Este email ya está asociado a otra cuenta.');
                } else {
                    // Guardar cambios
                    $usuario->guardar();
                    Usuario::setAlerta('exito', 'Cambios Guardados correctamente.');

                    // Asignar nombre y email nuevo
                    $_SESSION['nombre'] = $usuario->nombre;
                    $_SESSION['email'] = $usuario->email;
                }
            }
        }
        $alertas = $usuario->getAlertas();

        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil',
            'alertas' => $alertas,
            'usuario' => $usuario
        ]);
    }

    public static function cambiar_password(Router $router)
    {
        session_start();
        isAuth();

        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = Usuario::find($_SESSION['id']);
            // Sinconizar con los datos del usuario
            $usuario->sincronizar($_POST);

            $alertas = $usuario->nuevoPassword();
            if (empty($alertas)) {
                // Validar que el password actual sea el correcto
                $resultado = $usuario->comprobarPassword();
                if ($resultado) {
                    // asignar nuevo password
                    $usuario->password = $usuario->password_nuevo;
                    // Eliminando datos temporales
                    unset($usuario->password_actual);
                    unset($usuario->password2);
                    unset($usuario->password_nuevo);
                    // hasheando nuevo password
                    $usuario->hashPassword();
                    // Guardar Cambios
                    $resultado = $usuario->guardar();

                    if ($resultado) {
                        Usuario::setAlerta('exito', 'Contrasena Actualizada correctamente.');
                    }
                } else {
                    Usuario::setAlerta('error', 'Password Incorrecto');
                }
            }
        }
        $alertas = Usuario::getAlertas();
        $router->render('dashboard/cambiar-password', [
            'titulo' => 'Cambiar password',
            'alertas' => $alertas
        ]);
    }
}
