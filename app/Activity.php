<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
     protected $fillable = [ 
     	'Titulo',
     	'FechaInicio',
        'FechaFin',
        'category_id',
        'state_id' ];
    protected $hidden=['created_at','updated_at'];
    
    public function project(){
        return $this->belongsTo('App\Category');
    }
}
