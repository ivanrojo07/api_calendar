<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Project;
use Faker\Factory as Faker;
class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       /* Project::create([
            'Nombre'=>'Proyecto WEB',
            'Descripcion'=>'El proyecto WEB consiste en desarrollar un aplicacion web moderno.'
        ]);
        Project::create([
            'Nombre'=>'Proyecto Android',
            'Descripcion'=>'El proyecto Android consiste en desarrollar una aplicacion Llamativo.'
        ]);*/


$faker=Faker::create();
for ($i=0;$i <3;$i++)
{
    Project::create
    ([
        'Nombre'=>$faker->word(10),
        'Descripcion'=>$faker->word(20)
    ]);

        }

    }

}
