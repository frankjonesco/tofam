<?php

namespace Database\Seeders;

use App\Models\ColorSwatch;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ColorSwatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $color_swatch = [
            'hex' => Str::random(11),
            'user_id' => 1,
            'name' => 'Default',
            'slug' => 'default',
            'description' => ' This is the default color swatch for the application.'
        ];

        ColorSwatch::create($color_swatch);
    }
}
