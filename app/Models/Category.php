<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    // Set route key name
    public function getRouteKeyName()
    {
        return 'hex';
    }

    // MODEL RELATIONSHIPS

    // Relationship to articles
    public function articles(){
        return $this->hasMany(Article::class, 'category_id');
    }

    // Relationship to companies
    public function companies(){
        return $this->hasMany(Company::class, 'category_ids');
    }

    // Relationship to industries
    public function industries(){
        return $this->hasMany(Industry::class, 'category_id')->orderBy('name', 'ASC');
    }


    // ACCESSORS

    // Accessor for retrieving and formatting 'company_count'
    public function getCompanyCountAttribute(){
        return count(Company::where('category_ids', $this->id)->get());
    }


    // RETRIEVAL METHODS

    // Find unique hex for categories
    public function uniqueHex($site, string $field = 'hex', int $length = 11){
        return $site->uniqueHex('articles');
    }

    // Get single category by hex
    public function get($hex){
        if($hex){
            return Category::where('hex', $hex)->first();
        }
        return false;
    }

    // Get public articles in this category
    public function publicArticles(){
        $articles = Article::where('category_id', $this->id)->orderBy('created_at', 'DESC')->get();
        return $articles;
    }

    // Get companies
    public function getCompanies($category){
        $companies = Company::whereRaw("FIND_IN_SET('".$category->id."', category_ids)")->get();
        return $companies;
    }


    // DATA HANDLING CALL METHODS

    // Create article (insert)
    public function createCategory($request){
        $category = self::compileCreationData($request);
        $category->save();
        return $category;
    }

    // Save category text (update)
    public function saveText($request){
        $category = self::compileTextData($request);
        $category->save();
        return $category;
    }

    // Save category text (update)
    public function saveImage($request){
        $category = self::compileImageData($request);
        $category->save();
        return $category;
    }

    // Save category text (update)
    public function savePublishing($request){
        $category = self::compilePublishingData($request);
        $category->save();
        return $category;
    }


    // DATA HANDLERS

    // Compile category data
    public function compileCreationData($request){
        $site = new Site();
        $category = new Category();
        $category->hex = self::uniqueHex($site);
        $category->user_id = auth()->user()->id;
        $category->name = ucfirst($request->name);
        $category->slug = Str::slug($site->prepSlug($request->name));
        $category->description = $request->description;
        $category->color_id = $site->randomColor();
        $category->status = 'public';
        return $category;
    }

     // Compile category text data
     public function compileTextData($request){     
        $site = new Site();   
        $category = $site->getCategory($request->hex);
        $category->name = ucfirst($request->name);
        $category->slug = Str::slug($request->name);
        $category->description = $request->description;
        return $category;
    }

    // Compile category image data
    public function compileImageData($request){
        $site = new Site();
        $category = $site->getCategory($request->hex); 
        if($request->hasFile('image')){
            $category->image = $site->handleImageUpload($request, 'categories', $category->hex);
        }
        return $category;
    }

    // Compile category publishing data
    public function compilePublishingData($request, $category = null){
        $site = new Site();
        $category = $site->getCategory($request->hex); 
        $category->status = $request->status;   
        return $category;
    }

}
