
<?php 
    include_once __DIR__ . '/../templates/barra.php';
    include_once __DIR__ . '/../templates/alertas.php';

?>
<h1>Actualiza tus Datos</h1>

<form  method="POST" class="formualrio">
  
    <?php 
        include_once __DIR__ . '/../templates/formularioUsuario.php';
    ?>

<input type="submit" class="boton" value="Actualizar">
</form>


