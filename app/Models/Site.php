<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Site extends Model
{
    use HasFactory;

    

    public function randomColorId(){
        return DB::table('colors')->orderBy(DB::raw('RAND()'))->first()->id;
    }

    // Find unique hex for 'table'
    public function uniqueHex(string $table, string $field = 'hex', int $length = 11){
        $hex = Str::random($length);
        while(DB::table($table)->where($field, $hex)->exists()){
            $hex = Str::random($length);
        }
        return $hex;
    }

    // Get all categories
    public function getAllCategories(){
        return Category::orderBy('name', 'asc')->get();
    }

    public static function publicCategories(){
        return Category::where('status', 'public')->orderBy('name', 'ASC')->get();
    }

    // Get all public articls
    public static function getArticles(string $status){
        return Article::where('status', 'public');
    }

    // Get all public articles with exploaded tags
    public static function publicArticles(){
        $articles = self::getArticles('public')->latest()->paginate(6);
        foreach($articles as $key => $article){
            $articles[$key] = Article::tagsToArrayFromOne($article);
        }
        return $articles;
    }

    // Handle image upload
    public function handleImageUpload($request, $directory, $hex){

        // dd($request);
        $image_name = null;
        if($request->hasFile('image')){
            // Define a name for the image
            $image_name = Str::random('6').'-'.time().'.'.$request->image->extension();

            // Specify the direcory path
            $directory_path = public_path('images/'.$directory.'/'.$hex);

            // Store in public folder
            $request->file('image')->move($directory_path, $image_name);

            // Get all files in the new folder
            $files_in_folder = File::allFiles($directory_path);

            // Delete an files that are not the new image files
            foreach($files_in_folder as $key => $path){
                if($path != $directory_path.'/'.$image_name){
                    File::delete($path);
                }
            }
        }
        return $image_name;
    }

    
    
}
