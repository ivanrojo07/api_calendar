// VARIABLE DE LA FECHA DE USUARIO
var date = new Date();
// VARIABLE DEL USUARIO ID QUE SE MODIFICARA DEL LADO DEL FRONTEND
var usuario_id = 1; //TU LO MODIFICAS
// VARIABLE DE LA ZONA HORARIA SE MODIFICA DEL LADO DEL FRONTEND
var zona_horaria = "America/Mexico_City";//TU LO MODIFICAS
// ARRAY DE LOS EVENTOS DEL USUARIO
var eventos_usuario = []

// SE LANZAN ESTAS FUNCIONES CUANDO SE INICIA EL DOCUMENT HTML
$(document).ready(function(){
    // obtenemos la fecha en formato Y-M-D
    let fecha = date.toISOString().split('T')[0];
    // PETICION FETCH AL ENDPOINT DE EVENTOS POR UN DíA
    fetch("https://agenda360.ml/api/eventos/dia",{
        // METHOD
        method:"POST",
        // HEADERS
        headers: {
          'Content-Type': 'application/json',
          'Accept':'application/json'
          // 'Content-Type': 'application/x-www-form-urlencoded',
        },
        // PARAMETOS A ENVIAR
        body: JSON.stringify({
            'usuario_id' : usuario_id,
            'fecha' : fecha,
            'zona_horaria':zona_horaria
        })
        // RESOLUCION DE LA PROMESA
    }).then(response => response.json()).then((data) => {
         // GUARDAMOS EN UNA VARIABLE ELOBJETO RESULTANTE
        let events = data.data
        // Creamos body html
        let body_html = '<div class="container">';
        // CREAMOS UN CICLO A LA VARIABLE EVENTS
        events.forEach(evento=>{
            // POR CADA EVENTO PINTAMOS SU INFORMACIóN EN HTML
            body_html += `
            <div class="row">
                <div class="col-12 col-md-4 mt-2">
                    <label>Titulo</label>
                    <input class="form-control" type="text" readonly="" value="${evento.titulo}">
                </div>
                <div class="col-12 col-md-4 mt-2">
                    <label>Descripción</label>
                    <textarea class="form-control" readonly="">${evento.descripcion ? evento.descripcion : "N/A" }</textarea>
                </div>
                <div class="col-12 col-md-4 mt-2">
                    <label>Fecha Inicio</label>
                    <input class="form-control" type="text" readonly="" value="${evento.fechainicio}">
                </div>
                <div class="col-12 col-md-4 mt-2">
                    <label>Hora Inicio</label>
                    <input class="form-control" type="text" readonly="" value="${evento.horainicio}">
                </div>
                <div class="col-12 col-md-4 mt-2">
                    <label>Fecha Fin</label>
                    <input class="form-control" type="text" readonly="" value="${evento.fechafin}">
                </div>
                <div class="col-12 col-md-4 mt-2">
                    <label>Hora Fin</label>
                    <input class="form-control" type="text" readonly="" value="${evento.horafin}">
                </div>
                <div class="col-12 col-md-4 mt-2">
                    <label>Fecha Recordatorio</label>
                    <input class="form-control" type="text" readonly="" value="${evento.fecharecordatorio}">
                </div>
                <div class="col-12 col-md-4 mt-2">
                    <label>Hora Recordatorio</label>
                    <input class="form-control" type="text" readonly="" value="${evento.horarecordatorio}">
                </div>
                <div class="col-12 mt-3 d-flex justify-content-between">
                    <button type="button" class="btn btn-info" onclick="showEvent(${evento.id})">Ver</button>
                    <button type="button" class="btn btn-warning" onclick="showUpdateForm(${evento.id})">Editar</button>
                    <button type="button" class="btn btn-danger" onclick="showDeleteForm(${evento.id})">Eliminar</button>
                </div>
            </div>
            <hr>
            `
            // Y LOS BOTONES DE ACCIN PARA CADA EVENTO
        });
        // CERRAMOS EL DIV
        body_html += "</div>"
        // Y LO MOSTRAMOS EN EL DIV DEL MODAL CON ID bodyEventosDia
        $("#bodyEventosDia").append(body_html);
    });

    
    
})

   

