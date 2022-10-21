<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Sponsor;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;

class SiteController extends Controller
{
    public function home(){
        // dd(Category::select('id')->where('old_id', 2)->get());
        // dd(Category::where('old_id', 2)->first()->id);
        
        // $item = Sponsor::where('id', 1)->first();
        // dd($item->name);

        return view('home');
    }

    public function tags($term){

        $articles = Article::where('tags', 'like', '%'.$term.'%')->paginate(3);

        foreach($articles as $key => $article){
            $articles[$key]['tags'] = explode(',', $article->tags);
        }

        return view('articles.index', [
            'articles' => $articles
        ]);
    }

    public function search(Request $request){
        Session::flash('searchTerm', $request->search);
        return redirect('search/'.$request->search);
    }

    public function searchRetrieve($term){

        $articles = Article::where('title', 'like', '%'.$term.'%')
            ->orWhere('body', 'like', '%'.$term.'%')
            ->orWhere('tags', 'like', '%'.$term.'%')->paginate(3);
        
        foreach($articles as $key => $article){
            $articles[$key]['tags'] = explode(',', $article->tags);
        }

        return view('articles.index', [
            'articles' => $articles,
            'count' => $articles->total()
        ]);
    }

    public function json(){

        $input = Category::on('mysql_import_old_stuff')->get();

        $categories = [];

        foreach($input as $row){
            $categories[] = [
                'old_id' => $row->id,
                'hex' => Str::random(11),
                'user_id' => 1,
                'name' => $row->name,
                'slug' => Str::slug($row->name),
                'description' => null,
                'image' => $row->image,
                'color' => $row->color
            ];
        }

        dd($categories);

        $output = $input;

        return view('json', [
            'output' => $output
        ]);
    }
}