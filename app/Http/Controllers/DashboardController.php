<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Color;
use App\Models\Config;
use App\Models\Article;
use App\Models\Company;
use App\Models\Category;
use App\Models\Industry;
use App\Rules\SoftUrlRule;
use App\Models\ColorSwatch;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{

    private $site;
    private $category;
    private $article;
    private $company;

    public function __contruct(Site $site, Category $category, Article $article, Company $company)
    {
        $this->site = $site;
        $this->category = $category;
        $this->article = $article;
        $this->company = $company;
    }

    
    // View dashboard
    public function index(){
        if(!auth()->id()){
            return redirect('login')->with('staticAlert', config('global.messages.unauthorized'));
        }

        return view('dashboard.index');
    }

    // Show create user form
    public function createUser(){
        return view('dashboard.users.create');
    }

    // Format size units
    function formatSizeUnits($bytes)
        {
            if ($bytes >= 1073741824)
            {
                $bytes = number_format($bytes / 1073741824, 2) . ' GB';
            }
            elseif ($bytes >= 1048576)
            {
                $bytes = number_format($bytes / 1048576, 2) . ' MB';
            }
            elseif ($bytes >= 1024)
            {
                $bytes = number_format($bytes / 1024, 2) . ' KB';
            }
            elseif ($bytes > 1)
            {
                $bytes = $bytes . ' bytes';
            }
            elseif ($bytes == 1)
            {
                $bytes = $bytes . ' byte';
            }
            else
            {
                $bytes = '0 bytes';
            }

            return $bytes;
    }

    // Check images
    public function checkImages(Site $site){

        $articles = $site->allArticles();

        foreach($articles as $key => $article){
            if($article['image']){
                $directory_path = public_path('images/articles/'.$article['hex'].'/'.$article['image']);
                $articles[$key]['image_size'] = File::size($directory_path);
                if($articles[$key]['image_size'] > 500000){
                    // echo self::formatSizeUnits($articles[$key]['image_size']).'<br>';
                }
            }
        }

        return view('dashboard.image-stuff');

    
    }

    public function cropIndex()
    {
      return view('croppie');
    }
   
    public function uploadCropImage(Request $request)
    {
        $image = $request->image;

        list($type, $image) = explode(';', $image);
        list(, $image)      = explode(',', $image);
        $image = base64_decode($image);
        $image_name= time().'.png';
        $path = public_path('upload/'.$image_name);

        file_put_contents($path, $image);
        return response()->json(['status'=>true]);
    }



    



    



    







    // COMPANIES: INDEX
    public function companiesIndex(){
        return view('dashboard.companies.index', [
            'companies' => Company::orderBy('registered_name', 'ASC')->get() 
        ]);
    }

    // COMPANIES: SEARCH
    public function companiesSearch(Request $request){
        Session::flash('searchTerm', $request->search);
        return redirect('dashboard/companies/search/'.$request->search);
    }

    // COMPANIES: SHO SINGLE COMPANY
    public function companiesShow(Company $company){
        return view('dashboard.companies.show', [
            'company' => $company
        ]);
    }

    // COMPANIES: SEARCH RETRIEVE
    public function companiesSearchRetrieve($term){
        if(Session::has('searchTerm')){
            Session::flash('searchTerm', $term);
        }
        $companies = Company::where('registered_name', 'like', '%'.$term.'%')
            ->orWhere('trading_name', 'like', '%'.$term.'%')->paginate(10);
        

        return view('dashboard.companies.index', [
            'companies' => $companies,
            'count' => $companies->total()
        ]);
    }

    // COMPANIES: CREATE
    public function companiesCreate(){
        return view('dashboard.companies.create');
    }

    // COMPANIES: STORE
    public function companiesStore(Request $request){
        $company = $request->validate([
            'registered_name' => 'required'
        ]);
        
        $site = new Site();
        $company = new Company();

        $company->hex = $site->uniqueHex('companies');
        $company->user_id = auth()->user()->id;
        $company->registered_name = $request->registered_name;
        $company->trading_name = $request->trading_name;

        $slug = $company->trading_name ?? $company->registered_name;
        $company->slug = Str::slug($slug);

        $company->parent_organization = $request->parent_organization;
        $company->description = $request->description;
        $company->website = $request->website;
        $company->founded_in = $request->founded_in;
        $company->founded_by = $request->founded_by;
        $company->headquarters = $request->headquarters;
        $company->address_building_name = $request->address_building_name;
        $company->address_number = $request->trading_name;
        $company->address_street = $request->address_street;
        $company->address_city = $request->address_city;
        $company->address_state = $request->address_state;
        $company->address_zip = $request->address_zip;
        $company->address_phone = $request->address_phone;
        $company->family_business = $request->family_business;
        $company->family_name = $request->family_name;
        $company->family_generations = $request->family_generations;
        $company->family_executive = $request->family_executive;
        $company->female_executive = $request->female_executive;
        $company->matchbird_partner = $request->matchbird_partner;

        $company->save();

        return redirect('dashboard/companies');
    }

    // COMPANIES: EDIT GENERAL
    public function companiesEditGeneral(Company $company){   
        return view('dashboard.companies.edit-general', [
            'company' => $company
        ]);
    }

    // COMPANIES: EDIT STORAGE
    public function companiesEditStorage(Company $company){   
        return view('dashboard.companies.edit-storage', [
            'company' => $company,
            'categories' => Category::orderBy('id', 'ASC')->get(),
            'industries' => Industry::orderBy('name', 'ASC')->get(),
            'existing_categories' => $company->getCategories($company->category_ids),
            'existing_industries' => $company->getIndustries($company->industry_ids)
        ]);
    }

    // COMPANIES: EDIT IMAGE
    public function companiesEditImage(Company $company){   
        return view('dashboard.companies.edit-image', [
            'company' => $company
        ]);
    }

    // COMPANIES: EDIT ADDRESS
    public function companiesEditAddress(Company $company){   
        return view('dashboard.companies.edit-address', [
            'company' => $company
        ]);
    }

    // COMPANIES: EDIT FAMILY
    public function companiesEditFamily(Company $company){   
        return view('dashboard.companies.edit-family', [
            'company' => $company
        ]);
    }

    // COMPANIES: EDIT DETAILS
    public function companiesEditDetails(Company $company){   
        return view('dashboard.companies.edit-details', [
            'company' => $company
        ]);
    }

    // COMPANIES: EDIT PUBLISHING
    public function companiesEditPublishing(Company $company){   
        return view('dashboard.companies.edit-publishing', [
            'company' => $company
        ]);
    }

    // COMPANIES: UPDATE GENERAL
    public function companiesUpdateGeneral(Request $request){
        
        $form_data = $request->validate([
            'registered_name' => 'required',
            'website' => [new SoftUrlRule],
        ]);

        $company = Company::where('hex', $request->hex)->first();
        $company->registered_name = $request->registered_name;
        $company->trading_name = $request->trading_name;
        $company->parent_organization = $request->parent_organization;
        $company->website = $request->website;
        $company->description = $request->description;
        $company->founded_in = $request->founded_in;
        $company->founded_by = $request->founded_by;
        $company->headquarters = $request->headquarters;

        $company->save();

        return redirect('dashboard/companies/'.$company->hex.'/'.$company->slug)->with('message', 'Company general information updated!');
    }

    // COMPANIES: UPDADTE STORAGE
    public function companiesUpdateStorage(Request $request){
        $new_category_ids = [];        
        $categories = $request->categories_array;

        $category_ids = explode(',', $categories);
        foreach($category_ids as $category_id){
            $category = Category::where('id', $category_id)->first();
            if($category){
                $new_category_ids[] = $category->id;
            }
        }
        if(count($new_category_ids) > 0){
            $new_category_ids = implode(',', $new_category_ids);
        }
        else{
            $new_category_ids = null;
        }  


        $new_industry_ids = [];        
        $industries = $request->industries_array;

        $industry_ids = explode(',', $industries);
        foreach($industry_ids as $industry_id){
            $industry = Industry::where('id', $industry_id)->first();
            if($industry){
                $new_industry_ids[] = $industry->id;
            }
        }
        if(count($new_industry_ids) > 0){
            $new_industry_ids = implode(',', $new_industry_ids);
        }
        else{
            $new_industry_ids = null;
        }  
        

        $company = Company::where('hex', $request->hex)->first();
        $company->category_ids = $new_category_ids;
        $company->industry_ids = $new_industry_ids;
        $company->save();

        // dd($company->hex);

        return redirect('/dashboard/companies/'.$company->hex.'/edit/storage')->with('message', 'Company storage udated!');
        
    }

    // COMPANIES: UPDATE IMAGE
    public function companiesUpdateImage(Request $request){
        $site = new Site();
        $company = Company::where('hex', $request->hex)->first();
        $company->image = $site->handleImageUpload($request, 'companies', $company->hex);
        $company->save();
        return redirect('dashboard/companies/'.$company->hex.'/'.$company->slug)->with('message', 'Company image updated!');
    }

    // COMPANIES: UPDATE ADDRESS
    public function companiesUpdateAddress(Request $request){

        $company = Company::where('hex', $request->hex)->first();
        $company->address_building_name = $request->address_building_name;
        $company->address_number = $request->address_number;
        $company->address_street = $request->address_street;
        $company->address_city = $request->address_city;
        $company->address_state = $request->address_state;
        $company->address_zip = $request->address_zip;
        $company->address_phone = $request->address_phone;

        $company->save();

        return redirect('dashboard/companies/'.$company->hex.'/'.$company->slug)->with('message', 'Company address updated!');
    }

    // COMPANIES: UPDATE FAMILY
    public function companiesUpdateFamily(Request $request){

        $company = Company::where('hex', $request->hex)->first();
        $company->family_business = $request->family_business;
        $company->family_name = $request->family_name;
        $company->family_generations = $request->family_generations;
        $company->family_executive = $request->family_executive;

        $company->save();

        return redirect('dashboard/companies/'.$company->hex.'/'.$company->slug)->with('message', 'Company family information updated!');
    }

    // COMPANIES: UPDATE DETAILS
    public function companiesUpdateDetails(Request $request){
        
        $company = Company::where('hex', $request->hex)->first();
        $company->female_executive = $request->female_executive;
        $company->stock_listed = $request->stock_listed;
        $company->matchbird_partner = $request->matchbird_partner;

        $company->save();

        return redirect('dashboard/companies/'.$company->hex.'/'.$company->slug)->with('message', 'Company further detils updated!');
    }

    // COMPANIES: UPDATE PUBLISHING
    public function companiesUpdatePublishing(Request $request){
        
        $company = Company::where('hex', $request->hex)->first();
        $company->force_slug = Str::slug($request->force_slug);
        $company->tofam_status = $request->tofam_status;
        $company->status = $request->status;

        $company->save();

        return redirect('dashboard/companies/'.$company->hex.'/edit/publishing')->with('message', 'Company publishing information updated!');

    }



    
}
