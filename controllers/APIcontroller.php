<?php
namespace Controller;

use Model\Reserva;
use Model\ReservaServicio;
use Model\Servicio;

class APIcontroller{
    public static function index(){
        $servicios = Servicio::all();
        echo json_encode($servicios);
       
    }
    public static function guardar() {
        //almecena la reserva y devuleve el id 
        $reserva = new Reserva($_POST);
        $resultado = $reserva-> guardar();
        $id = $resultado['id'];
        //almacena las reservas y los servicios
     //almacena los servicios con el id de la reserva
        $idServicios = explode(",",$_POST['servicios']) ;
            foreach ($idServicios as $idServicio){
            $args = [
                'reservaid' => $id,
                'servicioid' => $idServicio
            ];
            $reservaServicio = new ReservaServicio ($args);
            $reservaServicio->guardar();
        }
        //retornamos una respuesta
        echo json_encode(['resultado' => $resultado]);
    }
    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD']== 'POST'){
            $id = $_POST['id'];
            $reserva = Reserva::find($id);
            $reserva->eliminar();
            header('location: '. $_SERVER['HTTP_REFERER']);
        }
    } 

}
  
?>