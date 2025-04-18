<?php
namespace Controller;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
    public static function login(Router $router) {
        $alertas = [];
    
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();
    
            if(empty($alertas)) {
                // Comprobar que exista el usuario
                $usuario = Usuario::where('email', $auth->email);
    
                if($usuario) {
                    // Verificar si la cuenta está deshabilitada
                    if($usuario->activo == 0) {
                        Usuario::setAlerta('error', 'Tu cuenta está deshabilitada. Contacta al administrador.');
                    } else {
                        // Verificar el password y si la cuenta está verificada
                        if( $usuario->comprobarPasswordAndVerificado($auth->password) ) {
                            // Autenticar el usuario
                            session_start();
    
                            $_SESSION['id'] = $usuario->id;
                            $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                            $_SESSION['email'] = $usuario->email;
                            $_SESSION['login'] = true;
    
                            // Redireccionamiento según rol
                            if($usuario->admin === "1") {
                                $_SESSION['admin'] = $usuario->admin ?? null;
                                header('Location: /admin');
                            } else {
                                header('Location: /reservas');
                            }
                            exit;
                        } else {
                            Usuario::setAlerta('error', 'Contraseña incorrecta o la cuenta no está verificada.');
                        }
                    }
                } else {
                    Usuario::setAlerta('error', 'Usuario no encontrado.');
                }
            }
        }
    
        $alertas = Usuario::getAlertas();
        
        $router->render('auth/login', [
            'alertas' => $alertas
        ]);
    }
    
    public static function logout(Router $router) {
        
        session_start();
        $_SESSION=[];
        header('location:/');

    }

    public static function olvide(Router $router) {
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if(empty($alertas)) {
                 $usuario = Usuario::where('email', $auth->email);

                 if($usuario && $usuario->confirmado === "1") {
                        
                    // Generar un token
                    $usuario->crearToken();
                    $usuario->guardar();

                    //  Enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    // Alerta de exito
                    Usuario::setAlerta('exito', 'Revisa tu email');
                 } else {
                     Usuario::setAlerta('error', 'El Usuario no existe o no esta confirmado');
                     
                 }
            } 
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide-password', [
            'alertas' => $alertas
        ]);
        
    }
     
    public static function recuperar( Router $router) {
        $alertas = [];
        $error = false;

        $token = s($_GET['token']);

        // Buscar usuario por su token
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {
            Usuario::setAlerta('error', 'Token No Válido');
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Leer el nuevo password y guardarlo

            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();

            if(empty($alertas)) {
                $usuario->password = null;

                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;

                $resultado = $usuario->guardar();
                if($resultado) {
                    header('Location: /');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar-password', [
            'alertas' => $alertas, 
            'error' => $error
        ]);

    }



    public static function crear(Router $router) {
        $usuario = new Usuario();
        
       //alertas vacias 
        $alertas =[];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevacuenta();
            
            //Revisar si no hay errores en el arreglo de alertas
            if(empty($alertas)){

                //Verificar si el usuario ya existe

                $resultado = $usuario->existeUsuario();

                if($resultado->num_rows){
                    $alertas = Usuario::getAlertas();
                }else{
                    //hashear el password
                    $usuario->hashPassword();
                    //Generar un token unico
                    $usuario->crearToken(); 
                    //enviar un Email
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarConfirmacion();
                    
                    //guardar el usuario en la BD
                    $resultado = $usuario->guardar();

                    if($resultado){
                        header('Location: /mensaje');
                    }
                   
                }
            }
        }

        $router->render('auth/crear-cuenta',[
            'usuario' => $usuario,
            'alertas' => $alertas
        ]); 
    }

    public static function mensaje(Router $router) {
        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router) {
        $alertas = [];
        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {
            // Mostrar mensaje de error
            Usuario::setAlerta('error', 'Token No Válido');
        } else {
            // Modificar a usuario confirmado
            $usuario->confirmado = "1";
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta Comprobada Correctamente');
        }
       
        // Obtener alertas
        $alertas = Usuario::getAlertas();

        // Renderizar la vista
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }

}