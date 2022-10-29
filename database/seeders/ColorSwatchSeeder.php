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
        $color_swatches = [
            [
                'hex' => Str::random(11),
                'user_id' => 1,
                'name' => 'Empty Field',
                'slug' => 'empty-field',
                'description' => 'Vibrant and artistic flavours provide enthusiasm and positivity.',
                'image' => 'theme1.jpg',
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'hex' => Str::random(11),
                'user_id' => 2,
                'name' => 'Delhi Colors',
                'slug' => 'delhi-colors',
                'description' => 'BLues & oranges, freedom, youth, confidence & security.',
                'image' => 'theme2.jpg',
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'hex' => Str::random(11),
                'user_id' => 3,
                'name' => 'Waterfall Bridge',
                'slug' => 'waterfall-bridge',
                'description' => 'Earthy tones promoting trust, optimism and loyalty.',
                'image' => 'theme3.jpg',
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'hex' => Str::random(11),
                'user_id' => 4,
                'name' => 'Cherry Blossum',
                'slug' => 'cherry-blossum',
                'description' => 'A soft, calm and creative palette. Clean and professional.',
                'image' => 'theme4.jpg',
                'created_at' => now(), 
                'updated_at' => now()
            ]
        ];

        ColorSwatch::insert($color_swatches);
    }
}
