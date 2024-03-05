<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        
            $factory->define(App\Menu::class, function (Faker\Generator $faker) {
                $name = $faker->name;
                $menus = App\Menu::all();
                return [
                    'name' => $name,
                    'slug' => str_slug($name),
                    'parent' => (count($menus) > 0) ? $faker->randomElement($menus->pluck('id')->toArray()) : 0,
                    'order' => 0
                ];
            });
        
    }
}
