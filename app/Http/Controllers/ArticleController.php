<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    // Show all articles
    public function index(){

        // dd(config('global.messages.unauthorized'));

        $articles = Article::where('status', 'public')->orderBy('created_at', 'DESC')->paginate(9);

        foreach($articles as $key => $article){
            if($article->tags){
                $articles[$key]['tags'] = explode(',', $article->tags);
            }
        }

        return view('articles.index', [
            'articles' => $articles
        ]);
    }


    // Show single article
    public function show(Article $article, $slug){

        $article->views = ++$article->views; //$var+1
        $article->save();

        if($article->tags){
            $article['tags'] = explode(',', $article->tags);
        }

        $other_articles = Article::where('id', '!=' , $article->id)->orderByRaw('RAND()')->take(3)->get();;
        foreach($other_articles as $key => $other_article){
            $other_articles[$key]['tags'] = explode(',', $other_article->tags);
        }

        return view('articles.show', [
            'article' => $article,
            'other_articles' => $other_articles
        ]);
    }


    // Show create form
    public function create(){

        $categories = Category::orderBy('name', 'asc')->get();

        return view('dashboard.articles.create', [
            'categories' => $categories
        ]);
    }


    // Store article in database
    public function store(Request $request){

        //  Validate form fields
        $formFields = $request->validate([
            'title' => 'required',
            'caption' => 'required',
            'teaser' => 'required',
            'body' => 'required',
            'status' => 'required'
        ]);

        // Generare a random hex that does not already exist
        $hex = Str::random('11');
        while(Article::where('hex', $hex)->exists()){
            $hex = Str::random('11');
        }   
        
        // Additaional non input dependent fields
        $formFields['hex'] = $hex;
        $formFields['user_id'] = auth()->id();
        $formFields['category_id'] = ($request->category == '') ? null : $request->category;
        $formFields['slug'] = Str::slug($request->title);
        $formFields['tags'] = strtolower(str_replace('  ', '', str_replace(', ', ',', str_replace(' ,', ',', $request->tags))));


        // Handle the image if it exists
        if($request->hasFile('image')){
            $imageName = Str::random('6').'-'.time().'.'.$request->image->extension();

            // Store in public folder
            $request->image->move(public_path('images/articles/'.$hex), $imageName);

            // // Store in storage folder
            // $request->image->storeAs('images', $imageName);

            // // Store in s3
            // $request->image->storeAs('images', $imageName, 's3');

            // Add image name to form fields
            $formFields['image'] = $imageName;
        }

        // Create article
        Article::create($formFields);

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
