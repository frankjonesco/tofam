<?php

use App\Models\Article;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProfileController;
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
    Route::get('/terms', 'showTerms');
    Route::get('/privacy', 'showPrivacy');
    Route::get('/about', 'showAbout');
    Route::get('/contact', 'showContact');
});

/*
|--------------------------------------------------------------------------
| Routes for CompanyController
|--------------------------------------------------------------------------
*/

// Auth routes for CompanyController
Route::controller(CompanyController::class)->middleware('auth')->group(function() {

});

// Public routes for ArticleController
Route::controller(CompanyController::class)->group(function(){
    Route::get('/companies', 'index');
    Route::get('/companies/search/{term}', 'searchRetrieve')->name('companiesSearchRetrieve');
    Route::post('/companies/search', 'search');
    Route::get('/companies/{company}/{slug}', 'show');
});

/*
|--------------------------------------------------------------------------
| Routes for ArticleController
|--------------------------------------------------------------------------
*/

// Auth routes for ArticleController
Route::controller(ArticleController::class)->middleware('auth')->group(function() {

});

// Public routes for ArticleController
Route::controller(ArticleController::class)->group(function(){
    Route::get('/articles', 'index');
    Route::get('/articles/tags/{term}', 'tags');
    Route::get('/articles/search/{term}', 'searchRetrieve')->name('articlesSearchRetrieve');
    Route::post('/articles/search', 'search');
    Route::post('/articles/like', 'like');
    Route::post('/articles/unlike', 'unlike');
    Route::get('/articles/{article}/{slug}', 'show');
    Route::get('/articles/{article}', 'show');
});

/*
|--------------------------------------------------------------------------
| Routes for CategoryController
|--------------------------------------------------------------------------
*/

