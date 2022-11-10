<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Company;
use App\Models\Association;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AssociationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $old_associations = Association::on('mysql_import_old_stuff')->get();
        
        foreach($old_associations as $old_association){
            $article = Article::where('old_id', $old_association->article_id)->first();
            $company = Company::where('old_id', $old_association->company_id)->first();
            if($article){
                if($company){
                    $associations[] = [
                        'article_id' => $article->id,
                        'company_id' => $company->id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
            }
        }

        Association::insert($associations);
    }
}
