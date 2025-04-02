
<?php
    include_once __DIR__ . '/../templates/barra.php';
?>

<h1>Los Mejores Festivales de Arauca</h1>
<p class="text-center">¿Que festival prefieres?</p>

</div>
<div id="app">
    <nav class="tabs">
        <button class="actual" type="button" data-paso="1">Actividades</button>
        <button  type="button" data-paso="2">Informacion De Reserva</button>
        <button  type="button" data-paso="3">Resumen</button>
    </nav>
    <div id="paso-1" class="seccion">
        <h2>Informacion de los festivales</h2>
        <p class="text-center">selecciona la Activiadad a realizar</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>
    <div id="paso-2" class="seccion informacion-reserva">
        <h2>Tus Datos </h2>
        <p class="text-center">ingresa tus datos y la fecha para las Actividades</p>
        <div class="contenedor-formulario-reservas">
            <form class="formulario" action="">
                <div class="campo">
                    <label for="nombre">Nombre</label>
                    <input 
                        id="nombre"
                        type="text"
                        placeholder="Tu nombre"
                        value="<?php echo $nombre;?>"
                        disabled
                        />
                </div>
                <div class="campo">
                    <label for="fecha">Fecha</label>
                    <input 
                        id="fecha"
                        type="date"
                        
                        min=<?php echo date('Y-m-d'); ?>
                        />
                </div>

                <div class="campo">
                    <label for="hora">Hora</label>
                    <input 
                        id="hora"
                        type="time"              
                        />
                </div>
                <input type="hidden" id="id" value="<?php echo $id; ?>">
            </form>
        </div>
    </div>
    <div id="paso-3" class="seccion contenido-resumen ">
        <h2>Resumen</h2>
        <p class="text-center" >verifica que la informacion sea correta</p>
    </div>
    <div class="paginacion">
        <button 
        id="anterior" 
        class="boton">&laquo; 
        Anterior</button>
        <button 
        id="siguiente" 
        class="boton"> 
        Siguiente &raquo;
    </button>
    </div>
</div>
<?php
    $script = "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/app.js'></script>
    ";
?>