// Auth routes for CategoryController
Route::controller(CategoryController::class)->middleware('auth')->group(function(){
    
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
    Route::post('/users/store', 'storeRegistration');
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
    
    
    // DASHBOARD

        // Dashboard: Index
        Route::get('/dashboard', 'index')->name('dashboard');



    // DASHBOARD: COLOR SWATCHES

        // Color swatches: Show all
        Route::get('/dashboard/color-swatches', 'colorSwatchIndex');

        // Color swatches: Create new swatch
        Route::get('/dashboard/color-swatches/create', 'colorSwatchCreate');

        // Color swatches: Store new swatch
        Route::post('/dashboard/color-swatches/store', 'colorSwatchStore');

        // Color swatches: Show single swatch
        Route::get('/dashboard/color-swatches/{hex}', 'colorSwatchShow');

        // Color swatches: Use this swatch
        Route::get('/dashboard/color-swatches/{hex}/use', 'colorSwatchUse');

        // Color swatches: Edit swatch
        Route::get('/dashboard/color-swatches/{hex}/edit', 'colorSwatchEdit');

        // Color swatches: Update swatch
        Route::put('/dashboard/color-swatches/{hex}/update', 'colorSwatchUpdate');

        // Color swatches: Delete swatch
        Route::delete('/dashboard/color-swatches/{hex}/delete', 'colorSwatchDestroy');



    // DASHBOARD: CATEGORES

        // Categories: Show all
        Route::get('/dashboard/categories', 'categoriesIndex');

        // Categories: Show logged in user's categories
        Route::get('/dashboard/categories/mine', 'categoriesMine');

        // Categories: Create new category
        Route::get('/dashboard/categories/create', 'categoriesCreate');

        // Categories: Store new category
        Route::post('/dashboard/categories/store', 'categoriesStore');        

        // Categories: Edit publishing
        Route::get('/dashboard/categories/{category}/edit/publishing', 'categoriesEditPublishing');
        Route::put('/dashboard/categories/update/publishing', 'categoriesUpdatePublishing');

        // Categories: Edit image
        Route::get('/dashboard/categories/{category}/edit/image', 'categoriesEditImage');
        Route::put('/dashboard/categories/update/image', 'categoriesUpdateImage');

        // Categories: Delete
        Route::delete('/dashboard/categories/{category}/delete', 'categoryDestroy');

        // Categories: Edit text
        Route::get('/dashboard/categories/{category}/edit/text', 'categoriesEditText');
        Route::put('/dashboard/categories/update/text', 'categoriesUpdateText');

        // Categories: Show single category
        Route::get('/dashboard/categories/{category}', 'categoriesShow');



    // DASHBOARD: INDUSTRIES

        // Industries: Show all
        Route::get('/dashboard/industries', 'industriesIndex');

        // Industries: Show logged in user's industries
        Route::get('/dashboard/industries/mine', 'industriesMine');

        // Industries: Create new industry
        Route::get('/dashboard/industries/create', 'industriesCreate');

        // Industries: Store new industry
        Route::post('/dashboard/industries/store', 'industriesStore'); 

        // Industries: Edit
        Route::get('/dashboard/industries/{industry}/edit', 'industriesEdit');

        // Industries: Update
        Route::put('/dashboard/industries/update', 'industriesUpdate');



    // DASHBOARD: ARTICLES

        // Articles: Show all
        Route::get('/dashboard/articles', 'articlesIndex');

        // Articles: Show logged in user's articles
        Route::get('/dashboard/articles/mine', 'articlesMine');

        // Articles: Create new article
        Route::get('/dashboard/articles/create', 'articlesCreate');

        // Articles: Store new article
        Route::post('/dashboard/articles/store', 'articlesStore');

        // Articles: Edit publishing
        Route::get('/dashboard/articles/{article}/edit/publishing', 'articlesEditPublishing');
        Route::put('/dashboard/articles/update/publishing', 'articlesUpdatePublishing');

        // Articles: Edit image
        Route::get('/dashboard/articles/{article}/edit/image', 'articlesEditImage');
        Route::put('/dashboard/articles/update/image', 'articlesUpdateImage');

        // Articles: Edit storage
        Route::get('/dashboard/articles/{article}/edit/storage', 'articlesEditStorage');
        Route::put('/dashboard/articles/update/storage', 'articlesUpdateStorage');

        // Articles: Edit text
        Route::get('/dashboard/articles/{article}/edit/text', 'articlesEditText');
        Route::put('/dashboard/articles/update/text', 'articlesUpdateText');

    

    //  DASHBOARD: COMPANIES

        // Companies: Show all
        Route::get('/dashboard/companies', 'companiesIndex');

        // Companies: Search
        Route::get('/dashboard/companies/search/{term}', 'companiesSearchRetrieve')->name('dashboardSearchRetrieve');
        Route::post('/dashboard/companies/search', 'companiesSearch');

        // Companies: Create/Store (add a new company)
        Route::get('/dashboard/companies/create', 'companiesCreate');
        Route::post('dashboard/companies/store', 'companiesStore');

        // Companies: Edit publishing
        Route::get('/dashboard/companies/{company}/edit/publishing', 'companiesEditPublishing');
        Route::put('/dashboard/companies/update/publishing', 'companiesUpdatePublishing');

        // Companies: Edit further details
        Route::get('/dashboard/companies/{company}/edit/details', 'companiesEditDetails');
        Route::put('/dashboard/companies/update/details', 'companiesUpdateDetails');

        // Companies: Edit family information
        Route::get('/dashboard/companies/{company}/edit/family', 'companiesEditFamily');
        Route::put('/dashboard/companies/update/family', 'companiesUpdateFamily');

        // Companies: Edit address
        Route::get('/dashboard/companies/{company}/edit/address', 'companiesEditAddress');
        Route::put('/dashboard/companies/update/address', 'companiesUpdateAddress');

        // Companies: Change image 
        Route::get('/dashboard/companies/{company}/edit/image', 'companiesEditImage');
        Route::put('/dashboard/companies/update/image', 'companiesUpdateImage');

        // Companies: Edit storage
        Route::get('/dashboard/companies/{company}/edit/storage', 'companiesEditStorage');
        Route::put('/dashboard/companies/update/storage', 'companiesUpdateStorage');

        // Companies: Edit general
        Route::get('/dashboard/companies/{company}/edit/general', 'companiesEditGeneral');
        Route::put('/dashboard/companies/update/general', 'companiesUpdateGeneral');

        // Companies: Show single company
        Route::get('/dashboard/companies/{company}', 'companiesShow');

});

/*
|--------------------------------------------------------------------------
| Routes for ProfileController
|--------------------------------------------------------------------------
*/

// All profile routes must be authenticated
Route::controller(ProfileController::class)->middleware('auth')->group(function(){
    Route::get('/profile', 'show');
});




/*
|--------------------------------------------------------------------------
| Routes for Sandbox Stuff
|--------------------------------------------------------------------------
*/
// Route::get('crop-image', [DashboardController::class, 'cropIndex']);
// Route::post('crop-image', [DashboardController::class, 'uploadCropImage'])->name('croppie.upload-image');
Route::get('/sidebar1', [SiteController::class, 'sidebarOne']);
Route::get('/empty', [SiteController::class, 'emptyPage']);
