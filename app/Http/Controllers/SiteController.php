<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Sponsor;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;

class SiteController extends Controller
{
    public function home(){
        // dd(Category::select('id')->where('old_id', 2)->get());
        // dd(Category::where('old_id', 2)->first()->id);
        
        // $item = Sponsor::where('id', 1)->first();
        // dd($item->name);

        // dd(auth()->user()->color->code);

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
        if(Session::has('searchTerm')){
            Session::flash('searchTerm', $term);
        }
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

    public function showTerms(){
        return view('terms');
    }

    public function showPrivacy(){
        return view('privacy');
    }

    public function showAbout(){
        return view('about');
    }

    public function showContact(){
        return view('contact');
    }
}
