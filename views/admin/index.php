<?php
    include_once __DIR__ . '/../templates/barra.php';
?>

<h2>Buscar</h2>
<p>Selecciona una fecha para generar el informe:</p>

<form method="GET" action="/generar_informe" target="_blank">
    <div class="campo">
        <label for="fecha">Seleccionar Fecha:</label>
        <input type="date" name="fecha" id="fecha" value="<?php echo isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d'); ?>">
    </div>
    <div class="campo"> 
        <button class="boton" type="submit">Generar Informe </button>
    </div>
</form>



<!-- Formulario de búsqueda, que ahora utiliza el mismo campo de fecha -->


<?php
    // Mostrar mensaje si no hay reservas para la fecha seleccionada
    if ($noReservasParaFecha) {
        echo "<h2>No hay reservas para la fecha seleccionada.</h2>";
    }
?>



<div id="reservas-admin">
    <ul class="reservas">
        <?php
            $idreserva = 0; // Inicializar variable para almacenar id de la última reserva mostrada
            foreach ($reservas as $key => $reserva) {
                if ($idreserva !== $reserva->id) {
                    $total = 0;
        ?>
            <li>
                <h3>Cliente</h3>
                <p>ID: <span> <?php echo $reserva->id; ?></span></p>
                <p>Fecha: <span> <?php echo $reserva->fecha; ?></span></p>
                <p>Hora: <span> <?php echo $reserva->hora; ?></span></p>
                <p>Nombre: <span> <?php echo $reserva->cliente; ?></span></p>
                <p>Email: <span> <?php echo $reserva->email; ?></span></p>
                <p>Telefono: <span> <?php echo $reserva->telefono; ?></span></p>

                <h3>Actividades</h3>
                <?php 
                    $idreserva = $reserva->id;
                }

                $total += $reserva->precio;
                ?>
                <p class="servicio"><?php echo $reserva->servicio ?> <span class="precio-servicio">$<?php echo $reserva->precio; ?></span></p>
                <hr>
            <?php 
                $actual = $reserva->id;
                $proximo = $reservas[$key + 1]->id ?? 0;

                if (esUltimo($actual, $proximo)) { ?>
                    <p class="total">Total: <span class="precio-total">$ <?php echo $total ?></span> </p>
                    <form action="/api/eliminar" method="POST">
                        <input type="hidden" name="id" value="<?php echo $reserva->id; ?>">
                        <input type="submit" class="boton-eliminar" value="Eliminar">
                    </form>
                <?php } ?>
        <?php 
            }
        ?>
    </ul>
</div>

<?php
    $script = "<script src='build/js/buscador.js'></script>";
?>
