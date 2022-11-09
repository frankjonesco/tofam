<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use App\Models\Contact;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get the old contacts
        $old_contacts = Contact::on('mysql_import_old_stuff')->get();

        // Create array for new contacts  
        $new_contacts  = [];

        foreach($old_contacts as $old_contact){
            $user_id = null;
            if($old_contact->user_id){
                $user = User::where('old_id', $old_contact->user_id)->first();
                $user_id = $user ? $user->id : null;
            }

            if($old_contact->company_id){
                $company = Company::where('old_id', $old_contact->company_id)->first();
                if($company){
                    $company_id = $company->id;
                    $new_contacts[] = [
                        'hex' => Str::random(11),
                        'user_id' => $user_id,
                        'company_id' => $company_id,
                        'salutation' => $old_contact->title,
                        'first_name' => $old_contact->first_name,
                        'last_name' => $old_contact->last_name,
                        'gender' => $old_contact->gender,
                        'job_title' => $old_contact->position,
                        'department' => $old_contact->type,
                        'email' => $old_contact->email,
                        'phone' => $old_contact->phone,
                        'mobile' => $old_contact->mobile,
                        'created_at' => date('Y-m-d H:i:s', $old_contact->created),
                        'updated_at' => date('Y-m-d H:i:s', $old_contact->updated),
                        'active' => $old_contact->active
                    ];
                }
            }
        }
        Contact::insert($new_contacts);
    }
}
