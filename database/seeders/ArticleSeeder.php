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

            
            $article = new Article();
            $article->old_id = $row->id;
            $article->hex = Str::random(11);
            $article->user_id = $user_id;
            $article->sponsor_id = $sponsor_id;
            $article->title = $row->title;
            $article->slug = Str::slug($row->title);
            $article->caption = $row->caption;
            $article->teaser = $row->teaser;
            $article->body = $row->main_text;
            $article->tags = Article::getRandomTags();
            $article->image = $row->image;
            $article->image_caption = $row->image_caption;
            $article->image_copyright = $row->image_copyright;
            $article->image_cropped = $row->image_cropped;
            $article->views = $row->views;
            $article->status = $row->status;

            $article->save();
        }

        

        



        // Get newly created articles
        $articles = Article::all();

        foreach($articles as $article){        
            // Source and destination paths
            $source_path = public_path('import_images/articles/'.$article->old_id);
            $destination_path = public_path('images/articles/'.$article->hex);

            // Copy the source directory if it exists
            if(File::isDirectory($source_path)){
                File::copyDirectory($source_path, $destination_path);
                // Rename the image file if it exists in the database
                if($article->image){
                    // Create a new name for the image
                    $new_filename = Str::random(11).'.jpg';
                    // Rename image
                    File::move(
                        $destination_path.'/'.$article->image,
                        $destination_path.'/'.$new_filename
                    );
                    // Rename thumbnail
                    File::move(
                        $destination_path.'/thumb-'.$article->image,
                        $destination_path.'/tn-'.$new_filename
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
                $article->image = $new_filename;
                $article->save();
            }else{
                $article->image = null;
                $article->save();
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
