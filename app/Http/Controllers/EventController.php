<?php

namespace App\Http\Controllers;
use App\Event;
use App\Events\Events;
use App\Http\Controllers\ApiController;
use App\Http\Requests\EventRequest;
use App\Http\Requests\EventUpdate;
use App\Http\Resources\Event as EventResource;
use App\Http\Resources\EventCollection;
use App\Project;
use Carbon\Carbon;
use Illuminate\Broadcasting\BroadcastException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class EventController extends ApiController
{
    
    // MOSTRAR LOS EVENTOS REGISTRADOS

    public function index()
    {
      // Obtenemos todos los eventos registrados
      $events=Event::all();
      // Mandamos la colección de modelos en un API Resources
      $resource = new EventCollection($events);
      // retornamos ese API Resources en formato json
      return response()->json(['data'=>$resource],200);
    }

    
    // Guarda un evento o projecto al modelo event
    public function store(EventRequest $request)
    {            

          //  Previamente se crean reglas de validación
          // dentro de la clase EventRequest

          // concatenamos dos parametros(si existen)
          // para los atributos inicio, fin y recordatorio
          // del evento
          $fecha_inicio = (
            // SI EXISTE FECHA INICIO
            $request->fechainicio ? (
              // SI EXISTE HORA DE  INICIO
              $request->horainicio ? (
                // CONCATENAMOS LA FECHA Y HORA DE INICIO DEL REQUEST 
                $request->fechainicio." ".$request->horainicio
                // SI SOLO EXISTE LA FECHA DE INICIO,
                // CREAMOS UN DATETIME CON LAS HORAS POR DEFAULT 00:00:00
                ) : $request->fechainicio." 00:00:00"
              // SI NO HAY FECHA DE INICIO
              // MANDAMOS NULL
              ) : null
          );


          $fecha_fin = (
            // SI EXISTE EN FECHA FIN
            $request->fechafin ? (
              // SI EXISTE HORA FIN
              $request->horafin ? (
                // CONCATENAMOS LA FECHA Y HORA DE FIN DEL REQUEST
                $request->fechafin." ".$request->horafin
                // SI SOLO EXISTE LA FECHA SE REGISTRA CON UNA HORA POR DEFAULT
                ) : $request->fechafin." 00:00:00"
              // SI NO HAY FECHA MANDAMOS NULL
              ) : null
          );

          $fecha_recordatorio = (
            // SI EXISTE FECHA DE RECORDATORIO
            $request->fecharecordatorio ? (
              // SI EXISTE   HORA DE RECORDATORIO
              $request->horarecordatorio ? (
                // CONCATENAMOS FECHA Y HORA DE RECORDATORIO
                $request->fecharecordatorio." ".$request->horarecordatorio
                // SI SOLO EXISTE LA FECHA,SE REGISTRA CON UNA HORA POR DEFAULT
                ) : $request->fecharecordatorio." 00:00:00"
              // SI NO EXISTE FECHA DE RECORDATORIO LO HACEMOS NULL
              ) : null
          );

          // Creamos un array con los parametros anteriores
          // para crear el modelo event
          $parametros=[
         
                'empresa_id'=>$request->empresa_id,
                'sucursal_id'=>$request->sucursal_id,
                'usuario_id' =>$request->usuario_id,
                'supervisor_id'=>$request->supervisor_id,
                'project_id' =>$request->project_id,
                'contacto_id' =>$request->contacto_id,
               
                'titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'direccion' => $request->direccion,
                'latitud' =>$request->latitud,
                'longitud' => $request->longitud,
                'tipoevento' =>$request->tipoevento,
                'fecharegistro' => $request->fecharegistro,
                'inicio' =>$fecha_inicio,
                'fin' => $fecha_fin,
                'recordatorio' => $fecha_recordatorio,
                'temporizador'=> $request->temporizador,
                'recurrente'=> $request->recurrente,
                'periodo' => $request->periodo,
                'url' => $request->url,

          ];
          // Creamos el modelo y lo registramos a la base de datos
           $evento=Event::create($parametros);
           if ($request->participantes_id) {
             foreach ($request->participantes_id as $participante) {
               $evento->participants()->create([
                'usuario_id'=>$participante
               ]);
             }
           }
            try {
                event(new Events($evento,"new"));
            } catch (BroadcastException $e) {
                Log::warning("Pusher Broadcast Exception, $e");
            }
           // Creamos el Api Resource para la respuesta a enviar
           $resource = new EventResource($evento);
           // Retornamos esta respuesta json
           return response()->json(['data'=>$resource],201);
        
        }

    // Muestra un evento con un  id dado
    public function show(Event $evento)
    {
        // Si el evento existe
        if(!$evento){
          // Retornamos una respuesta json 
            return response()->json(['mensaje '=>'No se encontro el evento hora:','codigo'=>404],404);
        }
        // Creamos la API Resources para la respuesta a enviar
       $resource = new EventResource($evento);
       // Retornamos respuesta json con la api resource
       return response()->json(["data"=>$resource],200);
    }

    // Obtiene los eventos de un usuario 
    // y los transforma a una cierta zona horaria
    public function getEvents(Request $request)
    {
      // Validamos los parametros que vamos a tomar
      $request->validate([
        "usuario_id" => "required|numeric",
        "fecha" => "required|date",
        "zona_horaria" => "required|exists:timezones,nombre"
    ]);
    // una vez validado los parametros obtenemos dichos parametros
    //variable para identificador de usuario (id) 
    $usuario_id = $request->usuario_id;
    // // Convertimos la fecha con la clase Carbon
    // $fecha = new Carbon($request->fecha,$request->zona_horaria);
    $fecha = new Carbon($request->fecha);
    // // Le agregamos la zona horaria utc (por defecto)
    // $fecha_utc = $fecha->setTimezone('UTC');
    // // Creamos la fecha de inicio de rango en formato Y-M-D H:I:s
    // $desde = $fecha->toDateTimeString();
    $desde = $request->fecha;
    // Creamos la fecha de final de rango en formato Y-M-D H:I:s
    // $hasta = $fecha->add('days',1)->toDateTimeString();
    $hasta = $fecha->add('days',1)->toDateTimeString();
    // var_dump($desde." ".$hasta);
    // Realizamos la busqueda desde el modelo
    $eventos = Event::where("usuario_id",$usuario_id)->where(function(Builder $query)use($desde,$hasta){
      // UN WHERE BETWEEN A LAS COLUMNAS INICIO Y RECORDATORIO
      $query->whereBetween('inicio',[$desde,$hasta])->orWhereBetween("recordatorio",[$desde,$hasta]);
    })->orWhereHas("participants",function(Builder $query)use($usuario_id){
      $query->where('confirmacion',true)->where('usuario_id',$usuario_id);
    })->where(function(Builder $query)use($desde,$hasta){
      // UN WHERE BETWEEN A LAS COLUMNAS INICIO Y RECORDATORIO
      $query->whereBetween('inicio',[$desde,$hasta])->orWhereBetween("recordatorio",[$desde,$hasta]);
    })->get();
    // creamos un loop para cambiar los formatos de fecha a la zona horaria dado por el usuario
    foreach ($eventos as $evento) {
      // creamo una variable para convertir el atributo inicio del modelo Evento con zona horaria utc(por defecto)
      $ini = new Carbon($evento->inicio,"UTC");
      // Cambiamos el atributo inicio del modelo con la nueva zona horaria
      $evento->inicio = $ini->setTimezone($request->zona_horaria)->toDateTimeString();
      // Creamos una variable para convertir el atrributo fin del modelo Evento con zona horaria
      $fin = new Carbon($evento->fin,"UTC");
      // Cambiamos el atributo fin del modelo con la nueva zona horaria
      $evento->fin = $fin->setTimezone($request->zona_horaria)->toDateTimeString();
      // Creamos una variable para convertir el atributo recordatorio del evento con zona horaria
      $recordatorio = new Carbon($evento->recordatorio,"UTC");
      // cambiamos el atributo recordatorio con la nueva zona horaria
      $evento->recordatorio =$recordatorio->setTimezone($request->zona_horaria)->toDateTimeString();
    }
    // Creamos una Api Resource con los registros obtenidos
    $resource = new EventCollection($eventos);
    // Retornamos una respuesta json con los datos
    return response()->json(['data'=>$resource],200);
    }



    //============Endpoint eventos por usario============
    public function Eventsusuario(Request $request)
    {
      // Validamos el request con los parametros que necesitamos
      $request->validate([
        "usuario_id" => "required|numeric",
        "zona_horaria" => "required|exists:timezones,nombre"
      ]);
      // Separamos en variables los parametros que vamos a tomar
      $usuario_id = $request->usuario_id;
      $zona_horaria = $request->zona_horaria;
      // Obtenemos los registros con un id de usuario en común
      $events = Event::where("usuario_id",$usuario_id)->orWhereHas("participants",function(Builder $query)use($usuario_id){
        $query->where('usuario_id',$usuario_id)->where('confirmacion',true);
      })->get();
      // Creamos un loop para modificar horarios por la zona horaria dada
      foreach ($events as $evento) {
        // creamos una variable con el atributo inicio del modelo Event con zona horaria UTC
        $ini = new Carbon($evento->inicio,"UTC");
        // Actualizamos el atributo inicio con el cambio de la zona horaria que nos indicaron
        $evento->inicio = $ini->setTimezone($request->zona_horaria)->toDateTimeString();
        // Creamos una variable con el atributo fin del modelo Event con la zona horaria utc
        $fin = new Carbon($evento->fin,"UTC");
        // Actualizamos el atributo inicio con el cambio de la zona horaria que nos indicaron
        $evento->fin = $fin->setTimezone($request->zona_horaria)->toDateTimeString();
        // Creamos una variable con el atributo recordatorio del modelo Event con zona horaria utc
        $recordatorio = new Carbon($evento->recordatorio,"UTC");
        // Actualizamos el atributo recordatorio con el cambio de zona horaria que nos indicaron
        $evento->recordatorio =$recordatorio->setTimezone($request->zona_horaria)->toDateTimeString();
      }
      // Modificamos la coleccion en un Api Resources
      $resource = new EventCollection($events);
      // Y retornamos el api resources a la respuesta
      return response()->json(['data'=>$resource],200);

    }

    // Actualiza un registro del modelo Event
    public function update(EventUpdate $request, Event $evento)
    {  
      //  Previamente se crean reglas de validación
      // dentro de la clase EventRequest

      // concatenamos dos parametros(si existen)
      // para los atributos inicio, fin y recordatorio
      // del evento
      $fecha_inicio = (
        $request->fechainicio ? (
          $request->horainicio ? (
            $request->fechainicio." ".$request->horainicio
            ) : $request->fechainicio." ".$evento->hora_inicio
          ) : $evento->inicio
      );

      $fecha_fin = (
        $request->fechafin ? (
          $request->horafin ? (
            $request->fechafin." ".$request->horafin
            ) : $request->fechafin." ".$evento->hora_fin
          ) : $evento->fin
      );

      $fecha_recordatorio = (
        $request->fecharecordatorio ? (
          $request->horarecordatorio ? (
            $request->fecharecordatorio." ".$request->horarecordatorio
            ) : $request->fecharecordatorio." ".$evento->hora_recordatorio
          ) : $evento->recordatorio
      );
      // Creamos un objeto con los atributos del event, cambiando parametros del request (si existen)
      $parametros=[
        'empresa_id' => $request->empresa_id ? $request->empresa_id : $evento->empresa_id,
        'sucursal_id' =>$request->sucursal_id ? $request->sucursal_id : $evento->sucursal_id,
        'usuario_id' => $request->usuario_id ? $request->usuario_id : $evento->usuario_id,
        'supervisor_id'=>$request->supervisor_id ? $request->supervisor_id : $evento->supervisor_id,
        'project_id' => $request->project_id ? $request->project_id : $evento->project_id,
        'contacto_id' => $request->contacto_id ? $request->contacto_id : $evento->contacto_id,

        'titulo' => $request->titulo ? $request->titulo : $evento->titulo,
        'descripcion' => $request->descripcion ? $request->descripcion : $evento->descripcion,
        'direccion' => $request->direccion ? $request->direccion : $evento->direccion,
        'latitud' =>$request->latitud ? $request->latitud : $evento->latitud,
        'longitud' => $request->longitud ? $request->longitud : $evento->longitud,
        'tipoevento' =>$request->tipoevento ? $request->tipoevento : $evento->tipoevento,
        'fecharegistro' => $request->fecharegistro ? $request->fecharegistro : $evento->fecharegistro,
        'inicio' =>$fecha_inicio,
        'fin' => $fecha_fin,
        'recordatorio' => $fecha_recordatorio,
        'temporizador' =>$request->temporizador ? $request->temporizador : $evento->temporizador,
        'recurrente' => $request->recurrente ? $request->recurrente : $evento->recurrente,
        'periodo' => $request->periodo ? $request->periodo : $evento->periodo,
        'url' => $request->url ? $request->url : $evento->url,

      ];
      // Actualizamos el modelo con los parametros anteriores
      $evento->update($parametros);
      if ($request->participantes_id) {
          $evento->participants()->delete();
          foreach ($request->participantes_id as $participante) {
            $evento->participants()->create([
            'usuario_id'=>$participante
           ]);
         }
      }
      try {
          event(new Events($evento,"update"));
      } catch (BroadcastException $e) {
          Log::warning("Pusher Broadcast Exception, $e");
      }
      // Creamos el Api Resources para la serializacion de nuestro modelo
      $resource = new EventResource($evento);
      // Y retornamos en una respuesta json
      return response()->json(['data'=>$resource],201);
               

    }

    // Registro de un usuario por proyecto
    public function proyecto(Request $request)
    {
        // Validamos parametros
        $request->validate([
      		"usuario_id" => "required|numeric",
      		"project" => "required|exists:projects,nombre"
        ]);
        // Obtenemos las variables que vamos a utilizar del request
    	  $usuario_id = $request->usuario_id;
        $proyecto_nombre = strtolower($request->project);
        // Realizamos la busqueda con el usuario y buscando el nombre del proyecto
        $events = Event::where("usuario_id",$usuario_id)
        ->whereHas("project",function(Builder $query)use($proyecto_nombre){$query
        ->where("nombre",$proyecto_nombre);})->with('project')->get();
     
        // Modificamos la coleccion en un Api Resources
        $resource = new EventCollection($events);
        // Y retornamos el api resources a la respuesta
        return response()->json(['data'=>$resource],200);
    }


    // Elimina un registro del modelo Event con un id dado
    public function destroy(Event $evento)
    {
      // Si el evento no existe
      if(!$evento){
        // Retornamos un mensaje con el error de que el evento n se encuentra
        return response()->json(['mensaje'=>'Evento no se encuentra ','codigo'=>404],404);
      }
      // Si el evento existe lo eliminamos
      $evento->delete();
      try {
          event(new Events($evento,"delete"));
      } catch (BroadcastException $e) {
          Log::warning("Pusher Broadcast Exception, $e");
      }
      // Creamos un Api Resource con el evento eliminado
      $resource = new EventResource($evento);
      // Y retornamos el api resource a nuestra respuesta.
      return response()->json(['data'=>$resource],200);
    }
}
