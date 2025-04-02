<div class="cabecera">
    <div class="barra">
        <p><?php echo $nombre ?? '';?></p>
        <a href="/logout" class="boton">Cerrar Secion</a>
</div>



    <?php 
    if(isset($_SESSION['admin'])){ ?>
       <div class="barra-servicios">
        <a class="boton" href="/admin">Ver Reservas</a>
        <a class="boton" href="/usuarios">Ver Usuarios</a>
        <a class="boton" href="/servicios">Ver Actividades</a>
        <a class="boton" href="/servicios/crear">Crear Actividad</a>
       </div>

    <?php } else{?>
        <div class="barra-servicios">
        
        <a class="boton" href="/usuario/actualiza?id=<?php echo $_SESSION['id']; ?>">Editar Mis Datos</a>
        <a class="boton" href="/reservas">Festivales</a>
        <a class="boton" href="/vermireserva?id=<?php echo $_SESSION['id']; ?>">Ver Mis Actividades</a>
       </div>
    <?php } ?>
 
