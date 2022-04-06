<?php

namespace App\Http\Controllers;

use App\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $state=State::all();
        //return 'Mostrar la lista de todos los poryectos  ' . $project;
        return response()->json(['Acceso a State'=>$state],202);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->get('Nombre') ){
            return response()->json(['mensaje'=>'falta dato','codigo'=>422],422);
           }
           State::create($request->all());
          
            return response()->json(['mensaje'=>'State Creado','codigo'=>202],202);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $state=State::find($id);
        //return 'Mostrar la lista de todos los poryectos  ' . $project;
        if(!$state){
            return response()->json(['mensaje '=>'No se encontro el state','codigo'=>404],404);
        }
        return response()->json(['Acceso a State'=>$state],202);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function edit(State $state)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $metodo=$request->method();
        $state=State::find($id);
        $flag=false;

        if($metodo==="PATCH"){
            $Nombre=$request->get('Nombre');
            if($Nombre!=null && $Nombre!=''){
                $state->Nombre=$Nombre;
                $flag=true;
            }
            if($flag){
            $state->save();
            return response()->json(['mensaje'=>'State Editado con exito','codigo'=>202],202);
            }
            return response()->json(['mensaje'=>'No se hicieron los cambios','codigo'=>200],200);
        }
        
        $Nombre=$request->get('Nombre');
     
        if(!$Nombre){
            return response()->json(['mensaje '=>'Dato Invalido','codigo'=>404],404);
        }

        $state->Nombre=$Nombre;
       
        $state->save();
      
        return response()->json(['mensaje'=>'Proyecto Grabado con exito','codigo'=>202],202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $state=State::find($id);
        if(!$state){
            return response()->json(['mensaje'=>'State no se encuentra ','codigo'=>202],202);
        }
       /* $category=$project->categories;
        if(sizeof($category)>0){
            return response()->json(['mensaje'=>'Proyecto posee categorias no se puede eliminar','codigo'=>404],404);
        
    }*/

        $state->delete();
        return response()->json(['mensaje'=>'State eliminado ','codigo'=>200],200);
    }
        //return 'Mostrar formulario para eliminar proyecto  con id '.$id;
    
}
