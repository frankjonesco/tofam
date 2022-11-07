<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    private $site;
    private $category;

    public function __construct(Site $site, Category $category)
    {
        $this->site = $site;
        $this->category = $category;
    }

    
    // SHOW ALL CATEGOIES
    public function index(){
        return view('categories.index', [
            'categories' => Site::publicCategories()
        ]);
    }


    // SHOW SINGLE CATEGORY
    public function show(Category $category){
        return view('categories.show', [
            'category' => $category,
            'articles' => $category->publicArticles()
        ]);
    }


    // SHOW CREATE ARTICLE FORM
    public function createOld(){
        return view('dashboard.categories.create');
    }


    // STORE CATEGORY
    public function storeOld(Request $request, Category $category){
        // Validate form fields
        $request->validate([
            'name' => 'required',
            'status' => 'required'
        ]);

        // Create category
        $category->createCategory($request, $category);

        return redirect('categories')->with('message', 'Category created!');
    }


    // SHOW CATEGORY EDIT FORM
    public function editOld(Category $category){
        return view('dashboard.categories.edit', [
            'category' => $category
        ]);
    }


    // UPDATE CATEGORY
    public function updateOld(Request $request, Category $category){
        // Validate form fields
       $request->validate([
            'name' => 'required',
            'status' => 'required'
        ]);

        // Save changes to this category
        $category->saveCategory($request, $category);

        return redirect('categories')->with('message', 'Category updated!');
    }


    





    // ADMIN: INDEX
    public function adminIndex(){
        return view('dashboard.categories.index', [
            'categories' => Site::allCategories()
        ]);
    }

    // ADMIN: MINE
    public function mine(){
        return view('dashboard.categories.index', [
            'categories' => Site::myCategories()
        ]);
    }

    // ADMIN: SHOW
    public function adminShow(Category $category){
        return view('dashboard.categories.show', [
            'category' => $category,
        ]);
    }

    // ADMIN: CREATE
    public function create(){
        return view('dashboard.categories.create');
    }

    // ADMIN: STORE
    public function store(Request $request, Category $category){

        $request->validate([
            'name' => 'required',
        ]);

        $category = $category->createCategory($request);

        return redirect('dashboard/categories/'.$category->hex.'/edit/text')->with('message', 'New category created!');
    }

    // ADMIN: EDIT TEXT
    public function editText(Category $category){
        return view('dashboard.categories.edit-text', [
            'category' => $category
        ]);
    }

    // ADMIN: UPDATE TEXT
    public function updateText(Request $request, Category $category){
        
        // Validate form fields 
        $request->validate([
            'name' => 'required',
        ]);

        $category = $category->saveText($request);

        return redirect('dashboard/categories/'.$category->hex.'/edit/text')->with('message', 'Category text updated!');
    }

    // ADMIN: EDIT IMAGE
    public function editImage(Category $category){   
        return view('dashboard.categories.edit-image', [
            'category' => $category,
        ]);
    }

    // ADMIN: UPDATE IMAGE
    public function updateImage(Request $request, Category $category){

        $category = $category->saveImage($request);

        return redirect('dashboard/categories/'.$category->hex.'/edit/image')->with('message', 'Category image updated!');
    }

    // ADMIN: UPDATE PUBLISHING
    public function updatePublishing(Request $request, Category $category){

        $category = $category->savePublishing($request);

        return redirect('dashboard/categories/'.$category->hex.'/edit/publishing')->with('message', 'Category publishing updated!');
    }

    // ADMIN: EDIT PUBLISHING
    public function editPublishing(Category $category){   
        return view('dashboard.categories.edit-publishing', [
            'category' => $category,
        ]);
    }

    // ADMIN: DELETE
    public function destroy(Category $category){
        $category->delete();
        return redirect('categories')->with('message', 'Category deleted!');
    }
}
