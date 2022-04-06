<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
class ProjectController extends ApiController
{

    public function index()
    {
        $project=Project::all();
        //return 'Mostrar la lista de todos los poryectos  ' . $project;
        return response()->json(['data'=>$project],202);
        //return $this->showAll($project);
    }

    
    public function store(Request $request)
    {
       /*  if(!$request->get('nombre') || !$request->get('descripcion')){
        return response()->json(['mensaje'=>'faltan datos','codigo'=>422],422);
       }*/
       $reglas=[
        "nombre" => "required",
        "descripcion" => "required"   ];
       $this->validate ($request,$reglas);
       $project=Project::create($request->all());
       // return response()->json(['mensaje'=>'Proyecto Creado','codigo'=>202],202);
        return $this->showOne($project);
    }

   
    public function show($id)
    {
        $project=Project::find($id);
     
        if(!$project){
            return response()->json(['mensaje '=>'No se encontro el proyecto','codigo'=>404],404);
        }
        //return response()->json(['data'=>$project],202);
        return $this->showOne($project);
    }

 


    public function update(Request $request,$id)
    {
       

        $project=Project::find($id);
        

            $nombre=$request->get('nombre');
            if($nombre!=null && $nombre!=''){
                $project->nombre=$nombre; }
                $descripcion=$request->get('descripcion');
            if($descripcion!=null && $descripcion!=''){
                $project->descripcion=$descripcion; }

            $project->update();
           // return response()->json(['mensaje'=>'Proyecto Editado con exito','codigo'=>202],202);
            return $this->showOne($project);
        
    }

  
    public function destroy($id)
    {
        $project=Project::findOrFail($id);
        if(!$project){
            return response()->json(['mensaje'=>'Proyecto no se encuentra ','codigo'=>202],202);
        }
        
        $project->delete();
       // return response()->json(['mensaje'=>'Proyecto eliminado ','codigo'=>200],200);
       return $this->showOne($project);
    }
        //return 'Mostrar formulario para eliminar proyecto  con id '.$id;
    
}
