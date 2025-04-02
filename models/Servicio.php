<?php
namespace Model;

class Servicio extends ActiveRecord{
    //base de datoos 

    protected static $tabla ='servicios';
    protected static $columnasDB = ['id','imagen','nombre','precio','lugar','descripcion','url_mapa'];

    public $id;
    public $imagen;
    public $nombre;
    public $precio;
    public $lugar;
    public $descripcion;
    public $url_mapa;

    //Obtener todos los servicios

    public function __construct($args =[]){
        $this->id = $args['id'] ?? null;
        $this->imagen = $args['imagen'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->lugar = $args['lugar'] ?? '';
        $this->descripcion = $args['descripcion']?? '';
        $this->url_mapa = $args['url_mapa'] ?? '' ;
    }
    public function validar(){
        
        if (empty($this->imagen) && empty($_FILES['imagen']['tmp_name'])) {
            self::$alertas['error'][] = 'La imagen es obligatoria';
        }
        if(!$this->nombre){
            self::$alertas['error'][] = 'El nombre del servicio es obligatorio';
        }
        if(!$this->precio){
            self::$alertas['error'][] = 'El precio es obligatorio';
        }

        if(!is_numeric($this->precio)){
            self::$alertas['error'][] = 'El precio no es valido';
        }

         if(!$this->descripcion){
            self::$alertas['error'][] = 'ingresa una descripcion';
        }
     
        if(!$this->lugar){
            self::$alertas['error'][] = 'El lugar del servicio es obligatorio';
        }
        if(!$this->url_mapa){
            self::$alertas['error'][] = 'la url del mapa es obligatorio';
        }

        return self::$alertas;
    }
}

?>