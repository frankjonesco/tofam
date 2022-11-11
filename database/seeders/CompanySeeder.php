<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use App\Models\Category;
use App\Models\Industry;
use Illuminate\Support\Str;
use App\Models\TempIndustry;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        // $old_companies = Company::on('mysql_import_old_stuff')->where('id', 4997)->get();

        // foreach($old_companies as $old_company){
        //     if($old_company->industries){
        //         $industry_ids = [];
        //         $old_industry_ids = explode(',', $old_company->industries);
        //         foreach($old_industry_ids as $old_industry_id){
        //             $old_industry = App\Models\Industry::where('old_id', $old_industry_id)->first();
        //             if($old_industry){
        //                 $industry_ids[] = $old_industry->id;
        //             }
        //         }
        //         if(count($industry_ids) > 0){
        //             $industry_ids = implode(',', $industry_ids);
        //         }
        //         else{
        //             $industry_ids = null;
        //         }  
        //     }
        //     else{
        //         $industry_ids = null;
        //     }
        // }
        




        // Delete the images/companies directoy
        File::deleteDirectory(public_path('images/companies'));

        // Get the old articles
        $old_companies = Company::on('mysql_import_old_stuff')->get();

        // Create array for new articles
        $new_companies = [];

        foreach($old_companies as $old_company){

            // Ids for Mik and Karsten
            $ids = [2,4];
            $random_user_id = $ids[array_rand($ids)];
            $user_id = $random_user_id;

            if($old_company->user_id != ''){
                $user = User::where('old_id', $old_company->user_id)->first();
                $user_id = $user ? $user->id : $random_user_id;
            }

            if($old_company->industries){
                $industry_ids = [];
                $old_industry_ids = explode(',', $old_company->industries);
                foreach($old_industry_ids as $old_industry_id){
                    $old_industry = TempIndustry::where('old_id', $old_industry_id)->first();
                    if($old_industry){
                        $industry_ids[] = $old_industry->id;
                    }
                }
                if(count($industry_ids) > 0){
                    $industry_ids = implode(',', $industry_ids);
                }
                else{
                    $industry_ids = null;
                }  
            }
            else{
                $industry_ids = null;
            }

            if($old_company->categories){
                $category_ids = [];
                $old_category_ids = explode(',', $old_company->categories);
                foreach($old_category_ids as $old_category_id){
                    $old_category = Category::where('old_id', $old_category_id)->first();
                    if($old_category){
                        $category_ids[] = $old_category->id;
                    }
                }
                if(count($category_ids) > 0){
                    $category_ids = implode(',', $category_ids);
                }
                else{
                    $category_ids = null;
                }  
            }
            else{
                $category_ids = null;
            }

            $name = ($old_company->display_name != null) ? $old_company->display_name : $old_company->name;
            
            $parent_organization = ($old_company->name == $old_company->display_name) ? null : $old_company->name;


            $new_companies[] = [
                'old_id' => $old_company->id,
                'hex' => Str::random(11),
                'user_id' => $user_id,
                'category_ids' => $category_ids,
                'industry_ids' => $industry_ids,
                'registered_name' => $name,
                'trading_name' => $old_company->short_name,
                'parent_organization' => $parent_organization,
                'description' => $old_company->descr,
                'website' => $old_company->website,
                'image' => $old_company->logo,
                'founded_in' => $old_company->founded,
                'family_business' => $old_company->family_business,
                'family_name' => $old_company->family_name,
                'family_generations' => $old_company->family_generations,
                'family_executive' => $old_company->family_executive,
                'female_executive' => $old_company->woman_executive,
                'stock_listed' => $old_company->stock_exchange,
                'matchbird_partner' => $old_company->matchbird_partner,
                'mail_blacklist' => $old_company->mail_blacklist,
                'address_number' => $old_company->address_number,
                'address_street' => $old_company->address_street,
                'address_city' => $old_company->address_city,
                'address_state' => $old_company->address_state,
                'address_zip' => $old_company->address_zip,
                'address_country' => $old_company->address_country,
                'address_phone' => $old_company->address_telephone,
                'views' => $old_company->views,
                'locked' => $old_company->locked,
                'created_at' => date('Y-m-d H:i:s', $old_company->created),
                'updated_at' => date('Y-m-d H:i:s', $old_company->updated),
                'tofam_status' => $old_company->tofam_status,
                'status' => (($old_company->active == 1) && ($old_company->tofam_status == 'in')) ? 'public' : 'private'
            ];
        }

        Company::insert($new_companies);



        // Get newly created companies
        $companies = Company::all();

        foreach($companies as $company){   
            
            $slug = ($company->trading_name) ? $company->trading_name : $company->registered_name;

            $slug = str_replace('ä', 'ae', $slug);
            $slug = str_replace('Ä', 'ae', $slug);
            $slug = str_replace('ö', 'oe', $slug);
            $slug = str_replace('Ö', 'oe', $slug);
            $slug = str_replace('ü', 'ue', $slug);
            $slug = str_replace('Ü', 'ue', $slug);
            $slug = str_replace('ß', 'ss', $slug);

            $company->slug = Str::slug($slug);


            // Source and destination paths
            $source_path = public_path('import_images/companies/'.$company->old_id);
            $destination_path = public_path('images/companies/'.$company->hex);

            // Copy the source directory if it exists
            if(File::isDirectory($source_path)){
                File::copyDirectory($source_path, $destination_path);
                // Rename the image file if it exists in the database
                if($company->image){
                    // Create a new name for the image
                    $new_filename = Str::random(11).'.jpg';
                    // Rename image
                    File::move(
                        $destination_path.'/lg-'.$company->image,
                        $destination_path.'/'.$new_filename
                    );
                    // Rename thumbnail
                    File::move(
                        $destination_path.'/md-'.$company->image,
                        $destination_path.'/tn-'.$new_filename
                    );

                    // Rename thumbnail
                    File::move(
                        $destination_path.'/sm-'.$company->image,
                        $destination_path.'/ico-'.$new_filename
                    );
                    // Get all files in the new folder
                    $filesInFolder = File::allFiles($destination_path);
                    // Delete an files that are not the new image files
                    foreach($filesInFolder as $key => $path){
                        if($path != $destination_path.'/'.$new_filename && $path != $destination_path.'/tn-'.$new_filename){
                            File::delete($path);
                        }
                    }
                }
                // Assign new filename to article object and save
                $company->image = $new_filename;
                $company->save();
            }else{
                $company->image = null;
                $company->save();
            }
        }
    }
}
