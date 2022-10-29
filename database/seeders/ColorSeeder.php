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
            ['code' => '01295F'],
            ['code' => '437F97'],
            ['code' => '849324'],
            ['code' => 'FFB30F'],
            ['code' => 'FD151B'],
            ['code' => '712F79'],
            ['code' => '590004'],
            ['code' => '250001'],
            ['code' => 'CE1483'],
            ['code' => '065143'],
            ['code' => 'E58C8A'],
            ['code' => 'FF8C42'],
            ['code' => '6699CC'],
            ['code' => '29BF12'],
            ['code' => '4F772D'],
            ['code' => 'A40E4C'],
            ['code' => '241023'],
            ['code' => '7272AB'],
            ['code' => '826754'],
            ['code' => '7765E3'],
            ['code' => 'A57548'],
            ['code' => '3A86FF'],
            ['code' => 'BDADEA'],  
            ['code' => '7FB685'],
            ['code' => '38369A']
        ];

        Color::insert($colors);
    }
}
