<?php 
    include_once __DIR__ . '/../templates/barra.php';
    include_once __DIR__ . '/../templates/alertas.php';
?>

<h3>Mis Actividades</h3>

<div id="reservas-admin">
    <?php if(empty($reservas)): ?>
        <h2 class="">No tienes Actividades registradas.</h2>
    <?php else: ?>
        <ul class="reservas">
            <?php
                $idreserva = 0; // Inicializar variable para almacenar id de la última reserva mostrada
                foreach($reservas as $key => $reserva){
                    if($idreserva !== $reserva->id){
                        $total= 0;
            ?>
                <li>
                    <h3>Cliente</h3>
                    <p>ID: <span> <?php echo $reserva->id;?></span></p>
                    <p>Fecha: <span> <?php echo $reserva->fecha;?></span></p>
                    <p>Hora: <span> <?php echo $reserva->hora;?></span></p>
                    <p>Nombre: <span> <?php echo $reserva->cliente;?></span></p>
                    <p>Email: <span> <?php echo $reserva->email;?></span></p>
                    <p>Teléfono: <span> <?php echo $reserva->telefono;?></span></p>

                    <h3>Servicios</h3>
                    <?php 
                    $idreserva=$reserva->id;
                    }// Fin if 

                    $total +=  $reserva->precio;
                    ?>
                    <p class="servicio"> <?php echo $reserva->servicio ?> <span class="precio-servicio"> <?php echo $reserva->precio; ?> </span>
                    <hr>
                <?php 
                    $actual = $reserva->id;
                    $proximo = $reservas[$key + 1]->id ?? 0;

                    if(esUltimo($actual, $proximo)){ ?>
                        <p class="total">Total: <span class="precio-total">$ <?php echo $total ?></span> </p>
                        
                        <form action="/api/eliminar" method="POST">
                            <input type="hidden" name="id" value="<?php echo $reserva->id; ?>">
                            <input type="submit" class="boton-eliminar" value="Cancelar">
                        </form>
                <?php } ?>
            <?php 
                }// Fin foreach ?>
        </ul>
    <?php endif; ?>
</div>

