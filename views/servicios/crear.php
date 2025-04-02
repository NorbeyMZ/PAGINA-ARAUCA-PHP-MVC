<h1>Crear un Nueva Actividad</h1>
<p class="descripcion-pagina"> llena todo los campos para añadir un nuevo servicio </p>

<?php 
    
    include_once __DIR__ . '/../templates/barra.php';
    include_once __DIR__ . '/../templates/alertas.php';

?>

<form action="/servicios/crear" method="POST" class="formulario" enctype="multipart/form-data">

<?php 
    include_once __DIR__ . '/formulario.php';
?>
 
<input type="submit" class="boton" value="Guardar Actividad">

</form>

<script>
   tinymce.init({
       selector: '#descripcion', // Apunta al textarea con id="descripcion"
       menubar: false, // Desactiva la barra de menú
       toolbar: 'undo redo | bold italic | bullist numlist | link image | code', // Herramientas
       height: 300, // Altura del editor
       plugins: ['link', 'image', 'code'], // Plugins necesarios
   });
</script>