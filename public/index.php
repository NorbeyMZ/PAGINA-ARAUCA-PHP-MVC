<?php 

require_once __DIR__ . '/../includes/app.php';

use Controller\AdminController;
use Controller\APIcontroller;
use Controller\LoginController;
use Controller\ReservaController;
use Controller\ServicioController;
use Controller\UsuarioController;
use MVC\Router;

$router = new Router();

// iniciar sesion
$router->get('/', [LoginController::class, 'login']);

$router->post('/', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class,'logout']);

//recuperar pasword
$router->get('/olvide', [LoginController::class, 'olvide']);
$router->post('/olvide', [LoginController::class, 'olvide']);
$router->get('/recuperar', [LoginController::class, 'recuperar']);
$router->post('/recuperar', [LoginController::class, 'recuperar']);

//crear cuenta  
$router->get('/crear-cuenta', [LoginController::class, 'crear']);
$router->post('/crear-cuenta', [LoginController::class, 'crear']);

//confirmar ceunta 
$router->get('/confirmar-cuenta', [LoginController::class, 'confirmar']);
$router->get('/mensaje', [LoginController::class, 'mensaje']);

//area privada
$router->get('/reservas', [ReservaController::class, 'index']);
$router->get('/admin', [AdminController::class, 'index']);
//informe
$router->get('/generar_informe', [AdminController::class, 'informeReservas']);
$router->post('/generar_informe', [AdminController::class, 'informeReservas']);


//api de reservas
$router->get('/api/servicios',[APIcontroller::class, 'index']); 
$router->post('/api/reserva', [APIcontroller::class,'guardar']);
$router->post('/api/eliminar', [APIcontroller::class,'eliminar']);

//CRUD de Servicios
$router->get('/servicios', [ServicioController::class,'index']);
$router->get('/servicios/crear', [ServicioController::class,'crear']);
$router->post('/servicios/crear', [ServicioController::class,'crear']);
$router->get('/servicios/actualizar', [ServicioController::class,'actualizar']);
$router->post('/servicios/actualizar', [ServicioController::class,'actualizar']);
$router->get('/servicios/eliminar', [ServicioController::class,'eliminar']);
$router->post('/servicios/eliminar', [ServicioController::class,'eliminar']);

$router->get('/servicios/informeActividad', [ServicioController::class,'informeActividad']);
$router->post('/servicios/informeActividad', [ServicioController::class,'informeActividad']);


//usuario

$router->get('/usuarios', [ServicioController::class,'usuarios']);
$router->get('/usuarios/useractualizar', [ServicioController::class,'actualizarusuario']);
$router->post('/usuarios/useractualizar', [ServicioController::class,'actualizarusuario']);
$router->get('/usuarios/deshabilitar', [ServicioController::class,'deshabilitar']);
$router->post('/usuarios/deshabilitar', [ServicioController::class,'deshabilitar']);
$router->get('/usuarios/habilitar', [ServicioController::class, 'habilitar']);
$router->post('/usuarios/habilitar', [ServicioController::class, 'habilitar']);

$router->get('/servicios/verpublicacion', [ServicioController::class,'verpublicacion']);
$router->post('/servicios/verpublicacion', [ServicioController::class,'verpublicacion']);


//CRUD de Editar datos

$router->get('/usuario/actualiza', [UsuarioController::class,'actualiza']);
$router->post('/usuario/actualiza', [UsuarioController::class,'actualiza']);
$router->get('/vermireserva', [ReservaController::class,'mireserva']);
$router->post('/vermireserva', [ReservaController::class,'mireserva']);
$router->get('/infoservicios', [ReservaController::class,'infoservicio']);
$router->post('/infoservicios', [ReservaController::class,'infoservicio']);






// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();  