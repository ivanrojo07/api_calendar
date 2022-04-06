<?php
use App\user;
//use App\Category;
use App\Project;
use App\State;
use App\Event;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   
        /*$this->call(ProjectSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(StateSeeder::class);
        $this->call(EventSeeder::class);*/
        User::truncate();
        $this->call(UserSeeder::class);
         // $this->call(UsersTableSeeder::class);

      DB::statement('SET FOREIGN_KEY_CHECKS = 0');

     
      Project::truncate();
      //State::truncate();
     // Event::truncate();
      //DB::table('category_product')->truncate();

     //$cantidadUsuarios=50;
      $cantidadproyectos=10;
      //$cantidadcategorias=50;
     // $cantidadestados=6;
     // $cantidadeventos=30;

     
      factory(Project::class, $cantidadproyectos)->create();
      //factory(Category::class, $cantidadcategorias)->create();
     // factory(State::class, $cantidadestados)->create();

    /*  factory(State::class, $cantidadProductos)
      ->create()
      ->each(function($producto){
	  $categorias=Category::all()->random(mt_rand(1,5))->pluck('id');

	  $producto->categories()->attach($categorias);
});*/

      //  factory(Event::class, $cantidadeventos)->create();

        $this->call(TimezoneSeeder::class);


    }
}
