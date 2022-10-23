<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
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

    // Accessor for retrieving and formatting 'created_at'
    public function getThumbnail($article){
        
        if($article->image){
            $path = public_path('images/articles/'.$article->hex);
            $image = $article->image;
            $imagePath = $path.'/'.$image;

            $thumbnail = 'tn-'.$article->image;
            $thumbnailPath = $path.'/'.$thumbnail;

            switch($image){
                case(File::exists($thumbnailPath)):
                    $image = $thumbnail;
                    break;

                case(File::exists($imagePath)):
                    $image = $image;
                    break;
                    
                default:
                    $image = 'no-image.png';
            }

            return asset('images/articles/'.$article->hex.'/'.$image);
        }
        else{            
            return asset('images/no-image.png');
        }
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
    public function compileArticleData($request, $article){
        $article['user_id'] = auth()->id();
        $article['category_id'] = ($request->category == '') ? null : $request->category;
        $article['slug'] = Str::slug($request->title);
        $article['tags'] = trim(strtolower(str_replace('  ', '', str_replace(', ', ',', str_replace(' ,', ',', $request->tags)))));        
        return $article;
    }

    // Handle image upload
    public function handleImageUpload($request, $article){
        if($request->hasFile('image')){
            // Define a name for the image
            $imageName = Str::random('6').'-'.time().'.'.$request->image->extension();
            // Store in public folder
            $request->image->move(public_path('images/articles/'.$article['hex']), $imageName);
            // Add image name to article array
            $article['image'] = $imageName;
        }
        return $article;
    }

    // Create a new article
    public function createArticle($request, $article, $site){
        $article['hex'] = self::uniqueHex($site);
        $article = self::compileArticleData($request, $article);
        $article = self::handleImageUpload($request, $article);
        Article::create($article);
    }

    // Save changes to an existing article
    public function saveArticle($request, $article, $formFields){
        $formFields['hex'] = $article->hex;
        $formFields['category_id'] = ($request->category == '') ? null : $request->category;
        $formFields['slug'] = Str::slug($request->title);
        $formFields['tags'] = trim(strtolower(str_replace('  ', '', str_replace(', ', ',', str_replace(' ,', ',', $request->tags))))); 
        $article = $formFields;
        $article = self::handleImageUpload($request, $article);
        Article::update($article); 
    }

    // Check user is article owner
    public function userIsOwner($article){
        if($article->user_id != auth()->id()){
            return false;
        }
        return true;
    }

    
    








    

    


}
 