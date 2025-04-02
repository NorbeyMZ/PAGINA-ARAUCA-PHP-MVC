<?php
namespace Controller;

use Model\Usuario;
use MVC\Router;

class UsuarioController{

    public static function actualiza(Router $router){
        session_start();
        isAuth();
    
        // Si no se pasa un ID por GET, usa el ID del usuario en sesión.
        $id =  $_SESSION['id'];
    
        if(!is_numeric($id)) return;
    
        $usuario = Usuario::find($id);
        $alertas = [];
    
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarActualizacion();
            if(empty($alertas)){
                $usuario->guardar();
                header('location:/reservas');    
                exit;
            }
        }
        $router->render('usuarios/index', [
            'nombre' => $_SESSION['nombre'],
            'usuario'=> $usuario,
            'alertas' => $alertas
        ], 'layout_reservas');
    }
}   

?>