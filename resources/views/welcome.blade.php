<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- FULLCALENDAR CSS -->
    <link href='core/main.css' rel='stylesheet' />
    <link href='daygrid/main.css' rel='stylesheet' />

    <link href='list/main.css' rel='stylesheet' />
    <link href='timegrid/main.css' rel='stylesheet' />

     <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <!-- TITULO HTML -->
    <title>Agenda</title>
</head>
<!-- BODY -->
<body>
    <!-- CONTAINER -->
    <div class="container py-4">
        <!-- ROW -->
        <div class="row">
            <!-- GRID BOTONES NUEVO Y HOY -->
            <div class="col-12 col-md-2 d-flex flex-column justify-content-center">
                <!-- BOTON NUEVO EVENTO (MUESTRA MODAL CON FORMULARIO) -->
                <button type="button" class="btn btn-success mt-3 p-auto" data-bs-toggle="modal" data-bs-target="#nuevoModal">Nuevo evento</button>
                <!-- BOTON EVENTOS DEL DíA DE HOY -->
                <button type="button" class="btn btn-info mt-3 p-auto"  data-bs-toggle="modal" data-bs-target="#eventosHoyModal">Eventos de hoy</button>
            </div>
            <!-- GRID CALENDARIO -->
            <div class="col-12 col-md-10 bg-light">
                <!-- CALENDARIO (APLICAR SU ESTILOS)-->
                <div id='calendar' style="max-width: 900px;margin: 40px auto;"></div>
            </div>
        </div>
    </div>


    <!-- MODALS -->

    <!-- MODAL PARA MOSTRAR FORMULARIO PARA NUEVO EVENTO -->
    <div class="modal fade" id="nuevoModal" tabindex="-1" aria-labelledby="nuevoEventoModalLabel" aria-hidden="true">
        <!-- Pantalla fullscreen -->
        <div class="modal-dialog modal-fullscreen">
            <!-- CONTENIDO DEL MODAL -->
            <div class="modal-content">
                <!-- HEADER -->
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevoEventoModalLabel">Nuevo Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- FORMULARIO CON ID "nuevoEvento" -->
                <form id="nuevoEvento">
                    <!-- BODY DEL MODAL CON LOS INPUTS DEL EVENTO -->
                    <div class="modal-body">
                        <!-- CONTAINER  -->
                        <div class="container">
                            <!-- ROW -->
                            <div class="row">
                                <!-- TITULO -->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="titulo">Titulo</label>
                                    <input class="form-control" type="text" id="titulo" required="">
                                </div>
                                <!-- DESCRIPCION -->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="descripcion">Descripción</label>
                                    <input class="form-control" type="text" id="descripcion">
                                </div>
                                <!-- DIRECCION -->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="direccion">Dirección</label>
                                    <input class="form-control" type="text" id="direccion">
                                </div>
                                <!-- LATITUD -->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="latitud">Latitud</label>
                                    <input class="form-control" type="text" id="latitud">
                                </div>
                                <!-- LONGITUD -->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="longitud">Longitud</label>
                                    <input class="form-control" type="text" id="longitud">
                                </div>
                                <!-- TIPO DE EVENTO -->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="tipoevento">Tipo de evento</label>
                                    <input class="form-control" type="text" id="tipoevento">
                                </div>
                                <!-- FECHA DE REGISTRO -->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="fecharegistro">Fecha Registro</label>
                                    <input class="form-control" type="date" required="" id="fecharegistro">
                                </div>
                                <!-- FECHA DE INICIO -->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="fechainicio">Fecha de Inicio</label>
                                    <input class="form-control" type="date" required="" id="fechainicio">
                                </div>
                                <!-- HORA DE INICIO -->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="horainicio">Hora de Inicio</label>
                                    <input class="form-control" type="time" id="horainicio">
                                </div>
                                <!-- FECHA FIN -->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="fechafin">Fecha Fin</label>
                                    <input class="form-control" type="date" required="" id="fechafin">
                                </div>
                                <!-- HORA FIN -->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="horafin">Hora Fin</label>
                                    <input class="form-control" type="time" id="horafin">
                                </div>
                                <!-- FECHA RECORDATORIO -->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="fecharecordatorio">Fecha Recordatorio</label>
                                    <input class="form-control" type="date" id="fecharecordatorio">
                                </div>
                                <!-- HORA RECORDATORIO -->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="horarecordatorio">Hora Recordatorio</label>
                                    <input class="form-control" type="time" id="horarecordatorio">
                                </div>
                                <!-- TEMPORIZADOR -->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="temporizador">Temporizador</label>
                                    <input class="form-control" type="time" id="temporizador">
                                </div>
                                <!-- RECURRENTE -->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="recurrente">Recurrente</label>
                                    <input class="form-control" type="text" id="recurrente">
                                </div>
                                <!-- PERIODO -->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="periodo">Periodo</label>
                                    <input class="form-control" type="text" id="periodo">
                                </div>
                                <!-- URL -->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="url">URL</label>
                                    <input class="form-control" type="url" id="url">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- FOOTER PARA BOTONES -->
                    <div class="modal-footer" style="
                    position: fixed;
                    height: 100px;
                    bottom: 0;
                    width: 100%;
                    ">
                        <!-- BOTON CANSELAR/QUITAR MODAL -->
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <!-- ENVIAR FORMULARIO -->
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL DE EVENTOS DEL DíA -->
    <div class="modal fade" id="eventosHoyModal" tabindex="-1" aria-labelledby="hoyEventoModalLabel" aria-hidden="true">
        <!-- MODAL FULLSCREEN -->
        <div class="modal-dialog modal-fullscreen">
            <!-- CONTENIDO DEL MODAL -->
            <div class="modal-content">
                <!-- MODAL HEADER -->
                <div class="modal-header">
                    <h5 class="modal-title" id="hoyEventoModalLabel">Eventos Hoy</h5>
                    <!-- BOTON CLOSE -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- BODY DEL MODAL QUE SE LLENARA A TRAVES DEL AJAX -->
                <div class="modal-body" id="bodyEventosDia">
                    <div class="mx-auto justify-content-center">
                        <h1>Eventos del día:</h1>
                    </div>
                </div>
                <!-- FOOTER -->
                <div class="modal-footer">
                    <!-- BOTON CERRAR MODAL -->
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MOSTRAR EVENTO -->
    <div class="modal fade" id="showEventoModal" tabindex="-1" aria-labelledby="showEventoModalLabel" aria-hidden="true">
        <!-- MODAL XL -->
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- HEADER -->
                <div class="modal-header">
                    <h5 class="modal-title" id="showEventoModalLabel">Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- BODY DEL MODAL QUE SE LLENARA CON EL AJAX -->
                <div class="modal-body" id="bodyEvento"></div>
                <!-- FOOTER DEL MODAL -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- MODAL PARA ACTUALIZAR UN EVENTO -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateEventoModalLabel" aria-hidden="true">
        <!-- MODAL XL -->
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- ACTUALIZAR -->
                <div class="modal-header">
                    <h5 class="modal-title" id="updateEventoModalLabel">Actualizar Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- FORM CON ID updateEvento -->
                <form id="updateEvento">
                    <!-- BODY CON LOS INPUTS DEL EVENTO -->
                    <div class="modal-body">
                        <!-- CONTAINER -->
                        <div class="container">
                            <!-- ROW -->
                            <div class="row">
                                <!-- TITULO -->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="titulo">Titulo</label>
                                    <input class="form-control" type="text" id="update_titulo" required="">
                                    <input type="hidden" id="evento_id" required="">
                                </div>
                                <!-- DESCRIPCION -->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="descripcion">Descripción</label>
                                    <input class="form-control" type="text" id="update_descripcion">
                                </div>
                                <!-- DIRECCION -->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="direccion">Dirección</label>
                                    <input class="form-control" type="text" id="update_direccion">
                                </div>
                                <!-- LATITUD -->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="latitud">Latitud</label>
                                    <input class="form-control" type="text" id="update_latitud">
                                </div>
                                <!-- LONGITUD -->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="longitud">Longitud</label>
                                    <input class="form-control" type="text" id="update_longitud">
                                </div>
                                <!-- TIPO EVENTO -->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="tipoevento">Tipo de evento</label>
                                    <input class="form-control" type="text" id="update_tipoevento">
                                </div>
                                <!-- FECHA DE REGISTRO -->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="fecharegistro">Fecha Registro</label>
                                    <input class="form-control" type="date" id="update_fecharegistro">
                                </div>
                                <!-- FECHA DE INICIO -->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="fechainicio">Fecha de Inicio</label>
                                    <input class="form-control" type="date" id="update_fechainicio">
                                </div>
                                <!-- HORA DE INICIO -->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="horainicio">Hora de Inicio</label>
                                    <input class="form-control" type="time" id="update_horainicio">
                                </div>
                                <!-- FECHA FIN -->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="fechafin">Fecha Fin</label>
                                    <input class="form-control" type="date" id="update_fechafin">
                                </div>
                                <!-- HORA FIN -->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="horafin">Hora Fin</label>
                                    <input class="form-control" type="time" id="update_horafin">
                                </div>
                                <!-- FECHA RECORDATORIO -->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="fecharecordatorio">Fecha Recordatorio</label>
                                    <input class="form-control" type="date" id="update_fecharecordatorio">
                                </div>
                                <!-- Hora recordatorio -->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="horarecordatorio">Hora Recordatorio</label>
                                    <input class="form-control" type="time" id="update_horarecordatorio">
                                </div>
                                <!-- TEMPORIZADOR -->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="temporizador">Temporizador</label>
                                    <input class="form-control" type="time" id="update_temporizador">
                                </div>
                                <!-- RECU RRENTE-->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="recurrente">Recurrente</label>
                                    <input class="form-control" type="text" id="update_recurrente">
                                </div>
                                <!-- PERIODO -->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="periodo">Periodo</label>
                                    <input class="form-control" type="text" id="update_periodo">
                                </div>
                                <!-- URL -->
                                <div class="col-12 col-md-4 mt-5">
                                    <label for="url">URL</label>
                                    <input class="form-control" type="url" id="update_url">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- FOOTER -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ELIMINAR EVENTO -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteEventoModalLabel" aria-hidden="true">
        <!-- MODAL POR DEFAULT -->
        <div class="modal-dialog">
            <!-- CONTENT MODAL -->
            <div class="modal-content">
                <!-- HEADER -->
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteEventoModalLabel">Eliminar Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- FORMULARIO CON ID "deleteEvento" -->
                <form id="deleteEvento">
                    <!-- BODY  -->
                    <div class="modal-body">
                        <!-- CONTAINER -->
                        <div class="container">
                            <!-- INPUT HIDDEN CON EL EVENTO_ID -->
                            <input type="hidden" id="evento" required="">
                            <!-- ROW CON ALERTA PARA NOTIFICAR QUE NO SE PODRA RECUPERAR -->
                            <div class="row">
                                Eliminar registro (ya no lo podrás recuperar)
                            </div>
                        </div>
                    </div>
                    <!-- FOOTER PARA BOTONERAS -->
                    <div class="modal-footer">
                        <!-- BOTON CERRAR -->
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <!-- BOTON ENVIAR FORMULARIO -->
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <!-- JQuery 3.5 -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <!-- FULL CALENDAR JS -->
    <script src='core/main.js'></script>
    <script src='interaction/main.js'></script>
    <script src='daygrid/main.js'></script>
    <script src='list/main.js'></script>
    <script src='timegrid/main.js'></script>
    <!-- FUNCIONES PARA COMUNICARSE CON EL BACKEND AGENDA360 -->
    <script src='main.js'></script>
  
</body>

</html>