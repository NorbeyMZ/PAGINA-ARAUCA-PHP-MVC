<?php
namespace Controller;

use Model\Reserva;
use Mpdf\Mpdf;    
use Model\Servicio;
use Model\Usuario;
use MVC\Router;

class ServicioController {

    public static function index(Router $router){
        session_start();
        isAdmin();

        $servicios = Servicio::all();
     
        $router->render('servicios/index', [
            'nombre'=> $_SESSION['nombre'],
            'servicios'=> $servicios
            
        ],'layout_admin');
    }

    public static function verpublicacion(Router $router) {
        session_start();
        isAdmin();

        $id = $_GET['id'] ?? null;
        if (!is_numeric($id)) {
            header('Location: /servicios');
            exit;
        }
        $servicio = Servicio::find($id);
        $router->render('servicios/verpublicacion', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
        ], 'layout_admin');
    }




    public static function crear(Router $router) {
        session_start();
        isAdmin();
        
        $servicio = new Servicio;
        $alertas = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sincronizar los datos del formulario
            $servicio->sincronizar($_POST);
            
            // Nombre único para la imagen
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
            
            // Verificar si el archivo fue subido
            if ($_FILES['imagen']['tmp_name']) {
                // Obtener la información de la imagen
                list($anchoOriginal, $altoOriginal, $tipo) = getimagesize($_FILES['imagen']['tmp_name']);
                
                // Crear una imagen a partir del archivo subido
                if ($tipo == IMAGETYPE_JPEG) {
                    $imagenOriginal = imagecreatefromjpeg($_FILES['imagen']['tmp_name']);
                } else {
                    $alertas[] = "Solo se permiten imágenes en formato JPG.";
                }
                
                if (isset($imagenOriginal)) {
                    // Redimensionar la imagen si es necesario
                    $anchoNuevo = 800;
                    $altoNuevo = 600;
                    
                    if ($anchoOriginal > $anchoNuevo || $altoOriginal > $altoNuevo) {
                        $proporción = min($anchoNuevo / $anchoOriginal, $altoNuevo / $altoOriginal);
                        $anchoNuevo = (int)($anchoOriginal * $proporción);
                        $altoNuevo = (int)($altoOriginal * $proporción);
                    }
                    
                    // Crear una nueva imagen con las dimensiones redimensionadas
                    $imagenRedimensionada = imagecreatetruecolor($anchoNuevo, $altoNuevo);
                    
                    // Copiar la imagen redimensionada en la nueva imagen
                    imagecopyresampled($imagenRedimensionada, $imagenOriginal, 0, 0, 0, 0, $anchoNuevo, $altoNuevo, $anchoOriginal, $altoOriginal);
                    
                    // Verificar si la carpeta existe y si no, crearla
                    if (!is_dir(CARPETA_IMAGENES)) {
                        mkdir(CARPETA_IMAGENES, 0755, true);
                    }
                    
                    // Guardar la imagen en la carpeta especificada
                    $rutaImagen = CARPETA_IMAGENES . $nombreImagen;
                    imagejpeg($imagenRedimensionada, $rutaImagen, 90); // Guarda la imagen con calidad 90
                    
                    // Liberar memoria
                    imagedestroy($imagenOriginal);
                    imagedestroy($imagenRedimensionada);
                    
                    // Asignar el nombre de la imagen al servicio
                    $servicio->setImagen($nombreImagen);
                } else {
                    $alertas[] = "Error al procesar la imagen.";
                }
            }
    
            // Validar los datos del servicio
            $alertas = $servicio->validar();
    
            // Si no hay alertas, guardar el servicio
            if (empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios');
            }
        }
    
        // Renderizar la vista
        $router->render('servicios/crear', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ], 'layout_admin');
    }
    
    

    public static function actualizar(Router $router) {
        session_start();
        isAdmin();
    
        // Verificar que el ID es válido
        $id = $_GET['id'] ?? null;
        if (!is_numeric($id)) {
            header('Location: /servicios');
            exit;
        }
    
        $servicio = Servicio::find($id);
        
        $alertas = [];
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();
    
            // Procesar nueva imagen si se sube una
            if (!empty($_FILES['imagen']['tmp_name'])) {
                // Crear carpeta si no existe
                if (!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES, 0755, true);
                }
    
                // Eliminar imagen anterior si existe
                $rutaImagenAnterior = CARPETA_IMAGENES . $servicio->imagen;
                if (!empty($servicio->imagen) && file_exists($rutaImagenAnterior)) {
                    unlink($rutaImagenAnterior);
                }
    
                // Generar nuevo nombre de imagen
                $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
    
                // Obtener las dimensiones de la imagen subida
                list($width, $height) = getimagesize($_FILES['imagen']['tmp_name']);
    
                // Establecer las dimensiones deseadas (800x600 en este caso)
                $nuevoWidth = 800;
                $nuevoHeight = 600;
    
                // Redimensionar si las dimensiones son mayores que las deseadas
                if ($width > $nuevoWidth || $height > $nuevoHeight) {
                    $imagenOriginal = imagecreatefromjpeg($_FILES['imagen']['tmp_name']);
    
                    // Crear una imagen vacía para la imagen redimensionada
                    $imagenRedimensionada = imagecreatetruecolor($nuevoWidth, $nuevoHeight);
    
                    // Redimensionar la imagen
                    imagecopyresampled($imagenRedimensionada, $imagenOriginal, 0, 0, 0, 0, $nuevoWidth, $nuevoHeight, $width, $height);
    
                    // Guardar la nueva imagen en la carpeta
                    imagejpeg($imagenRedimensionada, CARPETA_IMAGENES . $nombreImagen);
    
                    // Liberar memoria
                    imagedestroy($imagenOriginal);
                    imagedestroy($imagenRedimensionada);
                } else {
                    // Si la imagen no necesita redimensionarse, solo moverla
                    move_uploaded_file($_FILES['imagen']['tmp_name'], CARPETA_IMAGENES . $nombreImagen);
                }
    
                // Asignar la nueva imagen al servicio
                $servicio->imagen = $nombreImagen;
            }
    
            if (empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios');
                exit;
            }
        }
    
        $router->render('servicios/actualizar', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ], 'layout_admin');
    
    }

    
    public static function eliminar(){
        session_start();
        isAdmin();
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id=$_POST['id'];
            $servicio= Servicio::find($id);
            $servicio->eliminar();
            header('location: /servicios');
        }
    }

    public static function usuarios(Router $router) {
        session_start();
        isAdmin();
    
        // Obtener el valor de búsqueda de los parámetros GET
        $busqueda = $_GET['busqueda'] ?? '';  // Cambié 'nombre' por 'busqueda' para hacerlo más genérico
    
        if (!empty($busqueda)) {
            // Modificar la consulta para que busque en nombre, apellido o cédula
            $usuarios = Usuario::SQL(
                "SELECT * FROM usuarios 
                 WHERE nombre LIKE '%{$busqueda}%' 
                 OR apellido LIKE '%{$busqueda}%' 
                 OR cedula LIKE '%{$busqueda}%'"
            );
        } else {
            $usuarios = Usuario::all(); // Obtener todos si no hay filtro
        }
    
        // Renderizar la vista
        $router->render('servicios/usuarios', [
            'nombre' => $_SESSION['nombre'],
            'usuarios' => $usuarios,
            'busqueda' => $busqueda  // Aquí usamos 'busqueda' en lugar de 'nombreBusqueda'
        ], 'layout_admin');
    }
    

    public static function actualizarusuario(Router $router){
        session_start();
        isAdmin();


          // Validar que el ID es numérico y existe
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = "ID no válido.";
            header('Location: /usuarios'); 
            exit;
        }
        
        // Buscar usuario en la base de datos
        $usuario = Usuario::find($_GET['id']);
        $alertas =[];
        
        if (!$usuario) { // Si el usuario no existe
            $_SESSION['error'] = "El usuario no fue encontrado.";
            header('Location: /usuarios'); 
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);
            
            $alertas = $usuario->validarActualizacion();

            if(empty($alertas)){
                $usuario->guardar();
                    header('location:/usuarios');    
            }
        }

        $router->render('servicios/actualizarusuario', [
           'nombre'=> $_SESSION['nombre'],
           'usuario'=> $usuario,
            'alertas' => $alertas
        ],'layout_admin');

    }

    public static function deshabilitar(){
        session_start();
        isAdmin();
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id=$_POST['id'];
            $servicio= Usuario::find($id);
            $servicio->deshabilitar();
            header('location: /usuarios');
        }
    }

    public static function habilitar(){
        session_start();
        isAdmin();
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id=$_POST['id'];
            $servicio= Usuario::find($id);
            $servicio->habilitar();
            header('location: /usuarios');
        }
    }

    public static function informeActividad(Router $router) {
        session_start();
        isAdmin();
    
        // Obtener el id del servicio desde la URL
        $id = $_GET['id'] ?? null; // Usamos 'id' como parámetro
    
        // Validar si el id es válido
        if (!$id || !is_numeric($id)) {
            // Redirigir si el id no es válido
            header('Location: /servicios');
            exit;
        }
        // Obtener el servicio usando el id
        $servicio = Servicio::find($id);
    
        // Validar si el servicio existe
        if (!$servicio) {
            // Redirigir si el servicio no existe
            header('Location: /servicios');
            exit;
        }
    
        // Crear el informe PDF con los datos del servicio
        $mpdf = new Mpdf();

        $logoPath = __DIR__ .'/../src/img/logo.jpg';  // Ruta absoluta
        
        $html = '<div style="display: flex; align-items: center; padding-top: 10px; margin: 0;">
        <!-- Imagen como marca de agua -->
        <img src="' . $logoPath . '" width="100" alt="Logo" style="margin-right: 10px; opacity: 0.5;">
        <!-- Texto con línea arriba y abajo -->
        <div style="border-top: 2px solid #000; border-bottom: 2px solid #000; padding: 5px 10px; margin: 0;">
            <h3 style="text-align: center; margin: 0;">Informe de los festivales</h3>
        </div>
    </div>';
        
        $html .= "<h1>{$servicio->nombre}</h1>";

        if ($servicio->imagen) {
            $imagePath = '/imagenes/'.$servicio->imagen;
            $imageData = base64_encode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . $imagePath));
            $html .= "<div style='text-align: center;'>
            <img src='data:image/jpeg;base64,{$imageData}' style='max-width: 500px;'>
            </div>";
        }
        
        $html .= "<p><strong>ID:</strong> {$servicio->id}</p>";  // Mostramos solo el ID
        
        $html .= "<p><strong>Precio:</strong> {$servicio->precio}</p>";
        $html .= "<p><strong>Lugar:</strong> {$servicio->lugar}</p>";
        $html .= "<p><strong>Descripción:</strong> {$servicio->descripcion}</p>";
      
        // Generar el PDF
        $mpdf->WriteHTML($html);
    
        // Mostrar el informe en PDF
        $mpdf->Output();  // Esto abrirá el PDF en el navegador
        exit(); 
    }
}
    
    
?>