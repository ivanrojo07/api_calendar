<?php

namespace App\Http\Controllers;
use App\Project;
use App\Event;
use Illuminate\Http\Request;
use App\Http\Requests\EventCreateRequest;

class ProjectEventController extends Controller
{
    
    public function index($id)
    {
        $project=Project::find($id);
        $event=$project->events;
        if(!$event){
            return response()->json(['mensaje '=>'No se encontro evento','codigo'=>404],404);
        }
        return response()->json(['Acceso a eventos'=>$event],202);
        
    }
   
    public function getEvents(Request $request)
    {
        $request->validate([
            "id_usuario" => "required|numeric",
            "fecha" => "required|date"
        ]);
        $id_usuario = $request->id_usuario;
        $fecha = $request->fecha;

        $eventos = Event::where("id_usuario","=",$id_usuario)->where(function($query)use($fecha){
            $query->where('fechainicio',$fecha)
                ->orWhere('fecharecordatorio',$fecha);
        })->get();
        return response()->json(['mensaje'=>'Success',"eventos"=>$eventos,'codigo'=>202],202);
    }

    public function create()
    {
        return 'Mostrar formulario para crear una categoria'.$id;
    }

    
   // Metodo POST 
    public function store(EventCreateRequest $request, $id)
    {
        if( !$request->get('Nombre') || !$request->get('Descripcion')){
            return response()->json(['mensaje'=>'Faltan ','codigo'=>422],422);
           }

         $project=Project::find($id);
        if (!$project) {
            return response()->json(['mensaje'=>'Proyecto no existe','codigo'=>404],404);
          }

        Category::create([
            'Nombre'=>$request->get('Nombre'),
            'Descripcion'=>$request->get('Descripcion'),
            'project_id'=>$id
            ]);

        return response()->json(['mensaje'=>'Categoria Creado'],201);
    }
    
    public function show($idproject, $idcategory)
    {
        
        return "Mostrando la categoria". $idcategory.'del proyecto'.$idproject;
    }

    
    public function edit(Request $request,$idproject, $idcategory)
    {
        
        return 'Mostrar formulario para editar una categoria'.$idcategory.' del proyecto '.$idproject;
    }

    
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

        $category->delete();
        return response()->json(['mensaje'=>'Categoria eliminada ','codigo'=>200],200);
    }
}
