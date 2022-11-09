<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    // Set route key name
    public function getRouteKeyName(){
        return 'hex';
    }

    // MODEL RELATIONSHIPS

    // Relationship to comments
    public function comments(){
        return $this->hasMany(Comment::class, 'resource_id');
    }

    // Relationship to contacts
    public function contacts(){
        return $this->hasMany(Contact::class, 'company_id');
    }

    // Relationship to rankings
    public function rankings(){
        return $this->hasMany(Ranking::class, 'company_id');
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



    // RETRIEVAL METHODS

    // Find unique hex for categories
    public function uniqueHex(){
        $site = new Site();
        return $site->uniqueHex('companies');
    }

    // Get comments
    public function getComments(){
        $comments = Comment::where(['resource_type' => 'company', 'resource_id' => $this->id, 'parent_id' => null])->get();
        foreach($comments as $key => $comment){
            $nested_comments = Comment::where(['resource_type' => 'company', 'resource_id' => $comment->resource_id, 'parent_id' => $comment->id])->get();
            $comments[$key]['nested_comments'] = $nested_comments;
        }
        return $comments;
    }

    // Get single contact for this company
    public function getContact($contact_hex){
        return Contact::where(['company_id' => $this->id, 'hex' => $contact_hex])->first();
    }







    // DATA HANDLING CALL METHODS

    // Create company (insert)
    public function createCompany($request){
        $company = self::compileCreationData($request);
        $company->save();
        return $company;
    }

    // Save general (update)
    public function saveGeneral($request){
        $company = self::compileGeneralData($request);
        $company->save();
        return $company;
    }

    // Save category IDs (update)
    public function saveCategoryIds($request){
        $site = new Site();
        $this->category_ids = $site->formatCsvTextInput($request->categories_array);
        $this->save();
        return $this;
    }

    // Save industry IDs (update)
    public function saveIndustryIds($request){
        $site = new Site();
        $this->industry_ids = $site->formatCsvTextInput($request->industries_array);
        $this->save();
        return $this;
    }

    // Save image (update)
    public function saveImage($request){
        $site = new Site();
        $this->image = $site->handleImageUpload($request, 'companies', $request->hex);
        $this->save();
        return $this;
    }

    // Save address (update)
    public function saveAddress($request){
        $this->address_building_name = $request->address_building_name;
        $this->address_number = $request->address_number;
        $this->address_street = $request->address_street;
        $this->address_city = $request->address_city;
        $this->address_state = $request->address_state;
        $this->address_zip = $request->address_zip;
        $this->address_phone = $request->address_phone;
        $this->save();
        return $this;
    }

    // Save family details (update)
    public function saveFamilyDetails($request){
        $this->family_business = $request->family_business;
        $this->family_name = $request->family_name;
        $this->family_generations = $request->family_generations;
        $this->family_executive = $request->family_executive;
        $this->save();
        return $this;
    }

    // Save further details (update)
    public function saveFurtherDetails($request){
        $this->female_executive = $request->female_executive;
        $this->stock_listed = $request->stock_listed;
        $this->matchbird_partner = $request->matchbird_partner;
        $this->save();
        return $this;
    }

    // Create comment (insert)
    public function createComment($request){
        $company_id = $this->id;
        $comment = Comment::create([
            'user_id' => auth()->user()->id,
            'parent_id' => null,
            'resource_type' => 'company',
            'resource_id' => $company_id,
            'title' => $request->title,
            'body' => $request->body
        ]);
        return $comment;
    }

    // Delete comment (delete)
    public function destroyComment($request){
        $comment = Comment::find($request->comment_id);
        $comment->delete();    
    }

    // Save publishing information (update)
    public function savePublishingInformation($request){
        $this->force_slug = Str::slug($request->force_slug);
        $this->tofam_status = $request->tofam_status;
        $this->status = $request->status;
        $this->save();
        return $this;
    }
    




    // DATA HANDLERS

    // Compile company data
    public function compileCreationData($request){
        $slug = $request->trading_name == false ?? $request->registered_name;
        $company = Company::create([
            'hex' => self::uniqueHex(),
            'user_id' => auth()->user()->id,
            'registered_name' => $request->registered_name,
            'trading_name' => $request->trading_name,
            'slug' => Str::slug($slug),
            'parent_organization' => $request->parent_organization,
            'description' => $request->description,
            'website' => $request->website,
            'founded_in' => $request->founded_in,
            'founded_by' => $request->founded_by,
            'headquarters' => $request->headquarters,
        ]);
        return $company;
    }


    public function compileGeneralData($request){
        $company = $this;
        $company->registered_name = $request->registered_name;
        $company->trading_name = $request->trading_name;
        $company->parent_organization = $request->parent_organization;
        $company->website = $request->website;
        $company->description = $request->description;
        $company->founded_in = $request->founded_in;
        $company->founded_by = $request->founded_by;
        $company->headquarters = $request->headquarters;
        return $company;
    }


}
