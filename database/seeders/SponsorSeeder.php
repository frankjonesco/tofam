<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sponsors = [
            ['hex' => Str::random(11), 'name' => 'PricewaterhouseCoopers', 'slug' => 'pwc', 'logo' => 'pricewaterhousecoopers.png'],
            ['hex' => Str::random(11), 'name' => 'Matchbird', 'slug' => 'matchbird', 'logo' => 'matchbird.png'],
            ['hex' => Str::random(11), 'name' => 'Headgate', 'slug' => 'headgate', 'logo' => 'headgatea.png']
        ];

        DB::table('sponsors')->insert($sponsors);
    }
}
