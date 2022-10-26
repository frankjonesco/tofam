<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

use Image;

class ArticleController extends Controller
{
    private $site;
    private $category;
    private $article;

    public function __construct(Site $site, Category $category, Article $article)
    {
        $this->site = $site;
        $this->category = $category;
        $this->article = $article;
    }


    // SHOW ALL ARTICLES
    public function index(){
        return view('articles.index', [
            'articles' => $this->site->publicArticles()
        ]);
    }


    // SHOW SINGLE ARTICLE
    public function show(Article $article, $slug = null){
        // Increment the number of views
        $article->addView($article);

        // Explode this article's tags to an array
        $article->tagsToArrayFromOne($article);

        // Load the view
        return view('articles.show', [
            'article' => $article,
            'other_articles' => $article->otherPublicArticles($article->hex)
        ]);
    }


    // SHOW CREATE ARTICLE FORM
    public function create(){
        // Fetch categories
        $categories = $this->site->publicCategories();

        return view('dashboard.articles.create', [
            'categories' => $categories
        ]);
    }


    // STORE ARTICLE 
    public function store(Request $request){
        // Validate form fields
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'image' => 'image|mimes:jpeg,jpg,png,gif,svg|max:2048',
            'tags' => 'regex:/^[a-zA-Z0-9 ,]+$/',
            'status' => 'required'
        ],
        [
            'tags.regex' => 'Only alphanumeric characters and commas are allowed in \'tags\''
        ]);

        // Create article
        $this->article->createArticle($request);

        return redirect('articles')->with('message', 'Article created!');
    }


    // SHOW ARTICLE EDIT FORM
    public function edit(Article $article){
        return view('dashboard.articles.edit', [
            'article' => $article,
            'categories' => Site::publicCategories()
        ]);
    }


    // UPDATE ARTICLE
    public function update(Request $request, Article $article){
        // Validate form fields 
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'image' => 'image|mimes:jpeg,jpg,png,gif,svg|max:2048',
            'tags' => 'regex:/^[a-zA-Z0-9 ,]+$/',
            'status' => 'required',
        ],
        [
            'tags.regex' => 'Only alphanumeric characters and commas are allowed in \'tags\''
        ]);

        // Save changes to this article
        $article->saveArticle($request, $article);

        return redirect('articles/'.$article->hex.'/'.$article->slug)->with('message', 'Article updated!');
    }


    // DELETE ARTICLE
    public function destroy(Article $article){
        // Delete article if logged in user is the owner
        if($article->checkOwnerDeleteOrDie($article)){
            return redirect('articles')->with('message', 'Article deleted!');
        }
        return redirect('articles/'.$article->hex.'/'.$article->slug)->with('staticError', 'You do not have permission to delete this article.');
    }
    
}
