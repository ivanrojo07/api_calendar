<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Resources\Event as EventResource;
use App\Participante;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    //

    public function confirm(Request $request)
    {
    	$request->validate([
    		"evento_id"=>"required|numeric",
    		"usuario_id"=>"required|numeric",
    		"confirm"=>"required|boolean"
    	]);
    	$participante = Participante::where([['event_id',$request->evento_id],['usuario_id',$request->usuario_id]])->first();
    	if ($participante) {
			$participante->confirmacion = $request->confirm;
			$participante->save();
    		// Creamos el Api Resource para la respuesta a enviar
           	$resource = new EventResource($participante->event);
           	// Retornamos esta respuesta json
           	return response()->json(['data'=>$resource],201);
    	}
    	else{
    		return response()->json(['error'=>"no estas dentro de la lista de participante o no existe el evento"],404);

    	}
    }

    public function checkConfirm(Request $request)
    {
        $request->validate([
            'usuario_id' => "required|numeric",
            'fecha' => "required|date"
        ]);
        $usuario_id = $request->usuario_id;
        $fecha = $request->fecha;
        $evento = Event::whereHas("participants",function(Builder $query)use($usuario_id){
            $query->where('confirmacion',null)->where('usuario_id',$usuario_id);
        })->where(function(Builder $query)use($fecha){
            // UN WHERE BETWEEN A LAS COLUMNAS INICIO Y RECORDATORIO
            $query->whereDate('inicio','>=',$fecha);
        })->first();
        if ($evento) {
            
            // Creamos el Api Resource para la respuesta a enviar
            $resource = new EventResource($evento);
            // Retornamos esta respuesta json
            return response()->json(['data'=>$resource],201);
        }
        else{
            return response()->json(['data'=>null],404);
        }
        
    }
}
