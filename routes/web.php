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
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ColorSwatchController;

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

    // Companies: Show all
    Route::get('/dashboard/companies', 'adminIndex');

    // Companies: Search
    Route::get('/dashboard/companies/search/{term}', 'adminSearchRetrieve')->name('adminSearchRetrieve');
    Route::post('/dashboard/companies/search', 'adminSearch');

    // Companies: Create/Store (add a new company)
    Route::get('/dashboard/companies/create', 'create');
    Route::post('dashboard/companies/store', 'store');

    // Companies: Edit publishing information
    Route::get('/dashboard/companies/{company}/edit/publishing-information', 'editPublishingInformation');
    Route::put('/dashboard/companies/update/publishing-information', 'updatePublishingInformation');

    // Companies: Edit rankings
    Route::get('/dashboard/companies/{company}/edit/rankings', 'editRankings');

    // Companies: Edit contacts
    Route::get('/dashboard/companies/{company}/contacts', 'showContacts');
    Route::get('/dashboard/companies/{company}/contacts/create', 'createContact');
    Route::post('/dashboard/companies/{company}/contacts/store', 'storeContact');
    Route::get('/dashboard/companies/{company}/edit/contacts/{contact}', 'editContact');
    Route::put('dashboard/companies/{company}/contacts/update', 'updateContact');
    Route::delete('/dashboard/companies/{company}/contacts/delete', 'destroyContact');

    // Companies: Edit comments
    Route::get('/dashboard/companies/{company}/comments', 'editComments');
    Route::post('/dashboard/companies/{company}/comments/add', 'addComment');
    Route::delete('/dashboard/companies/{company}/comments/delete', 'destroyComment');
    Route::post('/dashboard/companies/{company}/comments/reply', 'replyToComment');

    // Companies: Edit further details
    Route::get('/dashboard/companies/{company}/edit/further-details', 'editFurtherDetails');
    Route::put('/dashboard/companies/update/further-details', 'updateFurtherDetails');

    // Companies: Edit family information
    Route::get('/dashboard/companies/{company}/edit/family-details', 'editFamilyDetails');
    Route::put('/dashboard/companies/update/family-details', 'updateFamilyDetails');

    // Companies: Edit address
    Route::get('/dashboard/companies/{company}/edit/address', 'editAddress');
    Route::put('/dashboard/companies/update/address', 'updateAddress');

    // Companies: Change image 
    Route::get('/dashboard/companies/{company}/edit/image', 'editImage');
    Route::put('/dashboard/companies/update/image', 'updateImage');

    // Companies: Edit storage
    Route::get('/dashboard/companies/{company}/edit/storage', 'editStorage');
    Route::put('/dashboard/companies/update/storage', 'updateStorage');

    // Companies: Edit general
    Route::get('/dashboard/companies/{company}/edit/general', 'editGeneral');
    Route::put('/dashboard/companies/update/general', 'updateGeneral');

    // Companies: Show single company
    Route::get('/dashboard/companies/{company}/{slug}', 'adminShow');
    Route::get('/dashboard/companies/{company}', 'adminShow');
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
    // Admin: Show all
    Route::get('/dashboard/articles', 'adminIndex');

    // Admin: Show logged in user's articles
    Route::get('/dashboard/articles/mine', 'mine');

    // Admin: Create new article
    Route::get('/dashboard/articles/create', 'create');

    // Admin: Store new article
    Route::post('/dashboard/articles/store', 'store');

    // Admin: Edit publishing
    Route::get('/dashboard/articles/{article}/edit/publishing', 'editPublishing');
    Route::put('/dashboard/articles/update/publishing', 'updatePublishing');

    // Admin: Edit image
    Route::get('/dashboard/articles/{article}/edit/image', 'editImage');
    Route::put('/dashboard/articles/update/image', 'updateImage');

    // Admin: Edit storage
    Route::get('/dashboard/articles/{article}/edit/storage', 'editStorage');
    Route::put('/dashboard/articles/update/storage', 'updateStorage');

    // Admin: Edit text
    Route::get('/dashboard/articles/{article}/edit/text', 'editText');
    Route::put('/dashboard/articles/update/text', 'updateText');

    // Admin: Delete article
    Route::DELETE('/dashboard/articles/{article}/delete', 'destroy');
});


