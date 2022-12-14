<?php

namespace App\Models;

use App\Models\Color;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use Intervention\Image\Facades\Image;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Site extends Model
{
    use HasFactory;

    
    // Get random color ID
    public function randomColor($color_swatch_id = null, $field = 'fill_id'){
        $color_swatch_id = $color_swatch_id ?? Config::where('id', 1)->first()->color_swatch_id;
        

        return Color::where('color_swatch_id', $color_swatch_id)->inRandomOrder()->first()->$field;
    }


    // Find unique hex for 'table', default length 11 characters
    public function uniqueHex(string $table, string $field = 'hex', int $length = 11){
        // Generate hex
        $hex = Str::random($length);
        // Regenerate hex if it already exists
        while(DB::table($table)->where($field, $hex)->exists()){
            $hex = Str::random($length);
        }
        return $hex;
    }


    // Get active users (not blocked)
    public static function activeUsers(){
        return User::orderBy('id', 'ASC')->where('blocked', '!=', 1)->orWhereNull('blocked')->get();
    }

    
    // CATEGORIES

    // Get public categories
    public static function allCategories(){
        return Category::orderBy('name', 'ASC')->get();
    }

    // Get public categories
    public static function publicCategories(){
        return Category::where('status', 'public')->orderBy('name', 'ASC')->get();
    }

    // Get public categories
    public static function MyCategories(){
        return Category::where('user_id', auth()->user()->id)->orderBy('name', 'ASC')->get();
    }


    // INDUSTRIES

    // Get public industries
    public static function allIndustries(){
        return Industry::orderBy('name', 'ASC')->paginate(8);
    }

    // Get public industries
    public static function publicIndustries(){
        return Industry::where('status', 'public')->orderBy('name', 'ASC')->get();
    }

    // Get public industries
    public static function MyIndustries(){
        return Industry::where('user_id', auth()->user()->id)->orderBy('name', 'ASC')->paginate(8);
    }


    // ARTICLES

    // Get all articles with exploaded tags
    public static function allArticles($column = 'created_at', $sort = 'DESC'){
        $articles = Article::orderBy($column, $sort)->get();
        foreach($articles as $key => $article){
            $articles[$key]['tags'] = Article::tagsToArrayFromOne($article->tags);
        }
        return $articles;
    }

    // Get all public articles with exploaded tags
    public static function publicArticles(){
        $articles = Article::where('status', 'public')->latest()->paginate(6);
        foreach($articles as $key => $article){
            $articles[$key]['tags'] = Article::tagsToArrayFromOne($article->tags);
        }
        return $articles;
    }

    // Get all public articles with exploaded tags
    public static function myArticles(){
        $articles = Article::where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC')->get();
        foreach($articles as $key => $article){
            $articles[$key]['tags'] = Article::tagsToArrayFromOne($article->tags);
        }
        return $articles;
    }

    // Get other public articles with exploaded tags
    public static function otherPublicArticles($hex){
        $other_articles = Article::where('status', 'public')->where('hex', '!=' , $hex)->orderBy(DB::raw('RAND()'))->take(3)->get();
        foreach($other_articles as $key => $other_article){
            $other_articles[$key]['tags'] = Article::tagsToArrayFromOne($other_article->tags);
        }
        return $other_articles;
    }

    // Get public articles that have a specific tag
    public function publicArticlesWithTag($tag){
        $articles = Article::where([['tags', 'like', '%'.$tag.'%'], ['status', 'public']])->paginate(6);
        foreach($articles as $key => $article){
            $articles[$key]['tags'] = Article::tagsToArrayFromOne($article->tags);
        }
        return $articles;
    }

    // Get public articles that are similar to our search term
    public function similarPublicArticles($term){
        $articles = Article::where('title', 'like', '%'.$term.'%')
            ->orWhere('body', 'like', '%'.$term.'%')
            ->orWhere('tags', 'like', '%'.$term.'%')->where('status', 'public')->paginate(6);
        foreach($articles as $key => $article){
            $articles[$key]['tags'] = Article::tagsToArrayFromOne($article->tags);
        }
        return $articles;
    }


    // COMPANIES

    // Get single company by hex
    public function getCompany($hex){
        return Company::where('hex', $hex)->first();
    }

    public static function allCompanies($column = 'created_at', $sort = 'DESC'){
        $companies = Company::orderBy($column, $sort)->get();
        return $companies;
    }

    public static function allCompaniesPaginated($column = 'registered_name', $sort = 'ASC'){
        $companies = Company::orderBy($column, $sort)->paginate(20);
        return $companies;
    }

    // Get all companies that are similar to our search term
    public function allSimilarCompanies($term){
        $companies = Company::where('registered_name', 'like', '%'.$term.'%')
            ->orWhere('trading_name', 'like', '%'.$term.'%')
            ->orWhere('description', 'like', '%'.$term.'%')
            ->paginate(6);
        return $companies;
    }


    // COLOR SWATCHES

    // Get all color swatches
    public function allColorSwatches(){
        return ColorSwatch::get();
    }

    // Get single color swatch by hex
    public function getColorSwatch($hex){
        return ColorSwatch::where('hex', $hex)->first();
    }

    

    // Handle image upload
    public function handleImageUpload($request, $directory, $hex){  
        // If an image has been added to the request
        if($request->hasFile('image')){
            // Define a name for the new image
            $image_name = Str::random('6').'-'.time().'.'.$request->image->extension();
            // Specify the direcory path
            $directory_path = public_path('images/'.$directory.'/'.$hex);
            // Store in public folder
            $request->file('image')->move($directory_path, $image_name);
            // List all the file in the directory
            $files_in_folder = File::allFiles($directory_path);
            // Delete all files that are not the new image
            foreach($files_in_folder as $key => $path){
                if($path != $directory_path.'/'.$image_name){
                    File::delete($path);
                }
            }
            // Create a thumbnail
            self::makeImageThumbnail($directory_path, $image_name);

            return $image_name;
        }
       
    }


    // Make image thumbnail
    public function makeImageThumbnail($directory_path, $image_name){
        // Resize image thumbnail
        Image::make($directory_path.'/'.$image_name)
            ->resize(380, null, function ($constraint){ 
                $constraint->aspectRatio(); 
            })
            ->save($directory_path.'/tn-'.$image_name);
    }


    // Get user types
    public function getUserTypes(){
        return DB::table('user_types')->where('active', 1)->orderBy('id', 'ASC')->get();
    }

    // Get countries
    public function getCountries(){
        return Country::orderBy('name', 'ASC')->get();
    }


    public static function validateUrl($url){
        return false;
    }



    // FORMATTERS
    
    // Format comma separated value text input
    public function formatCsvTextInput($values){
        $values = explode(',', $values);
        $formatted_values = [];
        foreach($values as $value){
            $value = trim($value);
            if($value){
                $formatted_values[] = $value;
            }
        }
        return implode(',', $formatted_values);
    }


    public function collectionColumnToCsv($rows, $column = 'id'){
        $idsCsv = null;
        foreach($rows as $row){
            $idsCsv .= $row->$column.',';
        }
        $idsCsv = trim($idsCsv, ',');
        return $idsCsv;
    }

    public function trimExplodeCsv($csv){
        $csv = trim($csv, ',');
        $csv_as_array = explode(',', $csv);
        return $csv_as_array;
    }

    public function prepSlug($value){
        $value = strtolower($value);
        $value = trim($value);
        $value = str_replace('??', 'ae', $value);
        $value = str_replace('??', 'oe', $value);
        $value = str_replace('??', 'ue', $value);
        $value = str_replace('??', 'ss', $value);
        $value = str_replace('/', '-', $value);
        $value = str_replace('&', 'and', $value);
        return $value;
    }
}



