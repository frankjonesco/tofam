<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    // Set route key name
    public function getRouteKeyName(){
        return 'hex';
    }


    // MODEL RELATIONSHIPS

    // Relationship to category
    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Relationship to user
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }


    // ACCESSORS

    // Accessor for retrieving and formatting 'created_at'
    public function getCreatedAtAttribute($value){
        return Carbon::parse($this->attributes['created_at'])->format('d/m/Y');
    }

    // Accessor for retrieving and formatting 'created_at'
    public function getShortTitleAttribute($value){
        return Str::limit($this->title, 65);
    }

    // Accessor for retrieving and formatting 'short_body'
    public function getShortBodyAttribute($value){
        return Str::limit($this->body, 200);
    }


    // RETRIEVAL METHODS  

    // Get all public articls
    public static function getArticles(string $status){
        return Article::where('status', 'public');
    }

    // Get all public articles with exploaded tags
    public static function getPublicArticles(){
        $articles = self::getArticles('public')->latest()->paginate(6);
        foreach($articles as $key => $article){
            $articles[$key] = self::tagsToArrayFromOne($article);
        }
        return $articles;
    }

    public function getArticle($hex){
        if($hex){
            return Article::where('hex', $hex)->first();
        }
        return false;
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
                    $image = 'images/articles/'.$article->hex.'/'.$thumbnail;
                    break;

                case(File::exists($imagePath)):
                    $image = 'images/articles/'.$article->hex.'/'.$image;
                    break;
                    
                default:
                    $image = 'images/no-image.png';
            }

            return asset($image);
        }
        else{            
            return asset('images/no-image.png');
        }
    }


    // Get random tags
    public static function getRandomTags(int $amount = 3){
        // List of random keywords
        $tags = [
            'destroy', 'fade', 'subtract', 'puzzled', 'metal', 'disillusioned', 'fear', 'foolish', 'lamentable', 'scratch', 'nauseating', 'meek', 'nest',  'bitter', 'faded', 'dapper', 'month', 'realize', 'crash', 'inquisitive', 'follow', 'attend', 'identify', 'cover', 'girl', 'unhealthy', 'inform', 'notebook', 'fetch', 'beds', 'mix', 'air', 'hydrant', 'carpenter', 'bat', 'gather', 'hug', 'sulky', 'stew', 'shop', 'writing', 'disagreeable', 'suit', 'blushing', 'troubled', 'crazy', 'tame', 'unfasten', 'boy', 'miss', 'cemetery', 'word', 'malicious', 'lean', 'bored', 'aggressive', 'actor', 'sturdy', 'trite', 'introduce', 'dam', 'fuel', 'rot', 'hat', 'tart', 'fanatical', 'garrulous', 'country', 'hop', 'trouble', 'economic', 'underwear', 'quicksand', 'design', 'title', 'pleasant', 'adventurous', 'axiomatic', 'popcorn', 'cooperative', 'smooth', 'supreme', 'miscreant', 'act', 'tangible', 'three', 'flimsy', 'recondite', 'trick', 'stop', 'oval', 'unkempt', 'delay', 'peace', 'yielding', 'gun', 'receptive'
        ];
        
        // Get an amount of random keys
        $keys = array_rand($tags, $amount);

        // Assign values to $random_tags
        $random_tags = [];
        foreach($keys as $key){
            $random_tags[] = $tags[$key];
        }

        // Return array as comma separated value
        return implode(',', $random_tags);
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
    public static function tagsToArrayFromOne($tags){
        if($tags){
            $tags = explode(',', $tags);
        }
        return $tags;
    }

    // Add view
    public static function addView(object $article){
        $article->views = ($article->views + 1);
        $article->save();
    }

    // Find unique hex for articles
    public function uniqueHex($site, string $field = 'hex', int $length = 11){
        return $site->uniqueHex('articles');
    }

    // Format tags
    public function formatTags($tags){
        $tags = explode(',', $tags);
        $new_tags = [];
        foreach($tags as $tag){
            $tag = trim($tag);
            if($tag){
                $tag = str_replace('  ', ' ', $tag);
                $tag = str_replace('  ', ' ', $tag);
                $tag = str_replace('  ', ' ', $tag);
                $new_tags[] = $tag;
            }
        }
        return implode(',', $new_tags);
    }


    // DATA HANDLING CALL METHODS

    // Create article (insert)
    public function createArticle($request){
        $article = self::compileArticleCreationData($request);
        $article->save();
    }

    // Save article text (update)
    public function saveArticleText($request){
        $article = self::compileArticleTextData($request);
        $article->save();
    }

    // Save article storage (update)
    public function saveArticleStorage($request){
        $article = self::compileArticleStorageData($request);
        $article->save();
        return false;
    }

    // Save article image (update)
    public function saveArticleImage($request){
        $article = self::compileArticleImageData($request);
        $article->save();
    }

    // Save article publishing (update)
    public function saveArticlePublishing($request){
        $article = self::compileArticlePublishingData($request);
        $article->save();
    }

    // Check user is article owner
    public function userIsOwner($article){
        if($article->user_id == auth()->user()->id){
            return true;
        }
        return false;
    }

    public function checkOwnerDeleteOrDie($article){
        if(self::userIsOwner($article)){
            $article->delete();
            return true;
        }
        return false;
        
    }


    // DATA HANDLERS

    // Compile article data
    public function compileArticleCreationData($request, $article = null){
        $site = new Site();
        $article = new Article();
        $article->hex = self::uniqueHex($site);    
        $article->user_id = auth()->id();
        $article->title = $request->title;
        $article->slug = Str::slug($request->title);
        $article->caption = $request->caption;
        $article->teaser = $request->teaser;
        $article->body = $request->body;
        $article->tags = self::formatTags($request->tags);   
        $article->status = 'private';   
        return $article;
    }

    // Compile category text data
    public function compileArticleTextData($request){        
        $article = self::getArticle($request->hex);
        $article->title = $request->title;
        $article->slug = Str::slug($request->title);
        $article->caption = $request->caption;
        $article->teaser = $request->teaser;
        $article->body = $request->body;
        $article->tags = self::formatTags($request->tags); 
        return $article;
    }

    // Compile article storage data
    public function compileArticleStorageData($request){
        $article = self::getArticle($request->hex);
        $article->category_id = ($request->category_id) ? $request->category_id : null;
        return $article;
    }

    // Compile article image data
    public function compileArticleImageData($request){
        $site = new Site();
        $article = self::getArticle($request->hex); 
        if($request->hasFile('image')){
            $article->image = $site->handleImageUpload($request, 'articles', $article->hex);
        }
        return $article;
    }

    // Compile article publishing data
    public function compileArticlePublishingData($request, $article = null){
        $article = self::getArticle($request->hex); 
        $article->status = $request->status;   
        return $article;
    }


    

    

    
    








    

    


}
 