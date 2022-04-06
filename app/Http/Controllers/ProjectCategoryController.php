<?php

namespace App\Http\Controllers;

use App\Project;
use App\Category;
use Illuminate\Http\Request;

class ProjectCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $project=Project::find($id);
        $category=$project->Categories;
        if(!$category){
            return response()->json(['mensaje '=>'No se encontro el proyecto','codigo'=>404],404);
        }
        return response()->json(['Acceso a categorias'=>$category],202);
        
    }
   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return 'Mostrar formulario para crear una categoria'.$id;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   // Metodo POST 
    public function store(Request $request, $id)
    {
        if( !$request->get('Nombre') || !$request->get('Descripcion')){
            return response()->json(['mensaje'=>'Faltan ','codigo'=>422],422);
           }

         $project=Project::find($id);
        if (!$project) {
            return response()->json(['mensaje'=>'Proyecto no existe','codigo'=>404],404);
          }

        Event::create([
            'Nombre'=>$request->get('Nombre'),
            'Descripcion'=>$request->get('Descripcion'),
            'project_id'=>$id
            ]);

        return response()->json(['mensaje'=>'Categoria Creado'],201);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($idproject, $idcategory)
    {
        
        return "Mostrando la categoria". $idcategory.'del proyecto'.$idproject;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$idproject, $idcategory)
    {
        
        return 'Mostrar formulario para editar una categoria'.$idcategory.' del proyecto '.$idproject;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    //Actualizando Recursos Individuales con PUT Y PATCH
    public function update(Request $request,$idproject,  $idcategory)
    {

        $metodo=$request->method();
        $project=Project::find($idproject);
        if(!$project){
            return response()->json(['mensaje '=>'No se encuentra el proyecto','codigo'=>404],404);
        }
        $category=$project->categories()->find($idcategory);
        if(!$category){
            return response()->json(['mensaje '=>'No se encuentra categoria','codigo'=>404],404);
        }

        $nombre=$request->get('Nombre');
        $descripcion=$request->get('Descripcion');
        $flag=false;

        if($metodo==="PATCH"){
           // $nombre=$request->get('Nombre');
            if($nombre!=null && $nombre!=''){
                $project->Nombre=$nombre;
                $flag=true;
            }
            //$descripcion=$request->get('Descripcion');
            if($descripcion!=null && $descripcion!=''){
                $project->Descripcion=$descripcion;
                $flag=true;
            }
            if($flag){
              $category->save();
            return response()->json(['mensaje'=>'Categoria Editado con exito','codigo'=>202],202);  
            }
            return response()->json(['mensaje '=>'No se guardadron los cambios ','codigo'=>200],200);
        }
        
        //$nombre=$request->get('Nombre');
        //$descripcion=$request->get('Descripcion');
        if(!$nombre || !$descripcion){
            return response()->json(['mensaje '=>'Datos Invalidos','codigo'=>404],404);
        }

        $project->Nombre=$nombre;
        $project->Descripcion=$descripcion;
        $category->save();
      
        return response()->json(['mensaje'=>'Categoria Grabado con exito','codigo'=>202],202);
        
      //  return 'Mostrar formulario para actualizar una categoria'.$idcategory.' del proyecto '.$idproject;
 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($idproject, $idcategory)
    {
        $project=Project::find($idproject);
        if(!$project){
            return response()->json(['mensaje'=>'Poryecto no se encuentra ','codigo'=>202],202);
        }
        $category=$project->categories()->find($idcategory);
        if(!$category){
            return response()->json(['mensaje'=>'Categoria  no se encuentra asociada al proyecto','codigo'=>404],404);
        }

        $event->delete();
        return response()->json(['mensaje'=>'Categoria eliminada ','codigo'=>200],200);
    }
}
