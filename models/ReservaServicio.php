<?php
namespace Model;

class ReservaServicio extends ActiveRecord{
    protected static $tabla = 'reservaservicios';
    protected static $columnasDB = ['id','reservaid', 'servicioid'];


    public $id;
    public $reservaid;
    public $servicioid;

    public function __construct($args = []) {
        $this->id = $args['id']?? null;
        $this->reservaid = $args['reservaid']?? '';
        $this->servicioid = $args['servicioid']?? '';
    }
}

?>