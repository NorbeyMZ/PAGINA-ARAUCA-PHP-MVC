<?php
namespace Controller;

use Model\AdminReserva;
use Model\Servicio;
use MVC\Router;

class ReservaController {
    public static function index(Router $router) {
        session_start();
        isAuth();

        $router->render('reserva/index', [
            'nombre' => $_SESSION['nombre'],
            'id' => $_SESSION['id']
        ], 'layout_reservas');
    }

    public static function mireserva(Router $router) {
        session_start();
        isAuth();

        $usuarioId = $_SESSION['id']; // Obtener ID del usuario autenticado
        
        // Consulta SQL para obtener todas las reservas del usuario actual
        $consulta = "SELECT 
                        reservas.id, reservas.fecha, reservas.hora, 
                        CONCAT(usuarios.nombre, ' ', usuarios.apellido) AS cliente,
                        usuarios.email, usuarios.telefono, 
                        servicios.nombre AS servicio, servicios.precio  
                    FROM reservas  
                    LEFT JOIN usuarios ON reservas.usuarioid = usuarios.id  
                    LEFT JOIN reservaservicios ON reservaservicios.reservaid = reservas.id 
                    LEFT JOIN servicios ON servicios.id = reservaservicios.servicioid 
                    WHERE reservas.usuarioid = '$usuarioId'"; // Filtrar solo por el usuario autenticado
        
        $reservas = AdminReserva::SQL($consulta);

        
        
        $router->render('usuarios/vermireserva', [
            'nombre' => $_SESSION['nombre'],
            'reservas' => $reservas,
            
        ], 'layout_reservas');
    }

    public static function infoservicio(Router $router) {
        session_start();
        isAuth();

        $id = $_GET['id'] ?? null;
        if (!is_numeric($id)) {
            header('Location: /servicios');
            exit;
        }
        $servicio = Servicio::find($id);
        $router->render('usuarios/infoservicios', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
        ], 'layout_reservas');
    }
}
?>
