<?php
namespace Model;

class Reserva extends ActiveRecord{

    protected static $tabla='reservas';
    protected static $columnasDB=['id', 'fecha', 'hora', 'usuarioid'];

    public $id;
    public $fecha;
    public $hora;
    public $usuarioid;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->fecha = $args['fecha'] ?? '';
        $this->hora = $args['hora'] ?? '';
        $this->usuarioid = $args['usuarioid']?? '';
    }

}

?>