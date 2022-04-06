<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lista extends Model
{
    //
    protected $fillable=[
    	'titulo',
		'descripcion',
		'hecho'
    ];

    protected $hidden=[
    	'created_at',
    	'deleted_at'
    ];

    public function event()
    {
    	return $this->belongsTo('App\Event');
    }
}
