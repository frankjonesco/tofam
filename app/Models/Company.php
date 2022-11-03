<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    // Set route key name
    public function getRouteKeyName(){
        return 'hex';
    }


    // Relationship to user
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }


    // Accessor for retrieving and formatting 'name'
    public function getHandleAttribute($value){
        return ($this->trading_name == null) ? $this->registered_name : $this->trading_name;
    }

    // // Accessor for retrieving and formatting 'generations_label'
    // public function getCategoriesAttribute($value){
    //     $categories = self::getCategories($this->category_ids);
    //     // dd($categories);
    //     return $categories ?? [];
    // }

    // // Accessor for retrieving and formatting 'generations_label'
    // public function getIndustriesAttribute($value){
    //     $industries = self::getIndustries($this->industry_ids);
    //     return $industries ?? [];
    // }

    // Accessor for retrieving and formatting 'address'
    public function getAddressAttribute($value){
        if($this->address_number && $this->address_street && $this->address_city && $this->address_zip){
            return $this->address_street.' '.$this->address_number.', '.$this->address_zip.' '.$this->address_city;
        }
        elseif($this->address_street && $this->address_city && $this->address_zip){
            return $this->address_street.', '.$this->address_zip.' '.$this->address_city;
        }
        return null;
    }

    


    public function getCategories($category_ids){

        if($category_ids){
            $category_ids = explode(',', $category_ids);

            foreach($category_ids as $category_id){
                $categories[] = Category::where('id', $category_id)->first();
            }
            return $categories;
        }
        return [];
    }

    public function getIndustries($industry_ids){
        
        if($industry_ids){
            $industry_ids = explode(',', $industry_ids);

            foreach($industry_ids as $industry_id){
                $industries[] = Industry::where('id', $industry_id)->first();
            }
            return $industries;
        }
        return [];
    }
}
