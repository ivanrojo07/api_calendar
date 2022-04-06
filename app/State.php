<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = [ 'Nombre'];
    protected $hidden=['created_at','updated_at'];

    public function Event(){
        return $this->belongsTo('App\Event');
    }
}
