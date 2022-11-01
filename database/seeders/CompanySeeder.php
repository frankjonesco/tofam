<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use App\Models\Industry;
use Illuminate\Support\Str;
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
        // Delete the images/companies directoy
        File::deleteDirectory(public_path('images/articles'));

        // Get the old articles
        $old_companies = Company::on('mysql_import_old_stuff')->get();

        // Create array for new articles
        $new_companies = [];

        foreach($old_companies as $old_company){

            $user_id = null;
            if($old_company->user_id){
                $user = User::where('old_id', $old_company->user_id)->first();
                $user_id = $user ? $user->id : null;
            }

            $industry_ids = null;
            if($old_company->industries){
                $old_industry_ids = explode(',', $old_company->industries);
                foreach($old_industry_ids as $old_industry_id){
                    $old_industry = Industry::where('old_id', $old_industry_id)->first();
                    $industry_ids[] = $old_industry ? $old_industry->id : null;
                }
                $industry_ids = implode(',', $industry_ids);
            }

            $category_ids = null;
            if($old_company->categories){
                $old_category_ids = explode(',', $old_company->categories);
                foreach($old_category_ids as $old_category_id){
                    $old_category = Industry::where('old_id', $old_category_id)->first();
                    $category_ids[] = $old_category ? $old_category->id : null;
                }
                $category_ids = implode(',', $category_ids);
            }

            $name = ($old_company->display_name != null) ? $old_company->display_name : $old_company->name;
            $parent_organization = ($old_company->name == $old_company->display_name) ? null : $old_company->name;


            $new_companies[] = [
                'old_id' => $old_company->id,
                'hex' => Str::random(11),
                'user_id' => $user_id,
                'category_ids' => $category_ids,
                'industry_ids' => $industry_ids,
                'trading_name' => $old_company->short_name,
                'registered_name' => $name,
                'parent_organization' => $parent_organization,
                'description' => $old_company->descr,
                'website' => $old_company->website,
                'logo' => $old_company->logo,
                'founded' => $old_company->founded,
                'family_business' => $old_company->family_business,
                'family_name' => $old_company->family_name,
                'family_generations' => $old_company->family_generations,
                'family_executive' => $old_company->family_executive,
                'female_executive' => $old_company->woman_executive,
                'stock_listed' => $old_company->stock_exchange,
                'matchbird_partner' => $old_company->matchbird_partner,
                'tofam_company' => $old_company->tofam_company,
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
                'active' => $old_company->active
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
            $source_path = public_path('images/companies_old/'.$company->old_id);
            $destination_path = public_path('images/companies/'.$company->hex);

            // Copy the source directory if it exists
            if(File::isDirectory($source_path)){
                File::copyDirectory($source_path, $destination_path);
                // Rename the image file if it exists in the database
                if($company->logo){
                    // Create a new name for the image
                    $new_filename = Str::random(11).'.jpg';
                    // Rename image
                    File::move(
                        $destination_path.'/lg-'.$company->logo,
                        $destination_path.'/'.$new_filename
                    );
                    // Rename thumbnail
                    File::move(
                        $destination_path.'/md-'.$company->logo,
                        $destination_path.'/tn-'.$new_filename
                    );

                    // Rename thumbnail
                    File::move(
                        $destination_path.'/sm-'.$company->logo,
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
                $company->logo = $new_filename;
                $company->save();
            }else{
                $company->logo = null;
                $company->save();
            }
        }
    }
}
