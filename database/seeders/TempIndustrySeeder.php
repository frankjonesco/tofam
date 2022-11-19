<?php

namespace Database\Seeders;

use App\Models\Site;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\TempIndustry;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TempIndustrySeeder extends Seeder
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
        $old_industries = TempIndustry::on('mysql_import_old_stuff')->get();

        // Empty industries
        $empty_industries = [6794,6422,7013,6968,6506,6712,7042,6903,6754,6847,6760,6715,6741,6538,6723,6830,6680,7006,6512,6931,6921,6928,6607,6831,6499,6859,6509,6937,6871,6599,6900,6899,6497,6797,6597,6577,6987,6907,6620,7038,6536,6932,6923,6411,6857,6376,6868,6709,6562,6925,6971,6716,6568,6622,6880,6952,7005,6528,6466,7011,6964,6662,6879,7002,6965,6892,6979,6359,6855,6747,7001,7021,6970,6399,6608,6475,6629,6886,6998,7004,6589,6600,6999,6873,6811,6401,7047,6548,6992,6490,6920,7040,6533,7030,6815,6658,6482,6395,6714,6514,6700,7027,6945,6882,6837,6702,7033,6969,7048,6576,6902,7041,6694,6590,6476,6926,6667,6960,6933,6743,6946,6803,6421,6905,6685,7022,6767,6870,6674,6574,6833,7015,6862,6800,7028,6822,6625,6890,6963,6889,6456,6751,6684,6918,6366,6583,6834,6799,6358,6936,6934,6876,6416,7008,6944,7039,6828,7017,6826,6865,6954,6901,6621,7044,7000,6919,6872,6701,6866,6881,6505,6582,6884,6996,6664,6727,6897,6940,7046,6808,6637,6502,6660,6619,7035,6478,6586,6634,6591,7031,6623,6948,6610,6721,6510,6819,6955,6814,6454];

        // Create array for new industries 
        $new_industries = [];

        foreach($old_industries as $old_industry){

            if(in_array($old_industry->id, $empty_industries) == false){
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
                    'english_name' => $old_industry->english_name,
                    'english_slug' => Str::slug($old_industry->english_name),
                    'color_id' => $site->randomColor(\App\Models\Config::where('id', 1)->first()->color_swatch_id),
                    'created_at' => date('Y-m-d H:i:s', $old_industry->created),
                    'updated_at' => date('Y-m-d H:i:s', $old_industry->updated),
                    'status' => 'public'
                ];
            }
        }
        
        TempIndustry::insert($new_industries);
    }
}
