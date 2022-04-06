<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
class CategoryController extends Controller
{
    public function index()
    {
        $category=Category::all();
        //return 'Mostrar la lista de todos los poryectos  ' . $project;
        if(!$category){
            return response()->json(['mensaje '=>'No hay categorias','codigo'=>404],404);
        }
        return response()->json(['Acceso a Categorias'=>$category],202);
   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return 'Mostrar menu para crear  Category  ';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category=Category::find($id);
        //return 'Mostrar la lista de todos los poryectos  ' . $project;
        if(!$category){
            return response()->json(['mensaje '=>'No se encontro el categoria','codigo'=>404],404);
        }
        return response()->json(['Acceso a categorias'=>$category],202);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return 'Mostrar formulario para editar proyecto  con id '.$id;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        return 'Mostrar formulario para modificar proyecto  con id '.$id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        return 'Mostrar formulario para eliminar proyecto  con id '.$id;
    }
}
