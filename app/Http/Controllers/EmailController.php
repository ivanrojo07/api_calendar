<?php

namespace App\Http\Controllers;

use App\Event;
use App\Mail\IcalendarEvent;
use App\Mail\IcalendarUser;
use App\Mail\Prueba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    //

    public function prueba(){
    	 Mail::to(["email"=>"guillermo.rojo@globalcorporation.cc"])->send(new Prueba());
    	 return response()->json(['success'=>true],200);
    }

    public function event(Request $request){
    	$rules = [
    		'evento_id'=>'required|numeric|exists:events,id',
    		'correo'=>'required|email:rfc,dns',
    		'asunto'=>'nullable|string|max:255',
    		'cuerpo'=>'nullable|string|max:255',
    	];

    	$request->validate($rules);
    	$event = Event::find($request->evento_id);
    	try {
	    	Mail::to($request->correo)->send( new IcalendarEvent($event,$request->asunto,$request->cuerpo));
	    	return response()->json(['success'=>true,'mensaje'=>"Se envio el correo satisfactoriamente","errores"=>null]);
    		
    	} catch (Exception $e) {
    		return response()->json(['success'=>false,'mensaje'=>"No se envio el correo", "errores"=>$e]);
    	}
    	
    }

    public function user_calendar(Request $request){
    	$rules = [
    		'user_id'=>'required|numeric',
    		'correo'=>'required|email:rfc,dns',
    		'asunto'=>'nullable|string|max:255',
    		'cuerpo'=>'nullable|string|max:255',
    	];

    	$request->validate($rules);
    	try {
	    	Mail::to($request->correo)->send( new IcalendarUser($request->user_id,$request->asunto,$request->cuerpo));
	    	return response()->json(['success'=>true,'mensaje'=>"Se envio el correo satisfactoriamente","errores"=>null]);
    		
    	} catch (Exception $e) {
    		return response()->json(['success'=>false,'mensaje'=>"No se envio el correo", "errores"=>$e]);
    	}
    	
    }
}
