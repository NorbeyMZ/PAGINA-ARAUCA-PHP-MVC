<h1>Actualziar Actividades</h1>
<p class="descripcion-pagina">Modifica los valores del formulario </p>

<?php 
    include_once __DIR__ . '/../templates/barra.php';
    include_once __DIR__ . '/../templates/alertas.php';
    


?>

<form  method="POST" class="formulario" enctype="multipart/form-data">
<?php if (!empty($servicio->imagen)): ?>
        <div class="campo">
            <label>Imagen Actual:</label>
            <img class="imagen-servicio-admin" src="/imagenes/<?php echo $servicio->imagen; ?>" alt="Imagen del servicio" >
        </div>
<?php endif; ?>

<?php 
    include_once __DIR__ . '/formulario.php';
?>
<input type="submit" class="boton" value="Actualizar">

</form>