// Public routes for ArticleController
Route::controller(ArticleController::class)->group(function(){
    // Public: View all articles
    Route::get('/articles', 'index');

    // Public: View articles with tag
    Route::get('/articles/tags/{term}', 'tags')->name('articlesSearchTagsRetrieve');

    // Public: Search and retrieve article with search term
    Route::get('/articles/search/{term}', 'searchRetrieve')->name('articlesSearchRetrieve');
    Route::post('/articles/search', 'search');

    // Public: Save article like & dislike
    Route::post('/articles/like', 'like');
    Route::post('/articles/unlike', 'unlike');

    // Public: Show single article
    Route::get('/articles/{article}/{slug}', 'show');
    Route::get('/articles/{article}', 'show');

    // Admin: Show single article
    Route::get('/dashboard/articles/{article}', 'adminShow');
    
});



/*
|--------------------------------------------------------------------------
| Routes for CategoryController
|--------------------------------------------------------------------------
*/

// Auth routes for CategoryController
Route::controller(CategoryController::class)->middleware('auth')->group(function(){
    // Admin: Show all
    Route::get('/dashboard/categories', 'adminIndex');

    // Admin: Show logged in user's categories
    Route::get('/dashboard/categories/mine', 'mine');

    // Admin: Create new category
    Route::get('/dashboard/categories/create', 'create');

    // Admin: Store new category
    Route::post('/dashboard/categories/store', 'store');        

    // Admin: Edit publishing
    Route::get('/dashboard/categories/{category}/edit/publishing', 'editPublishing');
    Route::put('/dashboard/categories/update/publishing', 'updatePublishing');

    // Admin: Edit image
    Route::get('/dashboard/categories/{category}/edit/image', 'editImage');
    Route::put('/dashboard/categories/update/image', 'updateImage');

    // Admin: Edit text
    Route::get('/dashboard/categories/{category}/edit/text', 'editText');
    Route::put('/dashboard/categories/update/text', 'updateText');

    // Admin: Delete
    Route::delete('/dashboard/categories/{category}/delete', 'destroy');

    // Admin: Show single category
    Route::get('/dashboard/categories/{category}', 'adminShow');
});

// Public routes for CategoryController
Route::controller(CategoryController::class)->group(function(){
    Route::get('/categories/test', 'test');
    
    Route::get('/categories', 'index')->name('categories');
    Route::get('/categories/{category:slug}', 'show');
});



/*
|--------------------------------------------------------------------------
| Routes for IndustryController
|--------------------------------------------------------------------------
*/

// Auth routes for IndustryController
Route::controller(IndustryController::class)->middleware('auth')->group(function(){
    // Admin: Show all
    Route::get('/dashboard/industries', 'adminIndex');

    // Admin: Show logged in user's industries
    Route::get('/dashboard/industries/mine', 'mine');

    // Admin: Create new industry
    Route::get('/dashboard/industries/create', 'create');

    // Admin: Store new industry
    Route::post('/dashboard/industries/store', 'store');
    
    // Admin: Store new industry
    Route::get('/dashboard/industries/{industry}/edit', 'edit');
    
    // Admin: Store new industry
    Route::PUT('/dashboard/industries/update', 'update');

    // Admin: Store new industry
    Route::DELETE('/dashboard/industries/{industry}/delete', 'destroy');

    // Admin: Store new industry
    Route::get('/dashboard/industries/{industry}', 'adminShow');
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
| Routes for ColorSwatchController
|--------------------------------------------------------------------------
*/

// All dashboard routes must be authenticated
Route::controller(ColorSwatchController::class)->middleware('auth')->group(function(){
    // Color swatches: Show all
    Route::get('/dashboard/color-swatches', 'adminIndex');

    // Color swatches: Create new swatch
    Route::get('/dashboard/color-swatches/create', 'create');

    // Color swatches: Store new swatch
    Route::post('/dashboard/color-swatches/store', 'store');

    // Color swatches: Use this swatch
    Route::get('/dashboard/color-swatches/{color_swatch}/use', 'use');

    // Color swatches: Edit swatch
    Route::get('/dashboard/color-swatches/{color_swatch}/edit', 'edit');

    // Color swatches: Update swatch
    Route::put('/dashboard/color-swatches/update', 'update');

    // Color swatches: Delete swatch
    Route::delete('/dashboard/color-swatches/{color_swatch}/delete', 'destroy');

    // Color swatches: Show single swatch
    Route::get('/dashboard/color-swatches/{color_swatch}', 'adminShow');
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
