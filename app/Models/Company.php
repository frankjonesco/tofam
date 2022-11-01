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

    // Accessor for retrieving and formatting 'name'
    public function getNameAttribute($value){
        return ($this->trading_name == null) ? $this->registered_name : $this->trading_name;
    }

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

    // Accessor for retrieving and formatting 'generations_label'
    public function getCategoriesAttribute($value){
        $categories = self::getCategories($this->category_ids);
        return $categories;
    }

    // Accessor for retrieving and formatting 'generations_label'
    public function getIndustriesAttribute($value){
        return self::getIndustries($this->industry_ids);
    }

    


    public function getCategories($category_ids){
        $categories = [];
        $category_ids = explode(',', $category_ids);
        foreach($category_ids as $category_id){
            $categories[] = Category::where('id', $category_id)->first();
        }
        return $categories;
    }

    public function getIndustries($industry_ids){
        $industries = [];
        $industry_ids = explode(',', $industry_ids);
        foreach($industry_ids as $industry_id){
            $industries[] = Industry::where('id', $industry_id)->first();
        }
        return $industries;
    }
}
