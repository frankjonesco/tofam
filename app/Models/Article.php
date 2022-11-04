<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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

    // Relationship to category
    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

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

    // Relationship to user
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

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

    // Compile category data
    public function compileArticleData($request, $article = null){
        $site = new Site();
        $article = empty($article) ? new Article() : $article;
        $article->hex = ($article->hex) ? $article->hex : self::uniqueHex($site);    
        $article->user_id = auth()->id();
        $article->category_id = ($request->category) ? $request->category : null;
        $article->title = $request->title;
        $article->slug = Str::slug($request->title);
        $article->caption = $request->caption;
        $article->teaser = $request->teaser;
        $article->body = $request->body;
        $article->tags = trim(strtolower(str_replace('  ', '', str_replace(', ', ',', str_replace(' ,', ',', $request->tags)))));   
        $article->status = $request->status;   

        $article->image = $article->image;
        if($request->hasFile('image')){
            $article->image = $site->handleImageUpload($request, 'articles', $article->hex);
        }

        return $article;
    }


    // Create article (insert)
    public function createArticle($request){
        $article = self::compileArticleData($request);
        $article->save();
    }

    // Save article (update)
    public function saveArticle($request, $article){
        $article = self::compileArticleData($request, $article);
        $article->save();
    }

    // Check user is article owner
    public function userIsOwner($article){
        if($article->user_id == auth()->id()){
            return true;
        }
        return false;
    }

    public function checkOwnerDeleteOrDie($article){
        // dd(self::userIsOwner($article));
        if(self::userIsOwner($article)){
            $article->delete();
            return true;
        }
        return false;
        
    }

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

    
    








    

    


}
 