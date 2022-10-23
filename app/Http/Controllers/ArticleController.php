<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    private $article;

    public function __construct()
    {
        
    }

    // SHOW ALL ARTICLES
    public function index(){
        // Fetch articles and paginate
        $articles = Article::getPublicArticles()->latest()->paginate(9);
        
        // Explode each article's tags to arrays
        $articles = Article::tagsToArrayFromMany($articles);

        return view('articles.index', [
            'articles' => $articles
        ]);
    }


    // SHOW SINGLE ARTICLE
    public function show(Article $article, $slug){
        // Increment the number of views
        $article->addView($article);

        // Explode this article's tags to an array
        $article->tagsToArrayFromOne($article);

        // Fetch other articles
        $other_articles = $article->getOtherPublicArticles($article->hex)->take(3)->get();

        // Explode each article's tags to arrays
        $other_articles = Article::tagsToArrayFromMany($other_articles);

        // Load the view
        return view('articles.show', [
            'article' => $article,
            'other_articles' => $other_articles
        ]);
    }


    // Show create form
    public function create(Site $site){
        // Fetch categories
        $categories = $site->getAllCategories();

        return view('dashboard.articles.create', [
            'categories' => $categories
        ]);
    }


    // Store article in database
    public function store(Request $request, Article $article, Site $site){
        // Validate form fields
        $formFields = $request->validate([
            'title' => 'required',
            'caption' => 'required',
            'teaser' => 'required',
            'body' => 'required',
            'status' => 'required'
        ]);

        // Create article
        $article->createArticle($request, $formFields, $site);

        return redirect('articles')->with('message', 'Article created!');
    }


    // Show article edit form
    public function edit(Article $article){
        return view('dashboard.articles.edit', [
            'article' => $article
        ]);
    }


    // Update article
    public function update(Article $article, Request $request){
        // Validate form fields 
        $formFields = $request->validate([
            'title' => 'required',
            'caption' => 'required',
            'teaser' => 'required',
            'body' => 'required',
            'status' => 'required',
        ]);

        // Save changes to this article
        $article->saveArticle($request, $article, $formFields);

        return redirect('articles/'.$article->hex.'/'.$article->slug)->with('message', 'Article updated!');
    }


    // Delete article
    public function destroy(Article $article){
        if($article->userIsOwner($article)){
            $article->delete();
            return redirect('articles')->with('message', 'Article deleted!');
        }else{ 
            return back()->with('staticError', 'You do not have permission to delete this article.');
        }
    }
    
}
