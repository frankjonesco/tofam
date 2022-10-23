<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function getRouteKeyName()
    {
        return 'hex';
    }

    // Relationship to article
    public function article(){
        return $this->belongsTo(Category::class, 'category_id');
    }



    public static function getPublicCategories(){
        return Category::where('status', 'public')->orderBy('name', 'asc')->get();
    }

    public static function changeName($category){
        return tap($category)->update(['name' => 'Pringles']);
    }

    public static function getPublicArticlesExplodeTags($category){
        $articles = Article::where('category_id', $category->id)->latest()->paginate(9);
        $articles = Article::tagsToArrayFromMany($articles);
        return $articles;
    }

    
}
