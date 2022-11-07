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
    public function randomColor($color_swatch_id = null, $field = 'fill_id'){
        return Color::where('color_swatch_id', $color_swatch_id)->inRandomOrder()->first()->$field;
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


    // Get all articles with exploaded tags
    public static function allArticles(){
        $articles = Article::latest()->get();
        foreach($articles as $key => $article){
            $articles[$key]['tags'] = Article::tagsToArrayFromOne($article->tags);
        }
        return $articles;
    }

    // Get all public articles with exploaded tags
    public static function publicArticles(){
        $articles = Article::where('status', 'public')->latest()->paginate(6);
        foreach($articles as $key => $article){
            $articles[$key]['tags'] = Article::tagsToArrayFromOne($article->tags);
        }
        return $articles;
    }

    // Get other public articles with exploaded tags
    public static function otherPublicArticles($hex){
        $other_articles = Article::where('status', 'public')->where('hex', '!=' , $hex)->orderBy(DB::raw('RAND()'))->take(3)->get();
        foreach($other_articles as $key => $other_article){
            $other_articles[$key]['tags'] = Article::tagsToArrayFromOne($other_article->tags);
        }
        return $other_articles;
    }

    // Get public articles that have a specific tag
    public function publicArticlesWithTag($tag){
        $articles = Article::where([['tags', 'like', '%'.$tag.'%'], ['status', 'public']])->paginate(6);
        foreach($articles as $key => $article){
            $articles[$key]['tags'] = Article::tagsToArrayFromOne($article->tags);
        }
        return $articles;
    }

    // Get public articles that are similar to our search term
    public function similarPublicArticles($term){
        $articles = Article::where('title', 'like', '%'.$term.'%')
            ->orWhere('body', 'like', '%'.$term.'%')
            ->orWhere('tags', 'like', '%'.$term.'%')->where('status', 'public')->paginate(6);
        foreach($articles as $key => $article){
            $articles[$key]['tags'] = Article::tagsToArrayFromOne($article->tags);
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


    // Get user types
    public function getUserTypes(){
        return DB::table('user_types')->where('active', 1)->orderBy('id', 'ASC')->get();
    }

    // Get countries
    public function getCountries(){
        return Country::orderBy('name', 'ASC')->get();
    }


    public static function validateUrl($url){
        return false;
    }
}



