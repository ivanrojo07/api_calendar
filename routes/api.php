<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

  
// CRUD proyectos
Route::resource('proyectos', 'ProjectController');
// CRUD zona horarias
Route::resource('zonashorarias', 'TimezoneController');

//===============Eventos========
// Los eventos de un dia dado
Route::post("eventos/dia","EventController@getEvents");
// Todos los eventos de un usuario
Route::post("eventos/usuario","EventController@Eventsusuario");
Route::post("eventos/participante","ParticipantController@confirm");
Route::post("eventos/participante/confirm","ParticipantController@checkConfirm");
Route::get("eventos/{evento}/lista","ListaController@getList");
Route::post('eventos/lista',"ListaController@create");
Route::put('eventos/lista/{lista}',"ListaController@update");
Route::delete('eventos/lista/{lista}',"ListaController@delete");
Route::get("eventos/lista/check/{lista}",'ListaController@check');
//Route::post("eventos/mes","EventController@getEventsmes");
// CRUD eventos
Route::resource('eventos', 'EventController');
// Proyecto por usuario
Route::post("agenda/proyecto", "EventController@proyecto");

// Mail
Route::post('email/event','EmailController@event');
Route::post('email/calendar','EmailController@user_calendar');


//================
//Route::resource('eventos.proyecto', 'Event\EventProjectController',['only'=>['index']]);
//Route::resource('proyectos.eventos', 'ProjectEventController',['except'=>['show']]);
//Route::resource('categorias', 'CategoryController',['only'=>['index','show']]);
//Route::resource('proyectos.categorias', 'ProjectCategoryController',['except'=>['show']]);

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
