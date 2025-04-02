<h1 class="nombre-pagina">Recuperar Contraseña</h1>
<p class="descripcion-pagina">ingresa tu nueva contraseña</p>

<?php 
    include __DIR__ . '/../templates/alertas.php';
?>

<form method="POST" class="formulario">
    <div class="campo">
        <label for="password">Password</label>
        <input 
            type="password" 
            id="password" 
            placeholder="Tu Nueva Password" 
            name="password"
        />
    </div>
    <input type="submit" class="boton" value="Guardar Password">

</form>

<div class="acciones-confirmar">
    <a class="btn-pagina" href="/">¿Ya tienes Cuenta? Iniciar Sesion</a>
    <a class="btn-pagina" href="/crear-cuenta">¿No tienes cuenta ? Crear Cuenta</a>
</div>