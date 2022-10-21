<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Array of users
        $users = [
            [
                'hex' => Str::random(11),
                'user_type_id' => '1',
                'first_name' => 'Frank',
                'last_name' => 'Jones',
                'email' => 'frank@gmail.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
                'remember_token' => Str::random(10),
                'image' => 'frankjones.jpg',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ], 
            [
                'hex' => Str::random(11),
                'user_type_id' => '1',
                'first_name' => 'Michael',
                'last_name' => 'Kranz',
                'email' => 'michael@gmail.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
                'remember_token' => Str::random(10),
                'image' => 'michaelkranz.jpg',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'hex' => Str::random(11),
                'user_type_id' => '1',
                'first_name' => 'Karsten',
                'last_name' => 'Sander',
                'email' => 'karsten@gmail.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
                'remember_token' => Str::random(10),
                'image' => 'karstensander.jpg',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'hex' => Str::random(11),
                'user_type_id' => '1',
                'first_name' => 'Volker',
                'last_name' => 'Motz',
                'email' => 'volker@gmail.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
                'remember_token' => Str::random(10),
                'image' => 'volkermotz.jpg',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'hex' => Str::random(11),
                'user_type_id' => '1',
                'first_name' => 'Daniel',
                'last_name' => 'Kollenberg',
                'email' => 'daniel@gmail.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
                'remember_token' => Str::random(10),
                'image' => 'danielkollenberg.jpg',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];
        // Create users
        User::insert($users);
    }
}
