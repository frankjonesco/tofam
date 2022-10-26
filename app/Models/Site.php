<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
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
        $image = null;
        if($request->hasFile('image')){
            // Define a name for the image
            $imageName = Str::random('6').'-'.time().'.'.$request->image->extension();
            // Store in public folder
            $request->file('image')->move(public_path('images/'.$directory.'/'.$hex), $imageName);
            // Add image name to article array
            $image = $imageName;
            // dd(public_path('images/'.$directory.'/'.$hex.'/'.$image));
        }
        return $image;
    }

    
    
}
