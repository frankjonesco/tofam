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

    // Get other public articles with exploaded tags
    public static function otherPublicArticles($hex){
        $articles = self::getArticles('public')->where('hex', '!=' , $hex)->orderBy(DB::raw('RAND()'))->take(3)->get();
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
        $article->image = $site->handleImageUpload($request, 'articles', $article->hex);
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
        $article = self::handleImageUpload($request, $article);
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

    
    








    

    


}
 