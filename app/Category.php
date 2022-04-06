<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [ 
    	'Nombre', 'Descripcion','project_id' ];
    protected $hidden=['created_at','updated_at'];
    
    public function project(){
        return $this->belongsTo('App\Project');
    }

}
