<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colors = [
            [
                'color_swatch_id' => 1, 
                'fill_id' => 1, 
                'code' => 'CDDDDD', 
                'name' => 'Ligt smoke', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'color_swatch_id' => 1, 
                'fill_id' => 2, 
                'code' => 'FCA17D', 
                'name' => 'Punch bowl', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'color_swatch_id' => 1, 
                'fill_id' => 3, 
                'code' => '6C7D47', 
                'name' => 'Turf', 
                'created_at' => now(), 
                'updated_at' => now()],
            [
                'color_swatch_id' => 1, 
                'fill_id' => 4, 
                'code' => '6F73D2', 
                'name' => 'Dream tinge', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'color_swatch_id' => 1, 
                'fill_id' => 5, 
                'code' => 'DA627D', 
                'name' => 'Blusher', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'color_swatch_id' => 1, 
                'fill_id' => 6, 
                'code' => 'F6AE2D', 
                'name' => 'Mustard jar', 
                'created_at' => now(),
                 'updated_at' => now()
            ],
            [
                'color_swatch_id' => 1, 
                'fill_id' => 7, 
                'code' => 'FFA552', 
                'name' => 'Sandy shore', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'color_swatch_id' => 1, 
                'fill_id' => 8, 
                'code' => '343434', 
                'name' => 'Sidewalk', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'color_swatch_id' => 1, 
                'fill_id' => 9, 
                'code' => '074F57', 
                'name' => 'Duck pond', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'color_swatch_id' => 1, 
                'fill_id' => 10, 
                'code' => '563635', 
                'name' => 'Tree trunk', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'color_swatch_id' => 1,
                'fill_id' => 11, 
                'code' => 'D17A22', 
                'name' => 'Honey pot', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'color_swatch_id' => 1, 
                'fill_id' => 12, 
                'code' => '4C061D', 
                'name' => 'Red wine', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'color_swatch_id' => 1, 
                'fill_id' => 13, 
                'code' => 'EA3788', 
                'name' => 'Barbie girl', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'color_swatch_id' => 1, 
                'fill_id' => 14, 
                'code' => '96E6B3', 
                'name' => 'Mint tea', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'color_swatch_id' => 1, 
                'fill_id' => 15, 
                'code' => 'A24936', 
                'name' => 'Autumn leaves', 
                'created_at' => now(), 
                'updated_at' => now()
            ],

        ];

        Color::insert($colors);
    }
}
