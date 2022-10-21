<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
            ['color' => '01295F'],
            ['color' => '437F97'],
            ['color' => '849324'],
            ['color' => 'FFB30F'],
            ['color' => 'FD151B'],
            ['color' => '712F79'],
            ['color' => '590004'],
            ['color' => '250001'],
            ['color' => 'CE1483'],
            ['color' => '065143'],
            ['color' => 'E58C8A'],
            ['color' => 'FF8C42'],
            ['color' => '6699CC'],
            ['color' => '29BF12'],
            ['color' => '4F772D'],
            ['color' => 'A40E4C'],
            ['color' => '241023'],
            ['color' => '7272AB'],
            ['color' => '826754'],
            ['color' => '7765E3'],
            ['color' => 'A57548'],
            ['color' => '3A86FF'],
            ['color' => 'BDADEA'],  
            ['color' => '7FB685'],
            ['color' => '38369A']
        ];

        DB::table('colors')->insert($colors);
    }
}
