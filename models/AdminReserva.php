<?php

namespace Model;

class AdminReserva extends ActiveRecord {
    
    protected static $tabla = 'reservaservicios';
    protected static $columnasDB = ['id', 'hora', 'fecha', 'cliente','email','telefono', 'servicio', 'precio' ];

    public $id;
    public $hora;
    public $fecha;
    public $cliente;
    public $email;
    public $telefono;
    public $servicio;
    public $precio;

    public function __construct($args = []){
    
        $this->id = $args['id']?? null;
        $this->hora = $args['hora']?? '';
        $this->fecha = $args['fecha']?? '';
        $this->cliente = $args['cliente']?? '';
        $this->email = $args['email']?? '';
        $this->telefono = $args['telefono']?? '';
        $this->servicio = $args['servicio']?? '';
        $this->precio = $args['precio']?? '';

        
    }
}

?>