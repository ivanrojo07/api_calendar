<?php

use Illuminate\Database\Seeder;
//use App\State;
use App\Event;
class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        
        Event::create
        ([
           "titulo"=> "Ángela Solano", 
           'id_usuario'=>3,
           "descripcion"=>"ok",
            "direccion"=>"Ruela Gamboa, 5, Entre suelo 1º, 29090, Os Lucio ",
            "latitud"=>"32.4568567",
            "longitud"=>"-35.4568567",
            "tipoevento"=>"placeat",
            'fecharegistro'=>'2020-11-24 16:31:10',
            "fechainicio"=>"2020-11-24 16:31:10",
            "fechafin"=>"2020-11-24 16:31:10",
            "horainicio"=>"20:50:07",
            "horafin"=>"05:34:44",
            "fecharecordatorio"=>"2020-11-24 16:31:10",
            "horarecordatorio"=>"15:41:41",  
            "temporizador"=>"17:58:44",
            "recurrente"=>"est",
            "periodo"=>"sapiente",
            "url"=>"https://laravel.com/docs/8.x/migrations#introduction",
            'id_project'=>3
        //'state'=>$faker->numberBetween(1,$cantidad)
        //'usuario'=>$faker->numberBetween(1,$cantidad)

        ]);
        
    }
}
