<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participante extends Model
{
    //
    protected $fillable = [
    	'usuario_id',
		'event_id',
        'confirmacion'
    ];

    /**
     * Get the event that owns the participante.
     */
    public function event()
    {
        return $this->belongsTo('App\Event');
    }
}
