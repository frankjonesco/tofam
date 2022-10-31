<?php

namespace Database\Seeders;

use App\Models\Site;
use App\Models\User;
use App\Models\Industry;
use Illuminate\Support\Str;
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
        $site = new Site();
        
        // Get the old industries
        $old_industries = Industry::on('mysql_import_old_stuff')->get();

        // Create array for new industries
        $new_industries = [];

        foreach($old_industries as $old_industry){

            $user_id = null;
            if($old_industry->user_id){
                $user = User::where('old_id', $old_industry->user_id)->first();
                $user_id = $user ? $user->id : null;
            }

            $new_industries[] = [
                'old_id' => $old_industry->id,
                'hex' => Str::random(11),
                'user_id' => $user_id,
                'name' => $old_industry->name,
                'slug' => Str::slug($old_industry->name),
                'color_id' => $site->randomColor(\App\Models\Config::where('id', 1)->first()->color_swatch_id),
                'created_at' => date('Y-m-d H:i:s', $old_industry->created),
                'updated_at' => date('Y-m-d H:i:s', $old_industry->updated)
            ];
        }

        Industry::insert($new_industries);
    }
}
