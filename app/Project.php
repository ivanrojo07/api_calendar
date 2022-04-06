<?php

namespace App;
use Event;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Project extends Model
{
    use SoftDeletes;
    protected $fillable = ['nombre', 'descripcion' ];
    protected $hidden=['created_at','updated_at'];

    public function events(){
        return $this->hasMany('App\Event');
    }
    
}
