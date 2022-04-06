<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Resources\Event as EventResource;
use App\Lista;
use Illuminate\Http\Request;


class ListaController extends Controller
{
    //
    public function getList(Event $evento){
        $listas = $evento->lists;
        if ($listas) {
            return response()->json(['listas' => $listas],201);
        }
        else{
            return response()->json(['listas'=>null],404);
        }
    }
    public function create(Request $request){
    	$request->validate([
    		'event_id'=>'required|numeric',
    		'listas' => 'array|required',
    		'listas.*.titulo' => 'required|string',
    		'listas.*.descripcion'=>'nullable|string'
    	]);
    	$event_id = $request->event_id;
    	$lista_params = $request->listas;
    	$event = Event::findOrFail($event_id);

    	foreach ($lista_params as $param) {
    		
    		$event->lists()->create($param);
    	}
    	// Creamos el Api Resource para la respuesta a enviar
       $resource = new EventResource($event);
       // Retornamos esta respuesta json
       return response()->json(['data'=>$resource],201);

    }

    public function check(Lista $lista)
    {
        $lista->hecho = !$lista->hecho;
        $lista->save();
        return response()->json(['lista'=>$lista],201);
    }

    public function update(Request $request, Lista $lista){
        $request->validate([
            'titulo'=>'required|string',
            'descripcion'=>'nullable|string'
        ]);
        $lista->update($request->all());
        return response()->json(['lista'=>$lista],201);
    }

    public function delete(Lista $lista){
        $lista->delete();
        return response()->json(['lista'=>$lista],204);
    }
}
