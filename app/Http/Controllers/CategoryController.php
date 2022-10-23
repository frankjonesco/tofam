<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends BaseController
{

    private $article;

    public function __construct()
    {
        
    }
    
    // SHOW ALL CATEGOIES
    public function index(){
        return view('categories.index', [
            'categories' => Category::getPublicCategories()
        ]);
    }

    // Show single category
    public function show(Category $category){
        return view('categories.show', [
            'category' => $category,
            'articles' => Category::getPublicArticlesExplodeTags($category)
        ]);
    }

    // Show form for create a category
    public function create(){
        return view('dashboard.categories.create');
    }

    // Store category in database
    public function store(Request $request){
        // Validate form fields
        $formFields = $request->validate([
            'name' => 'required',
            'status' => 'required'
        ]);

        $formFields['description'] = $request->description;

        // Generate a random hex that does not already exist
        $hex = Str::random(11);
        while(Category::where('hex', $hex)->exists()){
            $hex = Str::random(11);
        }

        $formFields = [
            'hex' => $hex, 
            'user_id' => User::pluck('id')->random(),
            'name' => ucfirst($formFields['name']),
            'slug' => Str::slug($formFields['name']),
            'description' => $formFields['description'],
            'color' => DB::table('colors')->orderBy(DB::raw('RAND()'))->first()->id,
            'status' => $formFields['status']
        ];

        Category::create($formFields);

        return redirect('categories')->with('message', 'Category created!');
    }

    // Show form for edit category
    public function edit(Category $category){
        return view('dashboard.categories.edit', [
            'category' => $category
        ]);
    }

    // Update category
    public function update(Category $category, Request $request){

        // Validate form
        $formFields = $request->validate([
            'name' => 'required',
            'status' => 'required'
        ]);

        $formFields['description'] = $request->description;

        $formFields = [
            'user_id' => User::pluck('id')->random(),
            'name' => ucfirst($formFields['name']),
            'slug' => Str::slug($formFields['name']),
            'description' => $formFields['description'],
            'status' => $formFields['status']
        ];

        $category->update($formFields);

        return redirect('categories')->with('message', 'Category updated!');

    }

    // Delete category
    public function destroy(Category $category){
        $category->delete();
        return redirect('categories')->with('message', 'Category deleted!');
    }
}
