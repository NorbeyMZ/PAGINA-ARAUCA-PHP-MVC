<h1>Servicios</h1>
<h3>Administrador de Servicios</h3>

<?php

include_once __DIR__ . '/../templates/barra.php';
include_once __DIR__ . '/../templates/alertas.php';

?>
<h1>listado de publicaciones </h1>

<ul class="servicios-admin">
    <?php foreach ($servicios as $servicio){ ?>

        <li>
            <h1>Actividad</h1>
        <?php if (!empty($servicio->imagen)): ?>
            <img src="/imagenes/<?php echo $servicio->imagen; ?>" alt="Imagen del servicio" width="200">
            <?php else: ?>
                <p>No hay imagen disponible</p>
            <?php endif; ?>

            <p>Nombre: <span><?php echo $servicio->nombre; ?> </span> </p>
            <p>Precio: <span><?php echo $servicio->precio; ?> </span> </p>
            <p>Lugar: <span><?php echo $servicio->lugar; ?> </span> </p>
    
            <iframe  class="iframe-mapa" src="<?php echo $servicio->url_mapa ?>"></iframe>

            <div class="acciones">
                <a class="boton" href="/servicios/actualizar?id=<?php echo $servicio->id; ?>">Actualizar</a>

                <a class="boton" href="/servicios/verpublicacion?id=<?php echo $servicio->id; ?>">Ver Publicacion</a>

                <a class="boton" href="/servicios/informeActividad?id=<?php echo $servicio->id; ?>" target="_blank">Generar Informe</a>
               
                <form action="/servicios/eliminar" method="POST">
                        <input type="hidden" name="id" value="<?php echo $servicio->id ?>">
                        <input type="submit" value="borrar" class="boton-eliminar">
                </form> 
            </div>

        </li>
  


    <?php } ?>
</ul>