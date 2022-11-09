<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use App\Models\Ranking;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;

class RankingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get the old rankings
        $old_rankings = Ranking::on('mysql_import_old_stuff')->get();

        // Create array for new rankings  
        $new_rankings  = [];

        foreach($old_rankings as $old_ranking){
            $user_id = null;
            if($old_ranking->user_id){
                $user = User::where('old_id', $old_ranking->user_id)->first();
                $user_id = (empty($user)) ? null : $user->id;
            }

            $user_id = null;

            if($old_ranking->company_id){
                $company = Company::where('old_id', $old_ranking->company_id)->first();
                if(empty($company) == false){
                    $company_id = $company->id;
                    $new_rankings[] = [
                        'hex' => Str::random(11),
                        'user_id' => $user_id,
                        'company_id' => $company_id,
                        'year' => $old_ranking->year,
                        'is_latest' => $old_ranking->latest,
                        'turnover' => $old_ranking->turnover,
                        'employees' => $old_ranking->employees,
                        'training_rate' => $old_ranking->training_rate,
                        'confirmed_by_company' => ($old_ranking->source == 1) ?? null,
                        'note' => ($old_ranking->note == null) ? 'Imported from transfer - '.date('F d, Y', time()) : $old_ranking->note,
                        // 'created_at' => date('Y-m-d H:i:s', $old_ranking->created),
                        // 'updated_at' => date('Y-m-d H:i:s', $old_ranking->updated),
                    ];
                }
            }
        }

        foreach($new_rankings as $new_ranking){
            Ranking::create($new_ranking);
        }

    }
}
