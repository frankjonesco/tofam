<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Site;
use App\Models\Article;
use App\Models\Category;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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

    // SHOW ARTICLE THAT HAVE THIS TAG
    public function tags($term){
        $articles = Article::where('tags', 'like', '%'.$term.'%')->paginate(3);
        foreach($articles as $key => $article){
            $articles[$key]['tags'] = explode(',', $article->tags);
        }
        return view('articles.index', [
            'articles' => $articles
        ]);
    }

    // SEARCH ARTICLES
    public function search(Request $request){
        Session::flash('searchTerm', $request->search);
        return redirect('articles/search/'.$request->search);
    }

    // SEARCH ARTICLES RESULTS
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

    // SHOW SINGLE ARTICLE
    public function show(Article $article, $slug = null, Site $site){
        // Increment the number of views
        $article->addView($article);
        // Explode this article's tags to an array
        $article->tagsToArrayFromOne($article->tags);
        // Return 0 if article->like is NULL
        $article->likes = $article->likes ?? 0;
        // Load the view
        return view('articles.show', [
            'article' => $article,
            'other_articles' => $site->otherPublicArticles($article->hex)
        ]);
    }

    // LIKE ARTICLE
    public function like(Request $request){
        $article = Article::where('hex', $request->hex)->first();
        $likes = $article->likes + 1;
        if($article->update(['likes' => $likes])){
            session()->put('liked_'.$request->hex, true);
            return $likes;
        }
        return false;
    }

    // UNLIKE ARTICLE
    public function unlike(Request $request){
        $article = Article::where('hex', $request->hex)->first();
        if($article->likes <= 0){
            return $article->likes;
        }
        $likes = $article->likes - 1;
        if($article->update(['likes' => $likes])){
            session()->pull('liked_'.$request->hex);
            return $likes;
        }
        return false;
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



    // ARTICLES: INDEX
    public function adminIndex(){
        return view('dashboard.articles.index', [
            'articles' => Site::allArticles(),
        ]);
    }

    // ARTICLES: MINE
    public function mine(){
        return view('dashboard.articles.mine', [
            'articles' => Article::where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC')->get(),
        ]);
    }

    // SHOW CREATE ARTICLE FORM
    public function create(){
        $categories = $this->site->publicCategories();
        return view('dashboard.articles.create', [
            'categories' => $categories
        ]);
    }

    // STORE ARTICLE 
    public function store(Request $request){
        // Validate form fields
        $request->validate(
            [
                'title' => 'required',
                'tags' => ['regex:/^[a-zA-Z0-9 ,]+$/', 'nullable'],
            ],
            [
                'tags.regex' => 'Only alphanumeric characters and commas are allowed in \'tags\''
            ]
        );
        // Create article
        $this->article->createArticle($request);
        return redirect('dashboard/articles')->with('message', 'New article created!');
    }

    // ARTICLES: EDIT GENERAL
    public function editText(Article $article){   
        return view('dashboard.articles.edit-text', [
            'article' => $article
        ]);
    }

    // ARTICLES: EDIT STORAGE
    public function editStorage(Article $article){   
        return view('dashboard.articles.edit-storage', [
            'article' => $article,
            'categories' => Site::publicCategories(),
        ]);
    }

    // ARTICLES: EDIT IMAGE
    public function editImage(Article $article){   
        return view('dashboard.articles.edit-image', [
            'article' => $article,
        ]);
    }

    // ARTICLES: EDIT PUBLISHING
    public function editPublishing(Article $article){   
        return view('dashboard.articles.edit-publishing', [
            'article' => $article,
        ]);
    }

    // ARTICLES: UPDATE GENERAL
    public function updateText(Request $request){
        
        // Validate form fields 
        $request->validate([
            'title' => 'required',
            'tags' => ['regex:/^[a-zA-Z0-9 ,]+$/', 'nullable'],
        ],
        [
            'tags.regex' => 'Only alphanumeric characters and commas are allowed in \'tags\'',
            'tags.nullable' => 'Null'
        ]);

        $article = Article::where('hex', $request->hex)->first();

        // Save changes to this article
        $article->saveArticle($request, $article);

        return redirect('dashboard/articles/'.$article->hex.'/edit/text')->with('message', 'Aricle text updated!');
    }

    // ARTICLES: UPDATE STORAGE
    public function updateStorage(Request $request){

        $article = Article::where('hex', $request->hex)->first();
        $article->category_id = $request->category_id;
        
        $article->save();

        return redirect('dashboard/articles/'.$article->hex.'/edit/storage')->with('message', 'Aricle storage updated!');
    }

    // ARTICLES: UPDATE IMAGE
    public function updateImage(Request $request){

        $site = new Site();
        $article = Article::where('hex', $request->hex)->first();
        
        if($request->hasFile('image')){
            $article->image = $site->handleImageUpload($request, 'articles', $article->hex);
        }
        
        $article->save();

        return redirect('dashboard/articles/'.$article->hex.'/edit/image')->with('message', 'Aricle image updated!');
    }

    // ARTICLES: UPDATE PUBLISHING
    public function updatePublishing(Request $request){

        $article = Article::where('hex', $request->hex)->first();
        $article->status = $request->status;
        
        $article->save();

        return redirect('dashboard/articles/'.$article->hex.'/edit/status')->with('message', 'Aricle publishing updated!');
    }


    
    
}
