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

    // Relationship to categories
    public function categories(){
        return $this->belongsToMany(Category::class, 'category_ids');
    }

    // Relationship to industries
    public function industries(){
        return $this->belongsToMany(Industry::class, 'industry_ids');
    }


    // Accessor for retrieving and formatting 'name'
    public function getHandleAttribute($value){
        return ($this->trading_name == null) ? $this->registered_name : $this->trading_name;
    }

    // Accessor for retrieving and formatting 'name'
    public function getAddressStateAttribute($value){
        $state = $value;

        switch($state){

            case 'BW':
                return 'Baden-Württemberg';
                break;
            
            case 'BY':
                return 'Bavaria';
                break;

            case 'BE':
                return 'Berlin';
                break;

            case 'BB':
                return 'Brandenburg';
                break;

            case 'HB':
                return 'Bremen';
                break;
            
            case 'HH':
                return 'Hamburg';
                break;

            case 'HE':
                return 'Hesse';
                break;

            case 'NI':
                return 'Lower Saxony';
                break;

            case 'MV':
                return 'Mecklenburg-Vorpommern';
                break;
            
            case 'NW':
                return 'North Rhine-Westphalia';
                break;

            case 'RP':
                return 'Rhineland-Palatinate';
                break;

            case 'SL':
                return 'Saarland';
                break;

            case 'SN':
                return 'Saxony';
                break;

            case 'ST':
                return 'Saxony-Anhalt';
                break;

            case 'SH':
                return 'Schleswig-Holstein';
                break;

            case 'TH':
                return 'Thuringia';
                break;

            default:
                return null;
        }

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

    // Accessor for retrieving and formatting 'address'
    public function getFindSlugAttribute($value){
        if($this->force_slug){
            return $this->force_slug;
        }
        return $this->slug;
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


    public function alreadyInCategory($category_id){

        if(Company::where('hex', $this->hex)->whereRaw('FIND_IN_SET("'.$category_id.'", category_ids)')->count() > 0){
            return true;
        }
        return false;
    }
}
