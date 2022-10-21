<?php

use App\Models\Article;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
|--------------------------------------------------------------------------
| Routes for SiteController
|--------------------------------------------------------------------------
*/

// Public routes for SiteController
Route::controller(SiteController::class)->group(function(){
    Route::get('/', 'home')->name('home');
    Route::get('/tags/{term}', 'tags');
    Route::get('/search/{term}', 'searchRetrieve');
    Route::post('/search', 'search');

    Route::get('/json', 'json');
});

/*
|--------------------------------------------------------------------------
| Routes for ArticleController
|--------------------------------------------------------------------------
*/

// Auth routes for ArticleController
Route::controller(ArticleController::class)->middleware('auth')->group(function() {
    Route::get('/articles/create', 'create');
    Route::post('/articles/store', 'store');
    Route::get('/articles/{article}/edit', 'edit');
    Route::put('/articles/{article}/update', 'update');
    Route::delete('/articles/{article}/delete', 'destroy');
});

// Public routes for ArticleController
Route::controller(ArticleController::class)->group(function(){
    Route::get('/articles', 'index');
    Route::get('/articles/{article}/{slug}', 'show');
});

/*
|--------------------------------------------------------------------------
| Routes for CategoryController
|--------------------------------------------------------------------------
*/

// Auth routes for CategoryController
Route::controller(CategoryController::class)->middleware('auth')->group(function(){
    Route::get('/categories/create', 'create');
    Route::post('/categories/store', 'store');
    Route::get('categories/{categoy}/edit', 'edit');
    Route::put('/categories/{category}/update', 'update');
    Route::delete('/categories/{category}/delete', 'destroy');
});

// Public routes for CategoryController
Route::controller(CategoryController::class)->group(function(){
    Route::get('/categories', 'index')->name('categories');
    Route::get('categories/{category:slug}', 'show');
});

/*
|--------------------------------------------------------------------------
| Routes for UserController
|--------------------------------------------------------------------------
*/

// Auth routes for UserController
Route::controller(UserController::class)->middleware('auth')->group(function(){
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/logout', 'logout');
    
});

// Guest routes for UserController
Route::controller(UserController::class)->middleware('guest')->group(function(){
    Route::get('/register', 'create')->name('register');
    Route::post('/users/create', 'store');
    Route::get('/login', 'login')->name('login');
    Route::post('/users/authenticate', 'authenticate');
});

// Public routes for UserController
Route::controller(UserController::class)->group(function(){
    Route::get('/users', 'index');
});

/*
|--------------------------------------------------------------------------
| Routes for DashboardController
|--------------------------------------------------------------------------
*/

// All dashboard routes must be authenticated
Route::controller(DashboardController::class)->middleware('auth')->group(function(){
    Route::get('/dashboard', 'index');
    Route::get('/dashboard/users/create', 'createUser');
});




