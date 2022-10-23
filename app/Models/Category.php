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




    public function getAllPublicCategories(){
        $categories = Category::where('status', 'public')->orderBy('name', 'asc')->get();
        foreach($categories as $key => $category){
            $categories[$key]['name'] = 'Banana';
        }
        return $categories;
    }

    public static function changeName($category){
        return tap($category)->update(['name' => 'Pringles']);
    }

    
}
