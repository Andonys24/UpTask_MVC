<?php

namespace Controllers;

use Model\Proyecto;

class ProyectoController
{
    public static function index()
    {
        session_start();
        isAuth();
        $proyectos = Proyecto::belogsTo('propietarioId', $_SESSION['id']);
        echo json_encode(['proyectos' => $proyectos]);
    }

    public static function crear()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            isAuth();

            // Todo bien, instanciar y crear el proyecto
            $proyecto = new Proyecto($_POST);
            $proyecto->propietarioId = $_SESSION['id'];
            $proyecto->url = md5(uniqid());
            $resultado = $proyecto->guardar();

            $respuesta = [
                'tipo' => 'exito',
                'id' => $resultado['id'],
                'url' => $proyecto->url,
                'propietarioId' => $proyecto->propietarioId,
                'mensaje' => 'Proyecto Creado Correctamente',
            ];
            echo json_encode($respuesta);
        }
    }

    public static function actualizar()
    {
        session_start();
        isAuth();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $proyecto = Proyecto::where('propietarioId', $_SESSION['id']);
            if (!$proyecto) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un error al actualizar la tarea'
                ];
                echo json_encode($respuesta);
                return;
            }

            $proyecto = new Proyecto($_POST);
            $resultado = $proyecto->guardar();

            if ($resultado) {
                $respuesta = [
                    'tipo' => 'exito',
                    'id' => $proyecto->id,
                    'proyecto' => $proyecto->proyecto,
                    'url' => $proyecto->url,
                    'propietarioId' => $proyecto->propietarioId,
                    'mensaje' => 'Proyecto Actualizado Correctamente'
                ];
                echo json_encode(['respuesta' => $respuesta]);
            }
        }
    }

    public static function eliminar()
    {
        session_start();
        isAuth();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $proyecto = Proyecto::where('propietarioId', $_SESSION['id']);
            if (!$proyecto) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un error al eliminar la tarea'
                ];
                echo json_encode($respuesta);
                return;
            }
            $proyecto = new Proyecto($_POST);
            $resultado = $proyecto->eliminar();

            $resultado = [
                'resultado' => $resultado,
                'tipo' => 'exito',
                'mensaje' => 'Proyecto Eliminado Correctamente'
            ];

            echo json_encode($resultado);
        }
    }
}
