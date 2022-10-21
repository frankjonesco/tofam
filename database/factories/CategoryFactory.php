<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {   
        // Get a fake name
        $name = $this->faker->word();

        // if name is less than 6 characters
        while(strlen($name) < 6){
            // Get a longer one
            $name = $this->faker->word();
        }
        // Capitalise the name
        $name = ucfirst($name);

        // Slug the name
        $slug = Str::slug($name);

        // Get a random hex color
        $color = substr(md5(rand()), 0, 6);


        // Create fake entry
        return [
            'hex' => Str::random(11),
            'user_id' => User::pluck('id')->random(),
            'name' => $name,
            'slug' => $slug,
            'description' => $this->faker->paragraph(3),
            'color' => $color,
            'status' => 'public'
        ];
    }
}
