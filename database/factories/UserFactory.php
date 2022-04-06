<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Carbon\Carbon;
//use App\User;
//use App\Category;
use App\Project;
//use App\State;
use App\Event;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/


$factory->define(Project::class, function (Faker $faker) {
    return [
        'nombre' => $faker->word,
        'descripcion' => $faker->paragraph(1),
       ];});
    

  /* $factory->define(State::class, function (Faker $faker) {
        return [
            'nombre' => $faker->word,
        
           ];});


$factory->define(Category::class, function (Faker $faker) {
    return [
        'nombre' => $faker->word,
        'descripcion' => $faker->paragraph(1),
        'id_project'=>Project::all()->random()->id,
       ];
});*/
/*

$factory->define(Event::class, function (Faker $faker) {
  // $proyecto=Project::has('projects')->get()->random();
//   $estado=State::all()->except($proyecto->id)->random();
//$dt = Carbon::parse($request->ShootDateTime)->timezone("America/Lima");
/*$now = Carbon::now(); // will use timezone as set with date_default_timezone_set
// PS: we recommend you to work with UTC as default timezone and only use
// other timezones (such as the user timezone) on display

$nowInLondonTz = Carbon::now(new DateTimeZone('Europe/London'));

// or just pass the timezone as a string
$nowInLondonTz = Carbon::now('Europe/London');

$date = Carbon::now('+13:30');
*/

   /*
    return [

            'empresa_id'=>$faker->numberBetween(1,2),
            'sucursal_id'=>$faker->numberBetween(1,2),
            'usuario_id'=>$faker->numberBetween(1,2),
            'supervisor_id'=>$faker->numberBetween(1,2),
            'project_id'=>Project::all()->random()->id,

            'titulo'=> $faker->word,
            'descripcion'=>$faker->paragraph(1),
            'direccion'=>$faker->word,
            'latitud'=>63.3256412,
            'longitud'=>-36.3256412,
            'tipoevento'=>$faker->word,
            'fecharegistro'=>$faker->date,
            'fechainicio'=>$faker->date,
            'fechafin'=>$faker->date,
            'horainicio'=> $faker->time,
            'horafin'=> $faker->time,
            'fecharecordatorio'=>$faker->date,
            'horarecordatorio'=> $faker->time,
            'temporizador'=> $faker->time,
            'recurrente'=> $faker->word,
            'periodo'=>$faker->word,
            'url'=>"https://laravel.com/docs/8.x/migrations#introduction"
            
           // 'id_state'=>State::all()->random()->id,

       ];

});
*/