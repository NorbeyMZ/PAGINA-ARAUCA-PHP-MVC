
let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const reserva = {
    id:'', 
    nombre: '',
    fecha:'',
    hora:'',
    servicios:[]
}

document.addEventListener('DOMContentLoaded', function(){
    iniciarApp();
});

function iniciarApp(){
    mostrarSeccion(); // muestra y ocultaa las secciones
    tabs(); //cambia la seccion cuando se presina los tabs

    botonesPaginador();//agrega o quita los botones del paginador 
    paginaSiguiente();//cambia la pagina
    paginaAnterior();//cambia la pagina
    
    consultarAPI();//consulta la api en el backend de php 
    
    idCliente();//id cliente
    nombreCliente();// añade el nombre el cleinte al objeto de reserva 
    seleccionarFecha();//añade la fecah al objeto de reserva
    seleccionarHora();//añsde la hora enel iobjeto de reserva

    mostrarResumen();//muestra el resumen de la cita 
    
}

function mostrarSeccion(){
    // ocultar la seccion que tenga la calse de mostar
    
    const seccionAnterior = document.querySelector('.mostrar');
    if(seccionAnterior){

        seccionAnterior.classList.remove('mostrar');
    }

    //seleccionar la seccion con el pasos
    const pasoSelector= `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);
    seccion.classList.add('mostrar');

    //quita la calse de actual al tab anterior 
    const tabAnterior = document.querySelector('.actual');
    if(tabAnterior){
            tabAnterior.classList.remove('actual');
    }
 
    //resalta el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');
}

function tabs(){
    const botones = document.querySelectorAll('.tabs button');
    botones.forEach( boton=>{
        boton.addEventListener('click', function(e) {
               paso =(parseInt(e.target.dataset.paso));
               mostrarSeccion();

               botonesPaginador();

             
        });
    });
}

function botonesPaginador(){
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');
    
    if(paso === 1){
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
        
    }else if (paso == 3){
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');
        mostrarResumen();
    }else {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }
    mostrarSeccion();
}

function paginaSiguiente(){
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', function(){
        
        if(paso >=pasoFinal) return;
        paso++;
       
        botonesPaginador();
    });
    
}
function paginaAnterior(){
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', function(){
        
        if(paso <=pasoInicial) return;
        paso--;
    
        botonesPaginador();
    });

}

async function consultarAPI(){

    try{
        const url= '/api/servicios';
        const respuesta = await fetch(url);
        const servicios = await respuesta.json();

    
       mostrarServicios(servicios);
    
    }catch(error){
        console.log(error);
    }
}

function mostrarServicios(servicios) {
    servicios.forEach(servicio => {
        const { id, imagen, nombre, precio ,lugar, descripcion, url_mapa } = servicio;

        const imagenServicio = document.createElement('img');
        imagenServicio.classList.add('imagen-servicio');
        imagenServicio.src = '/imagenes/' + imagen;

        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = ` $${parseFloat(precio).toLocaleString()}`;

        const lugarServicio = document.createElement('P');
        lugarServicio.classList.add('lugar-servicio');
        lugarServicio.textContent = lugar;

        const descripcionServicio = document.createElement('P');
        descripcionServicio.classList.add('descripcion-servicio');
        const maxLongitud = 100 ;
        descripcionServicio.innerHTML = descripcion.length > maxLongitud 
            ? descripcion.substring(0, maxLongitud) + "..." 
            : descripcion;

        let iframeMapa;
        if (url_mapa) {
            iframeMapa = document.createElement('iframe');
            iframeMapa.classList.add('iframe-mapa');
            iframeMapa.src = url_mapa;
        }

        // Contenedor principal del servicio
        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;

        // Este evento solo se activa cuando se hace clic en el contenedor
        servicioDiv.onclick = function() {
            seleccionarServicio(servicio);
        }

        // Botón "Más información"
        const botonMasInfo = document.createElement('a');
        botonMasInfo.classList.add('boton');
        botonMasInfo.textContent = 'Más información';
        botonMasInfo.href = `/infoservicios?id=${id}`; // Redirige a la página con más detalles
        botonMasInfo.onclick = function(event) {
            event.stopPropagation(); // Evita que el clic afecte la selección del servicio
        };

        // Agregar elementos al servicioDiv
        servicioDiv.appendChild(imagenServicio);
        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);
        servicioDiv.appendChild(lugarServicio);
        servicioDiv.appendChild(descripcionServicio);
        if (url_mapa) {
            servicioDiv.appendChild(iframeMapa);
        }
        servicioDiv.appendChild(botonMasInfo); // Agregar botón al final

        // Añadir el servicio al contenedor de servicios
        document.querySelector('#servicios').appendChild(servicioDiv);
    });
}



function seleccionarServicio(servicio) {
    const { id } = servicio;
    const {servicios} = reserva;
    //comprobar si un servicio ya fue agreagado oq uitarlo de la seleccion

    const divServicio = document.querySelector( `[data-id-servicio="${id}"] `);
   
    if(servicios.some(agregado => agregado.id === id ) ) {
        //elminarlo
        reserva.servicios = servicios.filter(agregado => agregado.id!== id);
        divServicio.classList.remove('seleccionado');
    }else {
        //agregarlo
        reserva.servicios = [...servicios, servicio];
        divServicio.classList.add('seleccionado');
    }
    
}

function idCliente() {
    reserva.id = document.querySelector('#id').value;
   
}

function nombreCliente(){
    reserva.nombre = document.querySelector('#nombre').value;
}

function seleccionarFecha(){
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input',function(e){

        const dia = new Date(e.target.value).getUTCDay();
        if([0].includes(dia)){
            e.target.value ='';
            mostrarAlerta('los domingos no trabajamos','error', '.formulario');
        }else{
            reserva.fecha = e.target.value;
        }
    });
}

function seleccionarHora(){
    const inputHora=document.querySelector('#hora');
    inputHora.addEventListener('input', function(e){

        const horaReserva= e.target.value;
        const hora =horaReserva.split(':')[0];
        if (hora< 7 || hora >18){

            e.target.value='';
            mostrarAlerta('hora no valida','error', '.formulario')

        }else {
            reserva.hora = e.target.value;
        }
    });
}


function mostrarAlerta( mensaje, tipo, elemento, desaparece = true){
    // previene que se genere mas de un alerta 
    const alertaPrevia = document.querySelector('.alerta');
    if(alertaPrevia){
        alertaPrevia.remove();
    } 

    //scri
    const alerta = document.createElement('DIV');
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);
    alerta.textContent = mensaje;

    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta); 


    if(desaparece){
        setTimeout(()=>{
            alerta.remove();
        }, 3000);  //3 segundos para desaparecer el alerta
    }
}

function mostrarResumen(){
    const resumen = document.querySelector('.contenido-resumen');

    //limpiar el contenido de resumen 
    while(resumen.firstChild){
        resumen.removeChild(resumen.firstChild);
    }

    if(Object.values(reserva).includes('') || reserva.servicios.length === 0 ){
        mostrarAlerta('faltan datos de servicios, Fecha u Hora', 'error', '.contenido-resumen', false);
        return;
    }
    //formatear el div de resumen 
    const { nombre, fecha, hora, servicios} = reserva;

    // heden para servicio en Resumen 
    const headingServicio = document.createElement('H3');
    headingServicio.textContent ='Resumen de la Reserva';
    resumen.appendChild(headingServicio);

    //iteradno y mostrando los servicios
    servicios.forEach(servicio =>{
        const { id, imagen, nombre, precio, lugar, url_mapa } = servicio;
        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicios')

        

        const nombreServicio= document.createElement('P');
        nombreServicio.classList.add('nombre-servicio')
        nombreServicio.textContent = nombre;

        const lugarServicio= document.createElement('P');
        lugarServicio.textContent = lugar;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio')
        precioServicio.innerHTML = `<span>Precio: </span>$${precio} `;
   
        contenedorServicio.appendChild(nombreServicio);
        contenedorServicio.appendChild(lugarServicio);
        contenedorServicio.appendChild(precioServicio);

        resumen.appendChild(contenedorServicio);
   
    });

    const datosServicio = document.createElement('H3');
    datosServicio.textContent ='Datos de la Reserva';
    resumen.appendChild(datosServicio);

    const nombreCliente= document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre: </span>${nombre}`;

    const fechaReserva= document.createElement('P');
    fechaReserva.innerHTML = `<span>Fecha: </span>${fecha}`;

    const horaReserva= document.createElement('P');
    horaReserva.innerHTML = `<span>Hora: </span>${hora} horas`;


    //boton para Crear la reserva 
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar Plan';
    botonReservar.onclick = reservarPlan;

    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaReserva);
    resumen.appendChild(horaReserva);

    resumen. appendChild(botonReservar);

}

async function reservarPlan(){
    const { nombre, fecha, hora, servicios, id} = reserva;

    const idServicios = servicios.map(servicio => servicio.id);

    

    const datos = new FormData();
  
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('usuarioid', id);
    datos.append('servicios', idServicios);

    //peticion hacia la api 

    try {
        const url ='/api/reserva'

        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        })
        const resultado = await respuesta.json();
        console.log(resultado.resultado);

        if(resultado.resultado){
             Swal.fire({
                icon: "success",
                title: "Reserva Creada",
                text: "Tu Reserva Fue Creada Corretamente",
                button:'OK'
            }).then(() => {
                setTimeout(() => window.location.reload(), 3000);
            });
        }
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "ERROR",
            text: "Hubo un error al guardar la reserva",
        });
    }
    //console.log([...datos]);

}