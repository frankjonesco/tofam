<?php

namespace Database\Seeders;

use App\Models\Site;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
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

        File::deleteDirectory(public_path('images/categories'));

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
                'created_at' => date('Y-m-d H:i:s', $row->created),
                'status' => 'public'
            ];
        }

        Category::insert($categories);


        // Get newly created categories
        $categories = Category::all();

        foreach($categories as $category){        
            // Source and destination paths
            $source_path = public_path('import_images/categories/');
            $destination_path = public_path('images/categories/'.$category->hex);

            // Copy the source directory if it exists
            if(File::isDirectory($source_path)){
                File::copyDirectory($source_path, $destination_path);
                // Rename the image file if it exists in the database
                if($category->image){
                    // Create a new name for the image
                    $new_filename = Str::random(11).'.jpg';
                    // Rename image
                    File::move(
                        $destination_path.'/'.$category->image,
                        $destination_path.'/'.$new_filename
                    );
                    // Get all files in the new folder
                    $filesInFolder = File::allFiles($destination_path);
                    // Delete an files that are not the new image files
                    foreach($filesInFolder as $key => $path){
                        if($path != $destination_path.'/'.$new_filename){
                            File::delete($path);
                        }
                    }
                }
                // Assign new filename to article object and save
                $category->image = $new_filename;
                $category->save();

                $site = new Site();
                $site->makeImageThumbnail($destination_path, $new_filename);
            }
        }
    }
}
