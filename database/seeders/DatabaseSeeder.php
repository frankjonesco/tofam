<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //User::factory(5)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            
            ColorSwatchSeeder::class,
            ColorSeeder::class,
            FontSeeder::class,
            ConfigSeeder::class,
            CountrySeeder::class,
            UserSeeder::class,
            SponsorSeeder::class,
            CategorySeeder::class,
            ArticleSeeder::class,
            IndustrySeeder::class,
            CompanySeeder::class,
        ]);
    }
}
