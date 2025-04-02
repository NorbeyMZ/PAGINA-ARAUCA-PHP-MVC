<h1>Usuarios</h1>
<p class="descripcion-pagina">Actualziar los datos del usuario</p>

<?php 
    include_once __DIR__ . '/../templates/barra.php';
    include_once __DIR__ . '/../templates/alertas.php';

?>


<form  method="POST" class="formulario">

<?php 
    include_once __DIR__ . '/../templates/formularioUsuario.php';
?>


<input type="submit" class="boton" value="Actualizar">

</form>