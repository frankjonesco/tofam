<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    // Show all categories
    public function index(){

        $categories = Category::where('status', 'public')->orderBy('name', 'asc')->get();

        foreach($categories as $key => $category){
            $articles = Article::where('category_id', $category->id)->count();
            $categories[$key]['articles'] = $articles;
            $categories[$key]['color'] = DB::table('colors')->find($category->color)->color;
        }

        return view('categories.index', [
            'categories' => $categories
        ]);
    }

    // Show single category
    public function show(Category $category){
        return view('categories.show', [
            'category' => $category,
            'articles' => Article::where('category_id', $category->id)->get()
        ]);
    }

    // Show form for create a category
    public function create(){
        return view('dashboard.categories.create');
    }

    // Store category in database
    public function store(Request $request){

        // Validate the form
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
