<?php

namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Menu;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $m1 = factory(App\Menu::class)->create([
            'name' => 'DASHBOARD',
            'slug' => 'DASHBOARD',
            'parent' => 0,
            'order' => 0,
        ]);
        factory(App\Menu::class)->create([
            'name' => 'PARAMETROS GENERALES',
            'slug' => 'PARAMETROS GENERALES',
            'parent' => 0,
            'order' => 1,
        ]);
        $m3 = factory(App\Menu::class)->create([
            'name' => 'DESCRIPCION DE CARGOS',
            'slug' => 'DESCRIPCION DE CARGOS',
            'parent' => 0,
            'order' => 2,
        ]);
        $m4 = factory(App\Menu::class)->create([
            'name' => 'Opción 4',
            'slug' => 'opcion4',
            'parent' => 0,
            'order' => 3,
        ]);
        factory(App\Menu::class)->create([
            'name' => 'HEADCOUNT',
            'slug' => 'HEADCOUNT',
            'parent' => $m1->id,
            'order' => 0,
        ]);
        factory(App\Menu::class)->create([
            'name' => 'Opción 1.2',
            'slug' => 'opcion-1.2',
            'parent' => $m1->id,
            'order' => 1,
        ]);
        factory(App\Menu::class)->create([
            'name' => 'Formulario',
            'slug' => 'Formulario',
            'parent' => $m3->id,
            'order' => 0,
        ]);
        $m32 = factory(App\Menu::class)->create([
            'name' => 'Parametros',
            'slug' => 'Parametros',
            'parent' => $m3->id,
            'order' => 1,
        ]);
        factory(App\Menu::class)->create([
            'name' => 'Valoración de Perfiles',
            'slug' => 'Valoración de Perfiles',
            'parent' => $m3->id,
            'order' => 0,
        ]);
        factory(App\Menu::class)->create([
            'name' => 'Biblioteca de Cargos',
            'slug' => 'Control de Formulario',
            'parent' => $m3->id,
            'order' => 0,
        ]);
        //3.2.1
        factory(App\Menu::class)->create([
            'name' => 'Especificaciones',
            'slug' => 'Especificaciones',
            'parent' => $m32->id,
            'order' => 0,
        ]);
        factory(App\Menu::class)->create([
            'name' => 'Competencias',
            'slug' => 'Competencias',
            'parent' => $m32->id,
            'order' => 1,
        ]);
        factory(App\Menu::class)->create([
            'name' => 'Opción 3.2.3',
            'slug' => 'opcion-3.2.3',
            'parent' => $m32->id,
            'order' => 2,
        ]);
        
        factory(App\Menu::class)->create([
            'name' => 'Especificaciones',
            'slug' => 'Especificaciones',
            'parent' => $m32->id,
            'order' => 0,
        ]);
        factory(App\Menu::class)->create([
            'name' => 'Competencias',
            'slug' => 'opcion-3.2.2',
            'parent' => $m32->id,
            'order' => 1,
        ]);
        factory(App\Menu::class)->create([
            'name' => 'Opción 3.2.3',
            'slug' => 'opcion-3.2.3',
            'parent' => $m32->id,
            'order' => 2,
        ]);
        
        factory(App\Menu::class)->create([
            'name' => 'Especificaciones',
            'slug' => 'Especificaciones',
            'parent' => $m32->id,
            'order' => 0,
        ]);
        factory(App\Menu::class)->create([
            'name' => 'Competencias',
            'slug' => 'opcion-3.2.2',
            'parent' => $m32->id,
            'order' => 1,
        ]);
        factory(App\Menu::class)->create([
            'name' => 'Opción 3.2.3',
            'slug' => 'opcion-3.2.3',
            'parent' => $m32->id,
            'order' => 2,
        ]);
        
        factory(App\Menu::class)->create([
            'name' => 'Especificaciones',
            'slug' => 'Especificaciones',
            'parent' => $m32->id,
            'order' => 0,
        ]);
        factory(App\Menu::class)->create([
            'name' => 'Competencias',
            'slug' => 'Competencias',
            'parent' => $m32->id,
            'order' => 1,
        ]);
        factory(App\Menu::class)->create([
            'name' => 'Nivel Jerarquia',
            'slug' => 'Nivel Jerarquia',
            'parent' => $m32->id,
            'order' => 2,
        ]);
    }
    
}
