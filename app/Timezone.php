<?php

namespace App;

use App\Event;
use Illuminate\Database\Eloquent\Model;

class Timezone extends Model
{
  
    protected $fillable = ['nombre'];
    protected $hidden=['created_at','updated_at'];

    public function events(){
        return $this->hasMany('App\Event');
    }

}
