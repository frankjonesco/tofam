<?php

namespace App\Models;

use App\Models\Color;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use Intervention\Image\Facades\Image;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Site extends Model
{
    use HasFactory;

    
    // Get random color ID
    public function randomColorId(){
        return Color::inRandomOrder()->first()->id;
    }


    // Find unique hex for 'table', default length 11 characters
    public function uniqueHex(string $table, string $field = 'hex', int $length = 11){
        // Generate hex
        $hex = Str::random($length);
        // Regenerate hex if it already exists
        while(DB::table($table)->where($field, $hex)->exists()){
            $hex = Str::random($length);
        }
        return $hex;
    }


    // Get active users (not blocked)
    public static function activeUsers(){
        return User::orderBy('id', 'ASC')->where('blocked', '!=', 1)->orWhereNull('blocked')->get();
    }


    // Get public categories
    public static function publicCategories(){
        return Category::where('status', 'public')->orderBy('name', 'ASC')->get();
    }


    // Get all public articles with exploaded tags
    public static function publicArticles(){
        $articles = Article::where('status', 'public')->latest()->paginate(6);
        foreach($articles as $key => $article){
            $articles[$key] = Article::tagsToArrayFromOne($article);
        }
        return $articles;
    }


    // Handle image upload
    public function handleImageUpload($request, $directory, $hex){  
        // If an image has been added to the request
        if($request->hasFile('image')){
            // Define a name for the new image
            $image_name = Str::random('6').'-'.time().'.'.$request->image->extension();
            // Specify the direcory path
            $directory_path = public_path('images/'.$directory.'/'.$hex);
            // Store in public folder
            $request->file('image')->move($directory_path, $image_name);
            // List all the file in the directory
            $files_in_folder = File::allFiles($directory_path);
            // Delete all files that are not the new image
            foreach($files_in_folder as $key => $path){
                if($path != $directory_path.'/'.$image_name){
                    File::delete($path);
                }
            }
            // Create a thumbnail
            self::makeImageThumbnail($directory_path, $image_name);

            return $image_name;
        }
       
    }


    // Make image thumbnail
    public function makeImageThumbnail($directory_path, $image_name){
        // Resize image thumbnail
        Image::make($directory_path.'/'.$image_name)
            ->resize(380, null, function ($constraint){ 
                $constraint->aspectRatio(); 
            })
            ->save($directory_path.'/tn-'.$image_name);
    }
}
