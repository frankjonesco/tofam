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
});

/*
|--------------------------------------------------------------------------
| Routes for ArticleController
|--------------------------------------------------------------------------
*/

// Auth routes for ArticleController
Route::controller(ArticleController::class)->middleware('auth')->group(function() {
    Route::get('/dashboard/articles/create', 'create');
    Route::post('/dashboard/articles/store', 'store');
    Route::get('/dashboard/articles/{article}/edit', 'edit');
    Route::put('/dashboard/articles/{article}/update', 'update');
    Route::delete('/dashboard/articles/{article}/delete', 'destroy');
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
    Route::get('/dashboard/categories/create', 'create');
    Route::post('/dashboard/categories/store', 'store');
    Route::get('/dashboard/categories/{category}/edit', 'edit');
    Route::put('/dashboard/categories/{category}/update', 'update');
    Route::delete('/dashboard/categories/{category}/delete', 'destroy');
});

// Public routes for CategoryController
Route::controller(CategoryController::class)->group(function(){
    Route::get('/categories/test', 'test');
    
    Route::get('/categories', 'index')->name('categories');
    Route::get('/categories/{category:slug}', 'show');
});

/*
|--------------------------------------------------------------------------
| Routes for UserController
|--------------------------------------------------------------------------
*/

// Auth routes for UserController
Route::controller(UserController::class)->middleware('auth')->group(function(){
    Route::get('/dashboard/users/create', 'create');
    Route::post('/dashboard/users/store', 'store');
    Route::get('/dashboard/users/{user}/edit', 'edit');
    Route::put('/dashboard/users/{user}/update', 'update');
    Route::get('/dashboard/users/{user}/password', 'editPassword');
    Route::put('/dashboard/users/{user}/password', 'updatePassword');
    Route::delete('/dashboard/users/{user}/delete', 'destroy');
    Route::post('/logout', 'logout');
});

// Guest routes for UserController
Route::controller(UserController::class)->middleware('guest')->group(function(){
    Route::get('/register', 'register')->name('register');
    Route::post('/users/create', 'storeRegistration');
    Route::get('/login', 'login')->name('login');
    Route::post('/users/authenticate', 'authenticateLogin');
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
    Route::get('/dashboard', 'index')->name('dashboard');
});
