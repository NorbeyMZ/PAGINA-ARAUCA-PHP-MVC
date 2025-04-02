<h1>Usuarios</h1>
<p class="descripcion-pagina">Usuarios de la plataforma</p>

<?php 
    include_once __DIR__ . '/../templates/barra.php';
    include_once __DIR__ . '/../templates/alertas.php';

?>


<h2>Buscar Nombre</h2>
<form class="formulario" method="GET" action="/usuarios">
    <div class="campo">
        <label for="busqueda">buscar</label>
        <input 
            type="text"
            id="busqueda"
            name="busqueda" 
            value="<?php echo $busqueda; ?>" 
            placeholder="Buscar por nombre, apellido o cédula"
        />
    </div>
    <button type="submit" class="boton">Buscar</button>
</form>

<ul class="servicios-admin">
    <?php if (!empty($usuarios)) : ?>
        <?php foreach ($usuarios as $usuario) : ?>    
            <li>
                <p>Nombre: <span><?php echo $usuario->nombre; ?></span></p>
                <p>Apellido: <span><?php echo $usuario->apellido; ?></span></p>
                <p>Cédula: <span><?php echo $usuario->cedula; ?></span></p>
                <p>Correo: <span><?php echo $usuario->email; ?></span></p>
                <p>Teléfono: <span><?php echo $usuario->telefono; ?></span></p>
                <?php 
                        if($usuario->activo == 1) { ?>
                            <p>Usuario: <span>Activo</span></p>
                    <?php  } else{ ?>
                        <p>Usuario: <span>Desabilitado</span></p>
                    <?php } ?>
                
                </span></p>
                
                <div class="acciones">
                    <a class="boton" href="/usuarios/useractualizar?id=<?php echo $usuario->id; ?>">Actualizar</a>
                    <?php if($usuario->activo == 1): ?>
                        <form action="/usuarios/deshabilitar" method="POST">
                            <input type="hidden" name="id" value="<?php echo $usuario->id ?>">
                            <input type="submit" value="Deshabilitar" class="boton-eliminar">
                        </form>
                    <?php else: ?>
                        <form action="/usuarios/habilitar" method="POST">
                            <input type="hidden" name="id" value="<?php echo $usuario->id ?>">
                            <input type="submit" value="Habilitar" class="boton">
                        </form>
                    <?php endif; ?>
                </div>
           
            </li>
        <?php endforeach; ?>
    <?php else : ?>
        <p>No se encontraron usuarios con ese nombre.</p>
    <?php endif; ?>
</ul>