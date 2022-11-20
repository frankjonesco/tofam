<?php

namespace Database\Seeders;

use App\Models\Site;
use App\Models\User;
use App\Models\Company;
use App\Models\Category;
use App\Models\Industry;
use Illuminate\Support\Str;
use App\Models\TempIndustry;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class IndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        // All companies
        $companies = Company::get();

        // For each company
        foreach($companies as $company){
            $new_industry_ids = [];


            // If company has industry_ids
            if($company->industry_ids){



                // Explode them
                $industry_ids = explode(',', $company->industry_ids);
                // For each industry_id
                foreach($industry_ids as $industry_id){
                    // Get temp industry
                    $industry = TempIndustry::where('id', $industry_id)->first();
                    
                    // If temp industry exists
                    if(empty($industry) === false){
                        // And if company has category_ids
                        if($company->category_ids){
                            // Explode them
                            $category_ids = explode(',', $company->category_ids);

                            // For each category_id
                            foreach($category_ids as $category_id){
                                // Get category
                                $category = Category::where('id', $category_id)->first();
                    
                                // If category doesn't exist
                                if(empty($category)){
                                    // New industry array
                                    $new_industry = [
                                        'old_id' => $industry->id,
                                        'hex' => $industry->hex,
                                        'category_id' => null,
                                        'name' => trim($industry->name),
                                        'slug' => $industry->slug,
                                        'english_name' => trim($industry->english_name),
                                        'english_slug' => $industry->english_slug,
                                        'description' => $industry->description,
                                        'color_id' => $industry->color_id,
                                        'created_at' => $industry->created_at,
                                        'updated_at' => now(),
                                        'status' => $industry->status,
                                    ];

                                    $doIndustry = Industry::where(['name' => $industry->name, 'category_id' => null]);
                                    if($doIndustry->doesntExist()){
                                        $industry_id = Industry::insertGetId($new_industry);
                                        $new_industry_ids[] =  $industry_id;
                                    }else{
                                        $new_industry_ids[] =  $doIndustry->first()->id;
                                    }
                                    
                                }else{
                                    // New industry array
                                    $new_industry = [
                                        'old_id' => $industry->id,
                                        'hex' => $industry->hex,
                                        'category_id' => $category->id,
                                        'name' => trim($industry->name),
                                        'slug' => $industry->slug,
                                        'english_name' => trim($industry->english_name),
                                        'english_slug' => $industry->english_slug,
                                        'description' => $industry->description,
                                        'color_id' => $industry->color_id,
                                        'created_at' => $industry->created_at,
                                        'updated_at' => now(),
                                        'status' => $industry->status,
                                    ];

                                    $doIndustry = Industry::where(['name' => $industry->name, 'category_id' => $category->id]);
                                    if($doIndustry->doesntExist()){
                                        $industry_id = Industry::insertGetId($new_industry);
                                        $new_industry_ids[] =  $industry_id;
                                    }else{
                                        $new_industry_ids[] =  $doIndustry->first()->id;
                                    }
                                }
                            }
                        }else{
                            // New industry array
                            $new_industry = [
                                'old_id' => $industry->id,
                                'hex' => $industry->hex,
                                'category_id' => null,
                                'name' => trim($industry->name),
                                'slug' => $industry->slug,
                                'english_name' => trim($industry->english_name),
                                'english_slug' => $industry->english_slug,
                                'description' => $industry->description,
                                'color_id' => $industry->color_id,
                                'created_at' => $industry->created_at,
                                'updated_at' => now(),
                                'status' => $industry->status,
                            ];

                            $doIndustry = Industry::where(['name' => $industry->name, 'category_id' => null]);
                            if($doIndustry->doesntExist()){
                                $industry_id = Industry::insertGetId($new_industry);
                                $new_industry_ids[] =  $industry_id;
                            }else{
                                $new_industry_ids[] =  $doIndustry->first()->id;
                            }
                        }
                    }
                }

                
            }
        
            $new_industry_ids = implode(',', $new_industry_ids);

            $company->industry_ids = $new_industry_ids;
            $company->save();

        }
        


        
    }
}
