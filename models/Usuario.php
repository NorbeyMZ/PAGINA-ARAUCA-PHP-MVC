<?php
namespace Model;

class Usuario extends ActiveRecord{
    // Base DE DATOS
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'cedula', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token','activo'];

    public $id;
    public $nombre;
    public $apellido;
    public $cedula;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;
    public $activo;

    public function __construct($args = []){

        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->cedula = $args['cedula'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? 0;
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->token = $args['token'] ?? '';
        $this->activo = $args['activo']?? 1;
    }

    // Mensajes de validacion
    public function validarNuevacuenta(){
        if(!$this->nombre){
            self::$alertas['error'][] = "Debes añadir un nombre";
        }

        if(!$this->apellido){
            self::$alertas['error'][] = "Debes añadir un apellido";
        }

        if(!$this->cedula){
            self::$alertas['error'][] = "Debes añadir una cedula";
        }
        if(!$this->email){
            self::$alertas['error'][] = "Debes añadir un correo";
        }
        if(!$this->password){
            self::$alertas['error'][] = "Debes añadir un contraseña";
        }
        if(!$this->telefono){
            self::$alertas['error'][] = "Debes añadir un telefono";
        }
        if(strlen($this->password) < 6){
            self::$alertas['error'][] = "la contraseña debe tener al menos 6 caracteres";

        }

        return self::$alertas;
    }



    public function validarActualizacion(){
        if(!$this->nombre){
            self::$alertas['error'][] = "Debes añadir un nombre";
        }

        if(!$this->apellido){
            self::$alertas['error'][] = "Debes añadir un apellido";
        }

        if(!$this->cedula){
            self::$alertas['error'][] = "Debes añadir una cedula";
        }
        if(!$this->email){
            self::$alertas['error'][] = "Debes añadir un Correo";
        }
        
        if(!$this->telefono){
            self::$alertas['error'][] = "Debes añadir un telefono";
        }
       

        return self::$alertas;
    }

    // Verifica si un usuario ya existe
    public function validarLogin() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El email es Obligatorio';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'la contraseña es Obligatorio';
        }

        return self::$alertas;
    }
    public function validarEmail() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El email es Obligatorio';
        }
        return self::$alertas;
    }

    public function validarPassword() {
        if(!$this->password) {
            self::$alertas['error'][] = 'la contraseña es obligatorio';
        }
        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'la contraseña debe tener al menos 6 caracteres';
        }

        return self::$alertas;
    }

    // Revisa si el usuario ya existe
    public function existeUsuario() {
        $query = " SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query);

        if($resultado->num_rows) {
            self::$alertas['error'][] = 'El Usuario ya esta registrado';
        }

        return $resultado;
    }

    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken() {
        $this->token = uniqid();
    }

    public function comprobarPasswordAndVerificado($password) {
        $resultado = password_verify($password, $this->password);
        
        if(!$resultado || !$this->confirmado) {
            self::$alertas['error'][] = 'Contraseña incorrecto o tu cuenta no ha sido confirmada';
        } else {
            return true;
        }
    }

}