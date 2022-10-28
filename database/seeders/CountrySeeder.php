<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        // Get countries from the old databsae
        $old_countries = Country::on('mysql_import_old_stuff')->get();

        // Build array to insert into new countries table
        $countries = [];
        foreach($old_countries as $old_country){
            $countries[] = [
                'name' => $old_country->nicename,
                'slug' => Str::slug($old_country->nicename),
                'iso' => $old_country->iso,
                'phone_code' => $old_country->phonecode
            ];
        }

        // Insert countries into new table
        Country::insert($countries);
    }
}