// FULL CALENDAR.JS
document.addEventListener('DOMContentLoaded', function() {
    // VARIABLE del div calendaar
    var calendarEl = document.getElementById('calendar');
    // Crear un elemento calendar en ese div.
    var calendar = new FullCalendar.Calendar(calendarEl, {
        // AGREGAR FECHA DE HOY POR DEFAULT
        defaultDate:date,
        // TIPO DE VISTAS
        plugins: ['dayGrid','interaction','timeGrid','list'],
        // BOTONES DE ACCION EN HEADER
        header:{
            left:"prev,next today,MiBoton",
            center:"title",
            right:'timeGridDay,timeGridWeek,dayGridMonth'
        },
        // BOTONES CREADOS
        customButtons:{
            // BOTON PARA CREAR NUEVO EVENTO
            MiBoton:{
                text:"Nuevo",
                click:function(){
                    $("#fechainicio").val("")
                    $("#fechafin").val("")
                    nuevoModal.toggle()
                }
            }
        },
        // EVENTO AL DAR CLICK A FECHAS(MOSTRAR MODAL DE NUEVO EVENTO)
        dateClick:function(info){
            console.log(info);
            $("#fechainicio").val(info.dateStr)
            $("#fechafin").val(info.dateStr)
            nuevoModal.toggle()
        },
        // EVENTO AL DAR CLICK AL EVENTO(MUESTRA MODAL DEL EVENTO CON OPCIONES DE EDITAR O ELIMINAR)
        eventClick:function(info){
            console.log(info);
            console.log(info.event.id);
            showEvent(info.event.id);
        },
        // CALLBACK PARA TRAER TODOS LOS EVENTOS DE UN USUARIO DADO
        events: function( fetchInfo, successCallback, failureCallback ) { 
            fetch("https://agenda360.ml/api/eventos/usuario",{
                method:"POST",
                headers:{
                    'Content-Type':'application/json',
                    'Accept':'application/json'
                },
                body:JSON.stringify({
                    'usuario_id' : usuario_id,
                    'zona_horaria':zona_horaria
                })
            }).then(response=>response.json()).then((data)=>{
                console.log(data)
                let events = data.data
                var eventos = events.map(function(event){
                    return {
                        'id':event.id,
                        'title':event.titulo,
                        'start':event.inicio,
                        'end':event.fin,
                        'evento':event
                    }
                })
                successCallback(eventos)

            });
        }
        });
            /*IDIOMA DEL CALENDARIO*/
            calendar.setOption('locale', 'Es');
            // RENDER DEL CALENDARIO
            calendar.render();
          });

    // OBTENER MODALES EN VARIABLES PARA SU MANEJO CON JAVASCRIPT
    var nuevoModal = new bootstrap.Modal(document.getElementById('nuevoModal'), {
      keyboard: false
    })
    var eventoModal = new bootstrap.Modal(document.getElementById('showEventoModal'),{
        keyboard:false
    })
    var updateModal = new bootstrap.Modal(document.getElementById('updateModal'),{
        keyboard:false
    })
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'),{
        keyboard:false
    })

    // FUNCION PARA MOSTRAR UN EVENTO
    function showEvent(evento_id) {
        fetch("https://agenda360.ml/api/eventos/"+evento_id)
        .then(response => response.json())
        .then((data) => {
            evento = data.data
            body_html = `
                <div class="row">
                    <div class="col-12 col-md-4 mt-2">
                        <label>Titulo</label>
                        <input class="form-control" type="text" readonly="" value="${evento.titulo}">
                    </div>
                    <div class="col-12 col-md-4 mt-2">
                        <label>Descripción</label>
                        <textarea class="form-control" readonly="">${evento.descripcion ? evento.descripcion : "N/A" }</textarea>
                    </div>
                    <div class="col-12 col-md-4 mt-2">
                        <label>Fecha Inicio</label>
                        <input class="form-control" type="text" readonly="" value="${evento.fechainicio ? evento.fechainicio : "N/A"}">
                    </div>
                    <div class="col-12 col-md-4 mt-2">
                        <label>Hora Inicio</label>
                        <input class="form-control" type="text" readonly="" value="${evento.horainicio ? evento.horainicio : "N/A"}">
                    </div>
                    <div class="col-12 col-md-4 mt-2">
                        <label>Fecha Fin</label>
                        <input class="form-control" type="text" readonly="" value="${evento.fechafin ? evento.fechafin : "N/A"}">
                    </div>
                    <div class="col-12 col-md-4 mt-2">
                        <label>Hora Fin</label>
                        <input class="form-control" type="text" readonly="" value="${evento.horafin ? evento.horafin : "N/A"}">
                    </div>
                    <div class="col-12 col-md-4 mt-2">
                        <label>Fecha Recordatorio</label>
                        <input class="form-control" type="text" readonly="" value="${evento.fecharecordatorio ? evento.fecharecordatorio : "N/A"}">
                    </div>
                    <div class="col-12 col-md-4 mt-2">
                        <label>Hora Recordatorio</label>
                        <input class="form-control" type="text" readonly="" value="${evento.horarecordatorio ? evento.horarecordatorio : "N/A"}">
                    </div>
                    <div class="col-12 col-md-4 mt-2">
                        <label>Temporizador</label>
                        <input class="form-control" type="text" readonly="" value="${evento.temporizador ? evento.temporizador : "N/A"}">
                    </div>
                    <div class="col-12 col-md-4 mt-2">
                        <label>Recurrente</label>
                        <input class="form-control" type="text" readonly="" value="${evento.recurrente ? evento.recurrente : "N/A"}">
                    </div>
                    <div class="col-12 col-md-4 mt-2">
                        <label>Periodo</label>
                        <input class="form-control" type="text" readonly="" value="${evento.periodo ? evento.periodo : "N/A"}">
                    </div>
                    <div class="col-12 col-md-4 mt-2">
                        <label>URL</label>
                        <input class="form-control" type="text" readonly="" value="${evento.url ? evento.url : "N/A"}">
                    </div>
                    <div class="col-12 mt-3 d-flex justify-content-between">
                        
                        <button type="button" class="btn btn-warning" onclick="showUpdateForm(${evento.id})">Editar</button>
                        <button type="button" class="btn btn-danger" onclick="showDeleteForm(${evento.id})">Eliminar</button>
                    </div>
                </div>
                `
                $("#bodyEvento").empty().append(body_html);
                eventoModal.toggle()

        });
    }

    // FUNCION PARA MOSTRAR FORMULARIO DE ACTUALIZACIóN DE EVENTO
    function showUpdateForm(evento_id){
        fetch("https://agenda360.ml/api/eventos/"+evento_id)
        .then(response => response.json())
        .then((data) => {
            evento = data.data
            $("#evento_id").val(evento.id)
            $("#update_titulo").val(evento.titulo ? evento.titulo : "")
            $("#update_descripcion").val(evento.descripcion ? evento.descripcion : "")
            $("#update_direccion").val(evento.direccion ? evento.direccion : "")
            $("#update_latitud").val(evento.latitud ? evento.latitud : "")
            $("#update_longitud").val(evento.longitud ? evento.longitud : "")
            $("#update_tipoevento").val(evento.tipoevento ? evento.tipoevento : "")
            $("#update_fecharegistro").val(evento.fecharegistro ? evento.fecharegistro : "")
            $("#update_fechainicio").val(evento.fechainicio ? evento.fechainicio : "")
            $("#update_horainicio").val(evento.horainicio ? evento.horainicio : "")
            $("#update_fechafin").val(evento.fechafin ? evento.fechafin : "")
            $("#update_horafin").val(evento.horafin ? evento.horafin : "")
            $("#update_fecharecordatorio").val(evento.fecharecordatorio ? evento.fecharecordatorio : "")
            $("#update_horarecordatorio").val(evento.horarecordatorio ? evento.horarecordatorio : "")
            $("#update_temporizador").val(evento.temporizador ? evento.temporizador : "")
            $("#update_recurrente").val(evento.recurrente ? evento.recurrente : "")
            $("#update_periodo").val(evento.periodo ? evento.periodo : "")
            $("#update_url").val(evento.url ? evento.url : "")
            updateModal.toggle()
        });
    }
    // MUESTRA MODAL PARA ELIMINAR UN EVENTO
    function showDeleteForm(evento_id) {
        
        $("#evento").val(evento_id);
        deleteModal.toggle()

    }

    // JQUERY EVENTO PARA FORMULARIO NUEVO EVENTO
    $("#nuevoEvento").on("submit",function(event){
        event.preventDefault();
        
        fetch("https://agenda360.ml/api/eventos",{
            method:"POST",
            headers: {
              'Content-Type': 'application/json',
              'Accept':'application/json'
              // 'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: JSON.stringify({
            'usuario_id' : usuario_id,
            'titulo' : $("#titulo").val(),
            'descripcion' : $("#descripcion").val(),
            'direccion' : $("#direccion").val(),
            'latitud' : $("#latitud").val(),
            'longitud' : $("#longitud").val(),
            'tipoevento' : $("#tipoevento").val(),
            'fecharegistro' : $("#fecharegistro").val(),
            'fechainicio' : $("#fechainicio").val(),
            'fechafin' : $("#fechafin").val(),
            'horainicio' : $("#horainicio").val(),
            'horafin' : $("#horafin").val(),
            'fecharecordatorio' : $("#fecharecordatorio").val(),
            'horarecordatorio' : $("#horarecordatorio").val(),
            'temporizador' : $("#temporizador").val(),
            'recurrente' : $("#recurrente").val(),
            'periodo' : $("#periodo").val(),
            'url' : $("#url").val()
        })
        }).then(response => response.json()).then(data => {
            console.log(data)
            nuevoModal.toggle()
            location.reload();

        });
    })
    // EVENTO JQUERY PARA ACTUALIZAR UN EVENTO
    $("#updateEvento").on("submit", function(event){
        event.preventDefault()
        let evento_id = $("#evento_id").val();
        fetch("https://agenda360.ml/api/eventos/"+evento_id,{
            method:"POST",
            headers: {
              'Content-Type': 'application/json',
              'Accept':'application/json'
              // 'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: JSON.stringify({
            'usuario_id' : usuario_id,
            '_method':"PUT",
            'titulo' : $("#update_titulo").val(),
            'descripcion' : $("#update_descripcion").val(),
            'direccion' : $("#update_direccion").val(),
            'latitud' : $("#update_latitud").val(),
            'longitud' : $("#update_longitud").val(),
            'tipoevento' : $("#update_tipoevento").val(),
            'fecharegistro' : $("#update_fecharegistro").val(),
            'fechainicio' : $("#update_fechainicio").val(),
            'fechafin' : $("#update_fechafin").val(),
            'horainicio' : $("#update_horainicio").val(),
            'horafin' : $("#update_horafin").val(),
            'fecharecordatorio' : $("#update_fecharecordatorio").val(),
            'horarecordatorio' : $("#update_horarecordatorio").val(),
            'temporizador' : $("#update_temporizador").val(),
            'recurrente' : $("#update_recurrente").val(),
            'periodo' : $("#update_periodo").val(),
            'url' : $("#update_url").val()
        })
        }).then(response => response.json()).then(data => {
            console.log(data)
            updateModal.toggle()
            location.reload();
        });
    })
    // EVENTO JQUERY PARA ELIMINAR UN REGISTRO
    $("#deleteEvento").on("submit",function(event){
        event.preventDefault();
        let evento_id = $("#evento").val();
        fetch("https://agenda360.ml/api/eventos/"+evento_id,{
            method:"POST",
            headers: {
              'Content-Type': 'application/json',
              'Accept':'application/json'
              // 'Content-Type': 'application/x-www-form-urlencoded',
            },
            body:JSON.stringify({
                "_method":"DELETE"
            })
        }).then(response => response.json()).then(data => {
            console.log(data)
            deleteModal.toggle();
            location.reload();
        });

    })

  

