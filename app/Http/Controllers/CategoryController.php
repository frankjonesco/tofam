<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends BaseController
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
            'articles' => Category::getPublicArticlesExplodeTags($category)
        ]);
    }


    // SHOW CREATE ARTICLE FORM
    public function create(){
        return view('dashboard.categories.create');
    }


    // STORE CATEGORY
    public function store(Request $request, Category $category){
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
    public function edit(Category $category){
        return view('dashboard.categories.edit', [
            'category' => $category
        ]);
    }


    // UPDATE CATEGORY
    public function update(Request $request, Category $category){
        // Validate form fields
       $request->validate([
            'name' => 'required',
            'status' => 'required'
        ]);

        // Save changes to this category
        $category->saveCategory($request, $category);

        return redirect('categories')->with('message', 'Category updated!');
    }


    // DELETE CATEGORY
    public function destroy(Category $category){
        $category->delete();
        return redirect('categories')->with('message', 'Category deleted!');
    }
}
