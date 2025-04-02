<h1 class="nombre-pagina"> Login</h1>
<p class="descripcion-pagina"> inicia sesion con tus datos</p>

<?php 
    include __DIR__ . '/../templates/alertas.php';
?>


<form class="formulario" method="POST" action="/">
    <div class="campo">
        <label for="email">Correo</label>
        <input 
            type="email" 
            id="email" 
            placeholder="Tu correo" 
            name="email"
          
        />
    </div>
    <div class="campo">
        <label for="password">Contraseña</label>
        <input 
            type="password" 
            id="password" 
            placeholder="Tu Password" 
            name="password"
         
        />
    </div>
    <input type="submit" class="boton" value="Iniciar Sesion">
</form>

<div class="acciones">
    <a href="/crear-cuenta">¿Aun no tines cuenta? Crear una</a>
    <a href="/olvide">¿Olvidaste la Contraseña?</a>
</div>