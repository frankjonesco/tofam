<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Site;
use App\Models\Article;
use App\Models\Category;

use App\Models\Association;
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
    public function tags($tag){
        $articles = $this->site->publicArticlesWithTag($tag);
        $articles->show_tag_results = true;
        return view('articles.index', [
            'articles' => $articles,
            'count' => $articles->total(),
            'tag' => $tag
        ]);
    }

    // SEARCH ARTICLES
    public function search(Request $request){
        Session::flash('searchTerm', $request->search);
        return redirect('articles/search/'.$request->search);
    }

    // SEARCH ARTICLES RESULTS
    public function searchRetrieve($term, Site $site){
        // If session variable set, set it again for the next page load
        if(Session::has('searchTerm')){
            Session::flash('searchTerm', $term);
        }
        $articles = $site->similarPublicArticles($term);
        return view('articles.index', [
            'articles' => $articles,
            'count' => $articles->total()
        ]);
    }

    // SHOW SINGLE ARTICLE
    public function show(Article $article, Site $site){
        // Increment the number of views
        $article->addView($article);
        
        // Explode this article's tags to an array
        $article->tags = $article->tagsToArrayFromOne($article->tags);

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








    

    




    



    // ARTICLES: INDEX
    public function adminIndex(){
        return view('dashboard.articles.index', [
            'articles' => Site::allArticles(),
        ]);
    }

    // ARTICLES: MINE
    public function mine(){
        return view('dashboard.articles.mine', [
            'articles' => $this->site->myArticles(),
        ]);
    }

    // ARTICLES: INDEX
    public function adminShow(Article $article){
        return view('dashboard.articles.show', [
            'article' => $article,
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
    
        // Save changes to this article
        $this->article->saveText($request);

        return redirect('dashboard/articles/'.$request->hex.'/edit/text')->with('message', 'Aricle text updated!');
    }

    // ARTICLES: EDIT STORAGE
    public function editStorage(Article $article){   
        return view('dashboard.articles.edit-storage', [
            'article' => $article,
            'categories' => Site::publicCategories(),
        ]);
    }

    // ARTICLES: UPDATE STORAGE
    public function updateStorage(Request $request){

        $this->article->saveStorage($request);

        return redirect('dashboard/articles/'.$request->hex.'/edit/storage')->with('message', 'Aricle storage updated!');
    }

    // ARTICLES: EDIT IMAGE
    public function editImage(Article $article){   
        return view('dashboard.articles.edit-image', [
            'article' => $article,
        ]);
    }

    // ARTICLES: UPDATE IMAGE
    public function updateImage(Request $request){
        $this->article->saveImage($request);
        return redirect('dashboard/articles/'.$request->hex.'/edit/image')->with('message', 'Aricle image updated!');
    }

    // ARTICLES: EDIT PUBLISHING
    public function editPublishing(Article $article){   
        return view('dashboard.articles.edit-publishing', [
            'article' => $article,
        ]);
    }

    // ARTICLES: EDIT ASSOCIATIONS
    public function editAssociations(Article $article, Site $site){
        $existing_association_ids = $site->collectionColumnToCsv($article->associations, 'company_id');
        if($existing_association_ids){
            $existing_association_ids = $existing_association_ids.',';
        }
        return view('dashboard.articles.edit-associations', [
            'article' => $article,
            'companies' => $site->allCompanies('trading_name', 'ASC'),
            'existing_associations' => $article->associations,
            'existing_association_ids' => $existing_association_ids
        ]);
    }

    // ARTICLES: UPDADTE ASSOCIATIONS
    public function updateAssociations(Request $request, Article $article, Site $site){
        // Company associations to add
        $company_ids = $site->trimExplodeCsv($request->companies_array);
        // Add associations if they dont already exist
        foreach($company_ids as $key => $company_id){
            if(!empty($company_id)){
                if(Association::where(['company_id' => $company_id, 'article_id' => $article->id])->doesntExist()){
                    $association = [
                        'article_id' => $article->id,
                        'company_id' => $company_id,
                        'user_id' => auth()->user()->id
                    ];
                    Association::create($association);
                }
            }
        }
        // Company association to delete
        $deleted_company_ids = $site->trimExplodeCsv($request->deleted_companies_array);
        // Delete associations if they exist
        foreach($deleted_company_ids as $key => $deleted_company_id){
            if(Association::where(['article_id' => $article->id, 'company_id' => $deleted_company_id])->exists()){
                $association = Association::where(['article_id' => $article->id, 'company_id' => $deleted_company_id]);
                $association->delete();
            }
        }
        // Redirect
        return redirect('/dashboard/articles/'.$article->hex.'/associations')->with('message', 'Associations updated!');
    }

    // ARTICLES: UPDATE PUBLISHING
    public function updatePublishing(Request $request){

        $article = Article::where('hex', $request->hex)->first();
        $article->status = $request->status;
        
        $article->savePublishing();

        return redirect('dashboard/articles/'.$article->hex.'/edit/publishing')->with('message', 'Aricle publishing updated!');
    }

    // ARTICLES: DELETE
    public function destroy(Article $article){

        // Delete article if logged in user is the owner
        if($article->checkOwnerDeleteOrDie($article)){
            return redirect('dashboard/articles')->with('message', 'Article deleted!');
        }
        return redirect('dashboard/articles/'.$article->hex.'/'.$article->slug)->with('staticError', 'You do not have permission to delete this article.');
    }


    
    
}
