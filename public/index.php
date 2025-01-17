<?php

require_once __DIR__ . '/../includes/app.php';

use Controllers\DashboardController;
use Controllers\LoginController;
use Controllers\ProyectoController;
use Controllers\TareaController;
use MVC\Router;

$router = new Router();

// Login
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);

// Creacion de Cuenta
$router->get('/crear', [LoginController::class, 'crear']);
$router->post('/crear', [LoginController::class, 'crear']);

// Formulario de olvide mi password
$router->get('/olvide', [LoginController::class, 'olvide']);
$router->post('/olvide', [LoginController::class, 'olvide']);

// Colocar nuevo Password
$router->get('/restablecer', [LoginController::class, 'restablecer']);
$router->post('/restablecer', [LoginController::class, 'restablecer']);

// Confirmacion de Cuenta
$router->get('/mensaje', [LoginController::class, 'mensaje']);
$router->get('/confirmar', [LoginController::class, 'confirmar']);

// Zona de proyectos
$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/gestionar-proyectos', [DashboardController::class, 'gestionar_proyecto']);
$router->get('/proyecto', [DashboardController::class, 'proyecto']);

// Api para los proyectos
$router->get('/api/proyectos', [ProyectoController::class, 'index']);
$router->post('/api/proyecto', [ProyectoController::class, 'crear']);
$router->post('/api/proyecto/actualizar', [ProyectoController::class, 'actualizar']);
$router->post('/api/proyecto/eliminar', [ProyectoController::class, 'eliminar']);

// Zona de edicion de perfil
$router->get('/perfil', [DashboardController::class, 'perfil']);
$router->post('/perfil', [DashboardController::class, 'perfil']);

$router->get('/cambiar-password', [DashboardController::class, 'cambiar_password']);
$router->post('/cambiar-password', [DashboardController::class, 'cambiar_password']);

// Api para las tareas
$router->get('/api/tareas', [TareaController::class, 'index']);
$router->post('/api/tarea', [TareaController::class, 'crear']);
$router->post('/api/tarea/actualizar', [TareaController::class, 'actualizar']);
$router->post('/api/tarea/eliminar', [TareaController::class, 'eliminar']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
