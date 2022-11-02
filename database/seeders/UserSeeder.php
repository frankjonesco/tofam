<?php

namespace Database\Seeders;

use App\Models\Site;
use App\Models\User;
use App\Models\Config;
use App\Models\UserType;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $site = new Site();
        // Create the user types
        $user_types = UserType::on('mysql_import_old_stuff')->get();

        foreach($user_types as $user_type) {
            UserType::create([
                'old_id' => $user_type->id,
                'hex' => Str::random(11),
                'name' => $user_type->name,
                'slug' => Str::slug($user_type->name),
                'active' => $user_type->active
            ]);
        }


        // Create the users
        $users = User::on('mysql_import_old_stuff')->get();

        foreach($users as $user){

            $user_type_id = UserType::where('old_id', $user->user_type)->first()->id;

            User::create([
                'old_id' => $user->id,
                'hex' => Str::random(11),
                'user_type_id' => $user_type_id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'username' => $user->username,
                'email' => $user->email,
                'email_verified_at' => $user->created,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
                'remember_token' => Str::random(10),
                'image' => $user->image,
                'gender' => $user->gender,
                'country_iso' => $user->country,
                'color_fill_id' => $site->randomColor(\App\Models\Config::where('id', 1)->first()->color_swatch_id),
                'created_at' => $user->created,
                'updated_at' => now(),
            ]);


        }

        // Copy the old image to the new user directoy

        // Delete the images/users directory if it exists
        File::deleteDirectory(public_path('images/users'));

        $users = User::all();
        foreach($users as $user){
            // Source and destination paths
            $source_path = public_path('import_images/users/'.$user->old_id);
            $destination_path = public_path('images/users/'.$user->hex);

            // Copy the source directory if it exists
            if(File::isDirectory($source_path)){
                File::copyDirectory($source_path, $destination_path);

                // Rename the image file if it exists in the database
                if($user->image){
                    $random = Str::random(11);
                    $new_image = $random.'.jpg';
                    $new_thumbnail = 'tn-'.$new_image;

                    // New paths to image and thumbnail
                    $new_image_path = $destination_path.'/'.$new_image;
                    $new_thumbnail_path = $destination_path.'/'.$new_thumbnail;

                    // Rename image
                    File::move(
                        $destination_path.'/'.$user->image,
                        $new_image_path
                    );

                    // Rename thumbnail
                    File::move(
                        $destination_path.'/thumb-'.$user->image,
                        $new_thumbnail_path
                    );

                    // List all files in this user's directory
                    $files_in_folder = File::allFiles($destination_path);

                    // Delete unneeded images from this user's directory
                    foreach($files_in_folder as $key => $path){
                        if($path != $new_image_path && $path != $new_thumbnail_path){
                            File::delete($path);
                        }
                    }
                }
                

                // Update the image field for this user in the database
                $user->image = $new_image;
                $user->save();

            }
        }

    }
}
