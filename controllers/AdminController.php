<?php
namespace Controller;

use Mpdf\Mpdf;        
use Model\AdminReserva;
use MVC\Router;

class AdminController {
    public static function index (Router $router){
        session_start();

        isAdmin();

        // Obtener la fecha seleccionada, por defecto la fecha de hoy
        $fecha = $_GET['fecha'] ?? date('Y-m-d');

        // Verificar si la fecha es válida
        $fechas = explode("-", $fecha);
        if (!checkdate($fechas[1], $fechas[2], $fechas[0])) {
            header('location: /400');
            exit();
        }

        // Consulta SQL para obtener las reservas
        // Si hay fecha seleccionada, filtrar por esa fecha
        // Si no hay reservas para esa fecha, mostrar todas las reservas
        $consulta = "SELECT reservas.id, reservas.fecha, reservas.hora, CONCAT(usuarios.nombre, ' ', usuarios.apellido) AS cliente, ";
        $consulta .= "usuarios.email, usuarios.telefono, servicios.nombre AS servicio, servicios.precio ";
        $consulta .= "FROM reservas ";
        $consulta .= "LEFT JOIN usuarios ON reservas.usuarioid = usuarios.id ";
        $consulta .= "LEFT JOIN reservaservicios ON reservaservicios.reservaid = reservas.id ";
        $consulta .= "LEFT JOIN servicios ON servicios.id = reservaservicios.servicioid ";

        // Si se ha seleccionado una fecha específica, filtrar por esa fecha
        if ($fecha) {
            $consulta .= "WHERE reservas.fecha = '{$fecha}' ";
        }

        // Ejecutar la consulta
        $reservas = AdminReserva::SQL($consulta);

        // Si no hay reservas para la fecha seleccionada, mostrar todas las reservas
        if (count($reservas) === 0) {
            $consulta = "SELECT reservas.id, reservas.fecha, reservas.hora, CONCAT(usuarios.nombre, ' ', usuarios.apellido) AS cliente, ";
            $consulta .= "usuarios.email, usuarios.telefono, servicios.nombre AS servicio, servicios.precio ";
            $consulta .= "FROM reservas ";
            $consulta .= "LEFT JOIN usuarios ON reservas.usuarioid = usuarios.id ";
            $consulta .= "LEFT JOIN reservaservicios ON reservaservicios.reservaid = reservas.id ";
            $consulta .= "LEFT JOIN servicios ON servicios.id = reservaservicios.servicioid ";
            // Si no hay reservas para la fecha seleccionada, obtener todas
            $reservas = AdminReserva::SQL($consulta);
        }

        // Renderizar la vista
        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre'],
            'reservas' => $reservas,
            'fecha' => $fecha
        ], 'layout_admin');
    }

    public static function informeReservas(Router $router) {
        session_start();
        isAdmin();
    
        // Obtener la fecha seleccionada o usar la fecha actual por defecto
        $fecha = $_GET['fecha'] ?? date('Y-m-d');
    
        // Consulta para obtener reservas de la fecha seleccionada
        $consulta = "SELECT reservas.id, reservas.fecha, reservas.hora, 
                    CONCAT(usuarios.nombre, ' ', usuarios.apellido) AS cliente, 
                    usuarios.email, usuarios.telefono, 
                    servicios.nombre AS servicio, servicios.precio 
                    FROM reservas 
                    LEFT JOIN usuarios ON reservas.usuarioid = usuarios.id 
                    LEFT JOIN reservaservicios ON reservaservicios.reservaid = reservas.id 
                    LEFT JOIN servicios ON servicios.id = reservaservicios.servicioid 
                    WHERE reservas.fecha = '{$fecha}'";
    
        $reservas = AdminReserva::SQL($consulta);
    
        // Si no hay reservas para esa fecha
        if (empty($reservas)) {
            $mpdf = new Mpdf();
            $mpdf->WriteHTML('<h1>No hay reservas para la fecha seleccionada.</h1>');
            $mpdf->Output(); // Mostrar el PDF
            exit();  // Detener ejecución para evitar otros procesos
        }
    
        // Si hay reservas, generar el informe agrupado
        $mpdf = new Mpdf();
    
        // Ruta de la imagen (logo)
        $logoPath = __DIR__ .'/../src/img/logo.jpg';  // Ruta absoluta
    
        // Verificar si la imagen existe
        $html = '<div style="display: flex; align-items: center; padding-top: 10px; margin: 0;">
        <img src="' . $logoPath . '" width="100" alt="Logo" style="margin-right: 10px; opacity: 0.5;">
        <div style="border-top: 2px solid #000; border-bottom: 2px solid #000; padding: 5px 10px; margin: 0;">
            <h3 style="text-align: center; margin: 0;">Informe de las reservas</h3>
        </div>
    </div>';
        
        // Agrupar las reservas por usuario
        $usuarioIdAnterior = null;
        $total = 0;

        foreach ($reservas as $reserva) {
            // Si es un usuario nuevo, mostrar sus datos
            if ($usuarioIdAnterior !== $reserva->id) {
                // Si no es el primer usuario, mostrar el total de la reserva anterior
                if ($usuarioIdAnterior !== null) {
                    $html .= "<p><strong>Total para : \$" . number_format($total, 2) . "</strong></p>";
                }
    
                // Mostrar los datos del usuario
                
                $html .= "<h3>Reserva ID: {$reserva->id}</h3>";
                $html .= "<p>Fecha: {$reserva->fecha}</p>";
                $html .= "<p>Hora: {$reserva->hora}</p>";
                $html .= "<p>Cliente: {$reserva->cliente}</p>";
                $html .= "<p>Email: {$reserva->email}</p>";
                $html .= "<p>Teléfono: {$reserva->telefono}</p>";
    
                // Inicializar el total de la reserva
                $total = 0;
                $html .= "<div>";
            }
    
            // Mostrar los servicios de la reserva (actividad)
        
            $html .= "<hr>";
            $html .= "<p>{$reserva->servicio} - \$" . number_format($reserva->precio, 2) . "</p>";
            $total += $reserva->precio;
          
    
            // Asignar el id del usuario actual para saber si es el mismo que el siguiente
            $usuarioIdAnterior = $reserva->id;
        }
        $html .= "<hr>";
        // Mostrar el total de la última reserva
        $html .= "<p><strong>Total para : \$" . number_format($total, 2) . "</strong></p>";
    
        // Generar el PDF
        $mpdf->WriteHTML($html);
        $mpdf->Output();  // Mostrar el informe en PDF
        exit();  // Detener ejecución
    }
    
}
?>
