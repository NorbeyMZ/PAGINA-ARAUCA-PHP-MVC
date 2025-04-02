<?php 
  include_once __DIR__ . '/../templates/barra.php';
  include_once __DIR__ . '/../templates/alertas.php';

?>

<div class="contenedor-servicio-info">

    <h1><?php echo $servicio->nombre; ?></h1>
    <div class="imagen-servicio">
        <img class="img-servicio" src="/imagenes/<?php echo $servicio->imagen; ?>" alt="Imagen del servicio" >
    </div>   
        
    <p class="bold"> <span><?php echo $servicio->lugar; ?> </span> </p>
    <p><span><?php echo $servicio->descripcion; ?> </span> </p>
    <iframe  class="iframe-mapa" src="<?php echo $servicio->url_mapa ?>"></iframe>

</div>