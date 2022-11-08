<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Company;
use App\Models\Category;
use App\Models\Industry;
use App\Rules\SoftUrlRule;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CompanyController extends Controller
{
    // Show all companies
    public function index(){
        return view('companies.index', [
            'companies' => Company::orderBy('registered_name', 'ASC')->paginate(12)
        ]);
    }

    public function search(Request $request){
        Session::flash('searchTerm', $request->search);
        return redirect('companies/search/'.$request->search);
    }

    public function searchRetrieve($term){
        if(Session::has('searchTerm')){
            Session::flash('searchTerm', $term);
        }
        $companies = Company::where('registered_name', 'like', '%'.$term.'%')
            ->orWhere('trading_name', 'like', '%'.$term.'%')
            ->where('status', 'public')
            ->paginate(12);

        return view('companies.index', [
            'companies' => $companies,
            'count' => $companies->total()
        ]);
    }

    // Show single company
    public function show(Company $company, $hex = null){
        return view('companies.show', [
            'company' => $company
        ]);
    }







    // ADMIN: INDEX
    public function adminIndex(Site $site){
        return view('dashboard.companies.index', [
            'companies' => $site->allCompanies() 
        ]);
    }

    // ADMIN: SEARCH
    public function adminSearch(Request $request){
        Session::flash('searchTerm', $request->search);
        return redirect('dashboard/companies/search/'.$request->search);
    }

    // ADMIN: SEARCH RETRIEVE
    public function adminSearchRetrieve($term, Site $site){
        if(Session::has('searchTerm')){
            Session::flash('searchTerm', $term);
        }
        $companies = $site->allSimilarCompanies($term);
        return view('dashboard.companies.index', [
            'companies' => $companies,
            'count' => $companies->total()
        ]);
    }

    // ADMIN: SHOW SINGLE COMPANY
    public function adminShow(Company $company){
        return view('dashboard.companies.show', [
            'company' => $company
        ]);
    }

    // ADMIN: CREATE
    public function create(){
        return view('dashboard.companies.create');
    }

    // ADMIN: STORE
    public function store(Request $request, Company $company){
        $request->validate([
            'registered_name' => 'required'
        ]);
        $company = $company->createCompany($request);
        return redirect('dashboard/companies/'.$company->hex);
    }

    // ADMIN: EDIT GENERAL
    public function editGeneral(Company $company){   
        return view('dashboard.companies.edit-general', [
            'company' => $company
        ]);
    }

    // ADMIN: UPDATE GENERAL
    public function updateGeneral(Request $request, Site $site){
        $company = $site->getCompany($request->hex);
        $request->validate([
            'registered_name' => 'required',
            'website' => [new SoftUrlRule],
        ]);
        $company = $company->saveGeneral($request);
        return redirect('dashboard/companies/'.$company->hex.'/'.$company->slug)->with('message', 'Company general information updated!');
    }

    // ADMIN: EDIT STORAGE
    public function editStorage(Company $company, Site $site){   
        return view('dashboard.companies.edit-storage', [
            'company' => $company,
            'categories' => Category::orderBy('id', 'ASC')->get(),
            'industries' => Industry::orderBy('name', 'ASC')->get(),
            'existing_categories' => $company->getCategories($company->category_ids),
            'existing_industries' => $company->getIndustries($company->industry_ids)
        ]);
    }

    // ADMIN: UPDADTE STORAGE
    public function updateStorage(Request $request, Site $site){
        $company = $site->getCompany($request->hex);
        $company->saveCategoryIds($request);
        $company->saveIndustryIds($request);
        return redirect('/dashboard/companies/'.$company->hex.'/edit/storage')->with('message', 'Company storage udated!');
    }

    // ADMIN: EDIT IMAGE
    public function editImage(Company $company){   
        return view('dashboard.companies.edit-image', [
            'company' => $company
        ]);
    }

    // ADMIN: UPDATE IMAGE
    public function updateImage(Request $request, Site $site){
        $company = $site->getCompany($request->hex);
        $company->saveImage($request);
        return redirect('dashboard/companies/'.$company->hex.'/edit/image')->with('message', 'Company image updated!');
    }

    // ADMIN: EDIT ADDRESS
    public function editAddress(Company $company){   
        return view('dashboard.companies.edit-address', [
            'company' => $company
        ]);
    }

    // ADMIN: UPDATE ADDRESS
    public function updateAddress(Request $request, Site $site){
        $company = $site->getCompany($request->hex);
        $company->saveAddress($request);
        return redirect('dashboard/companies/'.$company->hex.'/edit/address')->with('message', 'Company address updated!');
    }

    // ADMIN: EDIT FAMILY DETAILS
    public function editFamilyDetails(Company $company){   
        return view('dashboard.companies.edit-family', [
            'company' => $company
        ]);
    }

    // ADMIN: UPDATE FAMILY DETAILS
    public function updateFamilyDetails(Request $request, Site $site){
        $company = $site->getCompany($request->hex);
        $company->saveFamilyDetails($request);
        return redirect('dashboard/companies/'.$company->hex.'/edit/family')->with('message', 'Company family information updated!');
    }

    // ADMIN: EDIT FURTHER DETAILS
    public function editFurtherDetails(Company $company){   
        return view('dashboard.companies.edit-details', [
            'company' => $company
        ]);
    }

    // ADMIN: UPDATE FURTHER DETAILS
    public function updateFurtherDetails(Request $request, Site $site){
        $company = $site->getCompany($request->hex);
        $company->saveFurtherDetails($request);
        return redirect('dashboard/companies/'.$company->hex.'/edit/details')->with('message', 'Company further detils updated!');
    }

    // ADMIN: EDIT PUBLISHING
    public function editPublishingInformation(Company $company){   
        return view('dashboard.companies.edit-publishing', [
            'company' => $company
        ]);
    }

    // ADMIN: UPDATE PUBLISHING
    public function updatePublishingInformation(Request $request, Site $site){
        $company = $site->getCompany($request->hex);
        $company->savePublishingInformation($request);
        return redirect('dashboard/companies/'.$company->hex.'/edit/publishing')->with('message', 'Company publishing information updated!');
    }
}
