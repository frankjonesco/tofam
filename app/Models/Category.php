<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    // Find unique hex for articles
    public function uniqueHex($site, string $field = 'hex', int $length = 11){
        return $site->uniqueHex('articles');
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

    // Compile category data
    public function compileCategoryData($request, $category){
        $site = new Site();
        $category->hex = ($category->hex) ? $category->hex : self::uniqueHex($site);
        $category->user_id = auth()->id();
        $category->name = ucfirst($request->name);
        $category->slug = Str::slug($request->name);
        $category->description = $request->description;
        $category->color = $site->randomColorId();
        $category->status = $request->status;
        return $category;
    }

    // Create category (insert)
    public function createCategory($request, $category){
        $category = self::compileCategoryData($request, $category);
        $category->save();
    }

    // Save Category (update)
    public function saveCategory($request, $category){
        $category = self::compileCategoryData($request, $category);
        $category->save();
    }
    
}
