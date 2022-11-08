<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Comment;
use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get the old comments
        $old_comments = Comment::on('mysql_import_old_stuff')->where([['resource_id', '!=', 0], ['resource_id', '!=', null]])->get();

        // Create array for new comments  
        $new_comments  = [];

        foreach($old_comments as $old_comment){
            $user_id = null;
            if($old_comment->user_id){
                $user = User::where('old_id', $old_comment->user_id)->first();
                $user_id = $user ? $user->id : null;
            }

            if($old_comment->resource_type == 'company'){
                $company = Company::where('old_id', $old_comment->resource_id)->first();
                if($company){
                    $resource_id = $company->id;
                    $new_comments[] = [
                        'user_id' => $user_id,
                        'parent_id' => $old_comment->parent_id,
                        'resource_type' => $old_comment->resource_type,
                        'resource_id' => $resource_id,
                        'comment' => $old_comment->comment,
                        'created_at' => date('Y-m-d H:i:s', $old_comment->created),
                        'updated_at' => date('Y-m-d H:i:s', $old_comment->updated),
                    ];
                }
            }
        }
        Comment::insert($new_comments);
    }
}
