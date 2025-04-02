
    <div class="campo">
        <label for="imagen">Imagen</label>
        <input 
            type="file"
            id="imagen"
            name="imagen"
            value="<?php echo $servicio->imagen; ?>"
        />
    </div>

    <div class="campo">
        <label for="nombre">Nombre</label>
        <input 
            type="text"
            id="nombre"
            placeholder="Nombre Del Servicio"
            name="nombre"
            value="<?php echo $servicio->nombre; ?>"
        />
    </div>

    <div class="campo">
        <label for="precio">Precio</label>
        <input 
            type="number"
            id="precio"
            placeholder="Precio Del Servicio"
            name="precio"
            value="<?php echo $servicio->precio; ?>"
        />
    </div>

    <div class="campo">
        <label for="lugar">Lugar</label>
        <input 
            type="text"
            id="lugar"
            placeholder="Lugar Del Servicio"
            name="lugar"
            value="<?php echo $servicio->lugar;?>"
        />
    </div>

    <div class="campo">
        <label for="descripcion">Descripcion</label>
        <textarea 
            id="descripcion" 
            name="descripcion" 
            placeholder="Ingresa la descripcion del servicio" >
            <?php echo s($servicio->descripcion);?>
        </textarea>
    </div>

    <div class="campo">
        <label for="url_mapa">Mapa</label>
        <input 
            type="text"
            id="url_mapa"
            placeholder="URL Del Mapa de google maps"
            name="url_mapa"
            value="<?php echo $servicio->url_mapa; ?>"
        />
    </div>
