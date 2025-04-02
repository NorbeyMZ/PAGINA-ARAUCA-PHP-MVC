<h1 class="nombre-pagina">Olvide la Contraseña</h1>
<p class="descripcion-pagina">Ingresa tu Email para restablecer la contraseña</p>

<?php 
    include __DIR__ . '/../templates/alertas.php';
?>

<?php if($error) return; ?>
<form class="formulario" method="POST" action="/olvide" >
    <div class="campo">
        <label for="email">Correo</label>
        <input 
            type="email" 
            id="email" 
            placeholder="Tu Correo" 
            name="email"
        />
    </div>
    <input type="submit" class="boton" value="Restablecer Contraseña">

</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inisia Sesion</a>
    <a href="/crear-cuenta">¿Aun no tiene una ceunta? Crear una</a>
</div>