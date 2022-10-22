<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    // Set route key name
    public function getRouteKeyName()
    {
        return 'hex';
    }

    // Accessor for retreiving and formatting 'created_at'
    public function getCreatedAtAttribute($value){
        return Carbon::parse($this->attributes['created_at'])->format('d/m/Y');
    }

    // Relationship to user
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }


    public function scopePaginateArticlesExplodeTags(){
        $articles = Article::where('status', 'public')
            ->orderBy('created_at', 'DESC')
            ->paginate(9);
        // Explode article tags into an array
        foreach($articles as $key => $article){
            if($article->tags){
                $articles[$key]['tags'] = explode(',', $article->tags);
            }
        }
        return $articles;
    }
}
