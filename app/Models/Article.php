<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    // Set route key name
    public function getRouteKeyName(){
        return 'hex';
    }

    // Accessor for retrieving and formatting 'created_at'
    public function getCreatedAtAttribute($value){
        return Carbon::parse($this->attributes['created_at'])->format('d/m/Y');
    }

    // Relationship to user
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    // Get all public articls
    public static function getPublicArticles(){
        return Article::where('status', 'public');
    }

    // Explode tags to arrays for all articles
    public static function tagsToArrayFromMany($articles = []){
        foreach($articles as $key => $article){
            if($article->tags){
                $articles[$key]['tags'] = explode(',', $article->tags);
            }
        } 
        return $articles;
    }

    // Explode tags to arrays for one article
    public static function tagsToArrayFromOne($article){
        if($article->tags){
            $article['tags'] = explode(',', $article->tags);
        }
        return $article;
    }

    // Add view
    public static function addView(object $article){
        $article->views = ($article->views + 1);
        $article->save();
    }

    // Get other articles
    public static function getOtherPublicArticles(string $hex){
        return self::getPublicArticles()->where('hex', '!=' , $hex)->orderByRaw('RAND()');
    }

    // Find unique hex for articles
    public function uniqueHex($site, string $field = 'hex', int $length = 11){
        return $site->uniqueHex('articles');
    }

    // Compile article data
    public function compileArticleData($request, $formFields, $site){
        $formFields['user_id'] = auth()->id();
        $formFields['category_id'] = ($request->category == '') ? null : $request->category;
        $formFields['slug'] = Str::slug($request->title);
        $formFields['tags'] = strtolower(str_replace('  ', '', str_replace(', ', ',', str_replace(' ,', ',', $request->tags))));        
        return $formFields;
    }

    // Handle image upload
    public function handleImageUpload($request, $formFields){
        if($request->hasFile('image')){
            $imageName = Str::random('6').'-'.time().'.'.$request->image->extension();

            // Store in public folder
            $request->image->move(public_path('images/articles/'.$formFields['hex']), $imageName);

            // Add image name to form fields
            $formFields['image'] = $imageName;

            return $formFields;
        }
    }
    








    

    


}
 