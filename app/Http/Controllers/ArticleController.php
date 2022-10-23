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

        $formFields['hex'] = $article->uniqueHex($site);
        
        


        // Handle the image if it exists
        $article->handleImageUpload($request, $formFields);

        

        // Compile form fields and non-input-dependent fields
        $article = $article->compileArticleData($request, $formFields, $site);

        

        // dd($article);
        // Create article
        Article::create($article);

        // Redirect with success message
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

        // Validate the form 
        $formFields = $request->validate([
            'title' => 'required',
            'caption' => 'required',
            'teaser' => 'required',
            'body' => 'required',
            'status' => 'required',
        ]);
        
        // Slug the title
        $formFields['slug'] = Str::slug($request->title);

        // Handle a new image was added
        if($request->hasFile('image')){
            $imageName = Str::random('6').'-'.time().'.'.$request->image->extension();

            // Store in public folder
            $request->image->move(public_path('images/articles/'.$article->hex), $imageName);

            // Add image name to form fields
            $formFields['image'] = $imageName;
        }

        $formFields['tags'] = strtolower(str_replace('  ', '', str_replace(', ', ',', str_replace(' ,', ',', $request->tags))));
        
        $article->update($formFields);
        
        //dd($article->update($formFields));

        return redirect('articles/'.$article->hex.'/'.$article->slug)->with('message', 'Article updated!');
    }


    // Delete article
    public function destroy(Article $article){

        // Make sure the logged in user is the owner
        if($article->user_id != auth()->id()){
            // abort(403, 'Unathorised Action.');
            return back()->with('staticError', 'You do not have permission to delete this article.');
        }

        $article->delete();

        return redirect('articles')->with('message', 'Article deleted!');
    }
    
}
