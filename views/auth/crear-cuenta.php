<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">ingresa tus datos para crear una cuenta</p>

<?php 
    include __DIR__ . '/../templates/alertas.php';
?>
<form class="formulario" method="POST" action="/crear-cuenta" >

<div class="campo">
        <label for="nombre">Nombre</label>
        <input 
            type="text" 
            id="nombre" 
            placeholder="Tu Nombre" 
            name="nombre"
            value="<?php echo s($usuario->nombre); ?>"
           
        />  
    </div>    
    <div class="campo">
        <label for="apellido">Apellido </label>
        <input 
            type="text" 
            id="apellido" 
            placeholder="Tu Apellido" 
            name="apellido"
            value="<?php echo s($usuario->apellido); ?>"
           
        />
    </div>
    <div class="campo">
        <label for="cedula">Cedula CC</label>
        <input 
            
            type="number" 
            id="cedula" 
            placeholder="Tu Cedula" 
            name="cedula"
            value="<?php echo s($usuario->cedula); ?>"
           
        />
    </div>
    <div class="campo">
        <label for="telefono">Telefono </label>
        <input 

            type="tel"
            id="telefono" 
            placeholder="Tu Telefono" 
            name="telefono"
            value="<?php echo s($usuario->telefono); ?>"
           
        />
    </div>
    <div class="campo">
        <label for="email">Correo </label>
        <input 
            type="email" 
            id="email" 
            placeholder="Tu Email" 
            name="email"
            value="<?php echo s($usuario->email); ?>"
           
        />
    </div>

   
    <div class="campo">
        <label for="password">Contraseña </label>
        <input 
            type="password" 
            id="password" 
            placeholder="Contraseña" 
            name="password" 
            value="<?php echo s($usuario->password); ?>"
            
        />
    </div>
    <input type="submit" class="boton" value="Crear Cuenta">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inisia Sesion</a>
    <a href="/olvide">¿Olvidaste la Contraseña?</a>
</div>