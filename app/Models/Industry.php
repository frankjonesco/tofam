<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Industry extends Model
{
    use HasFactory;

    // Set route key name
    public function getRouteKeyName(){
        return 'hex';
    }
    
    // MODEL RELATIONSHIPS

    // Relationship to companies
    public function companies(){
        return $this->hasMany(Company::class, 'industry_ids');
    }

    // Relationship to category
    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }


    // RETRIEVAL METHODS

    // Find unique hex for industries
    public function uniqueHex($field = 'hex', int $length = 11){
        $site = new Site();
        return $site->uniqueHex('industries');
    }
    

    // DATA HANDLING CALL METHODS

    // Create industry (insert)
    public function createIndustry($request){
        $industry = self::compileCreationData($request);
        $industry->save();
        return $industry;
    }

    // Save industry text (update)
    public function saveIndustry($request){
        $industry = self::compileSaveData($request);
        $industry->save();
        return $industry;
    }
    

    // DATA HANDLERS

    // Compile industry data
    public function compileCreationData($request){
        $site = new Site();
        $industry = new Industry();
        $industry->hex = self::uniqueHex();
        $industry->user_id = auth()->user()->id;
        $industry->name = ucfirst($request->name);
        $industry->slug = Str::slug($request->name);
        $industry->description = $request->description;
        $industry->color_id = $site->randomColor();
        $industry->status = $request->status;
        return $industry;
    }

     // Compile category text data
     public function compileSaveData($request){        
        $category = self::get($request->hex);
        $category->name = ucfirst($request->name);
        $category->slug = Str::slug($request->name);
        $category->description = $request->description;
        return $category;
    }

}
