<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Category::factory(8)->create();

        $input = Category::on('mysql_import_old_stuff')->get();

        $categories = [];

        foreach($input as $row){
            $categories[] = [
                'old_id' => $row->id,
                'hex' => Str::random(11),
                'user_id' => 1,
                'name' => $row->name,
                'slug' => Str::slug($row->name),
                'description' => null,
                'image' => $row->image,
                'color' => $row->color,
                'status' => 'public'
            ];
        }

        Category::insert($categories);
    }
}
