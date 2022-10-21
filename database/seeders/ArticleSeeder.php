<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Article;
use App\Models\Sponsor;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        File::deleteDirectory(public_path('images/articles'));
        // Storage::deleteDirectory('path');

        //Article::factory(40)->create();

        $input = Article::on('mysql_import_old_stuff')->get();

        $articles = [];

        // $sponsors = DB::table('sponsors')->all();
        // $sponsor_names = DB::table('sponsors')->pluck('name')->toArray();
        
        foreach($input as $row){

            $sponsor_id = null;
            if($row->sponsor != 'no' && $row->sponsor != null){
                $sponsor = Sponsor::where('slug', $row->sponsor)->first();
                $sponsor_id = $sponsor ? $sponsor->id : null;
            }

            $user_id = null;
            if($row->user_id){
                $user = User::where('old_id', $row->user_id)->first();
                $user_id = $user ? $user->id : null;
            }

            $articles[] = [
                'old_id' => $row->id,
                'hex' => Str::random(11),
                'user_id' => $user_id,
                'sponsor_id' => $sponsor_id,
                'title' => $row->title,
                'slug' => Str::slug($row->title),
                'caption' => $row->caption,
                'teaser' => $row->teaser,
                'body' => $row->main_text,
                'image' => $row->image,
                'image_caption' => $row->image_caption,
                'image_copyright' => $row->image_copyright,
                'image_cropped' => $row->image_cropped,
                'views' => $row->views,
                'created_at' => date('Y-m-d H:i:s', $row->created),
                'updated_at' => date('Y-m-d H:i:s', $row->updated),
                'status' => $row->status
            ];
        }

        $article = Article::insert($articles);



        // New records
        $rows = Article::all();

        foreach($rows as $row){
        
            // Source and destination paths
            $sourcePath = public_path('images/articles_old/'.$row->old_id);
            $destinationPath = public_path('images/articles/'.$row->hex);

            // Copy the source directory if it exists
            if(File::isDirectory($sourcePath)){
                File::copyDirectory($sourcePath, $destinationPath);

                // Rename the image file if it exists in the database
                if($row->image){
                    $random = Str::random(11);
                    // Rename image
                    File::move(
                        $destinationPath.'/'.$row->image,
                        $destinationPath.'/'.$random.'.jpg'
                    );
                    // Rename thumbnail
                    File::move(
                        $destinationPath.'/thumb-'.$row->image,
                        $destinationPath.'/tn-'.$random.'.jpg'
                    );


                
                
                    $filesInFolder = File::allFiles($destinationPath);


                    foreach($filesInFolder as $key => $path){
                        if($path != $destinationPath.'/'.$random.'.jpg' && $path != $destinationPath.'/tn-'.$random.'.jpg'){
                            File::delete($path);
                        }
                    }

                }

                $row->image = $random.'.jpg';
 
                $row->save();
            }

        }


        

        // Article::insert([
        //     [
        //         // Article one
        //         'hex' => Str::random(11),
        //         'user_id' => '1',
        //         'category_id' => null, 
        //         'title' => 'This is title one', 
        //         'slug' => 'this-is-title-one', 
        //         'caption' => 'Here is a bit of a caption.', 
        //         'teaser' => 'And some teaser text.',
        //         'body' => 'Here is the main body text of the article with the most information here.', 
        //         'image' => null, 
        //         'created_at' => now(), 
        //         'updated_at' => now(),
        //         'status' => 'public'
        //     ],
            
        // ]);
    }
}