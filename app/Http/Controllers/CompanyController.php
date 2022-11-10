<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Ranking;
use App\Models\Category;
use App\Models\Industry;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Rules\SoftUrlRule;
use App\Rules\RankingYearIsUnique;
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
        return view('dashboard.companies.edit-family-details', [
            'company' => $company
        ]);
    }

    // ADMIN: UPDATE FAMILY DETAILS
    public function updateFamilyDetails(Request $request, Site $site){
        $company = $site->getCompany($request->hex);
        $company->saveFamilyDetails($request);
        return redirect('dashboard/companies/'.$company->hex.'/edit/family-details')->with('message', 'Company family information updated!');
    }

    // ADMIN: EDIT FURTHER DETAILS
    public function editFurtherDetails(Company $company){   
        return view('dashboard.companies.edit-further-details', [
            'company' => $company
        ]);
    }

    // ADMIN: UPDATE FURTHER DETAILS
    public function updateFurtherDetails(Request $request, Site $site){
        $company = $site->getCompany($request->hex);
        $company->saveFurtherDetails($request);
        return redirect('dashboard/companies/'.$company->hex.'/edit/further-details')->with('message', 'Company further detils updated!');
    }

    // ADMIN: EDIT COMMENTS
    public function editComments(Company $company){
        return view('dashboard.companies.edit-comments', [
            'company' => $company,
            'comments' => $company->getComments()
        ]);
    }

    // ADMIN: UPDATE COMMENTS
    public function addComment(Request $request, Company $company, Site $site){
        $request->validate(
            [
                'body' => 'required'
            ],
            [
                'body.required' => 'Type some text into the comment box.'
            ]
        );
        $company->createComment($request);
        return redirect('dashboard/companies/'.$company->hex.'/comments')->with('message', 'New comment added!');
    }

    // ADMIN: DELETE COMMENT
    public function destroyComment(Request $request, Company $company){
        $company->destroyComment($request);
        return redirect('dashboard/companies/'.$company->hex.'/comments')->with('message', 'Your comment was deleted!');
    }

    // ADMIN: REPLY TO COMMENT
    public function replyToComment(Request $request, Company $company, Site $site){

        Comment::create([
            'user_id' => auth()->user()->id,
            'parent_id' => $request->comment_id,
            'resource_type' => 'company',
            'resource_id' => $company->id,
            'body' => $request->reply_body,
        ]);

        return redirect('dashboard/companies/'.$company->hex.'/comments')->with('Reply sent!');
    }

    // ADMIN: SHOW CONTACTS
    public function showContacts(Company $company){
        return view('dashboard.companies.show-contacts', [
            'company' => $company
        ]);
    }

    // ADMIN: CREATE CONTACT
    public function createContact(Company $company){
        return view('dashboard.companies.create-contact', [
            'company' => $company
        ]);
    }

    // ADMIN: STORE CONTACT
    public function storeContact(Request $request, Company $company, Contact $contact){
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required'
        ]);
        $contact->createContact($request, $company);
        return redirect('dashboard/companies/'.$company->hex.'/contacts')->with('message', 'Contact created!');
    }

    // ADMIN: EDIT CONTACT
    public function editContact(Company $company, Contact $contact){
        return view('dashboard.companies.edit-contact', [
            'company' => $company,
            'contact' => $contact
        ]);
    }

    // ADMIN: UPDATE CONTACT
    public function updateContact(Request $request, Site $site){
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required'
        ]);
        $company = $site->getCompany($request->company_hex);
        $contact = $company->getContact($request->contact_hex);
        $contact->saveContact($request, $contact);
        return redirect('dashboard/companies/'.$company->hex.'/contacts')->with('message', 'Contact updated!');
    }

    // ADMIN: DELETE CONTACT
    public function destroyContact(Request $request, Company $company){
        $contact = $company->getContact($request->contact_hex);
        $contact->delete();
        return redirect('dashboard/companies/'.$company->hex.'/contacts')->with('message', 'Contact deleted!');
    }

    // ADMIN: SHOW RANKINGS
    public function showRankings(Company $company){
        return view('dashboard.companies.show-rankings', [
            'company' => $company,
        ]);
    }

    // ADMIN: CREATE RANKING
    public function createRanking(Company $company){
        return view('dashboard.companies.create-ranking', [
            'company' => $company
        ]);
    }

    // ADMIN: UDATE RANKING
    public function storeRanking(Request $request, Company $company){
        $form_data = $request->validate(
            [
                'year' =>  ['required', 'numeric', 'digits:4', 'min:1900', 'max:'.(date('Y')), new RankingYearIsUnique($company->id)],
                'turnover' => 'numeric|nullable',
                'employees' => 'numeric|nullable',
                'training_rate' => ['regex:^(?:[1-9]\d+|\d)(?:\,\d\d)?$^', 'nullable'],
            ],
            [
                'year.max' => 'You cannot add a year in the future.',
                'training_rate.regex' => 'Only use numerical and decimal values for \'training rate\''
            ]    
        );
        $form_data['turnover'] = $request->turnover;
        $form_data['employees'] = $request->employees;
        $form_data['training_rate'] = $request->training_rate;
        $form_data['confirmed_by_company'] = $request->confirmed_by_company;
        $company->createRanking($form_data);
        return redirect('dashboard/companies/'.$company->hex.'/rankings')->with('message', 'New ranking added!');
    }

    // ADMIN: EDIT RANKING
    public function editRanking(Company $company, Ranking $ranking){
        return view('dashboard.companies.edit-ranking', [
            'company' => $company,
            'ranking' => $ranking
        ]);
    }

    // ADMIN: UPDATE RANKING
    public function updateRanking(Request $request, Company $company){
        $request->validate([
            'year' => 'required'
        ]);
        $company->saveRanking($request);
        return redirect('dashboard/companies/'.$company->hex.'/rankings')->with('message', 'Ranking updated!');
    }

    // ADMIN: DELETE RANKING
    public function destroyRanking(Request $request, Company $company){
        $ranking = $company->getRanking($request->ranking_hex);
        $ranking->delete();
        return redirect('dashboard/companies/'.$company->hex.'/rankings')->with('message', 'Ranking deleted!');
    }

    // ADMIN: EDIT PUBLISHING
    public function editPublishingInformation(Company $company){   
        return view('dashboard.companies.edit-publishing-information', [
            'company' => $company
        ]);
    }

    // ADMIN: UPDATE PUBLISHING
    public function updatePublishingInformation(Request $request, Site $site){
        $company = $site->getCompany($request->hex);
        $company->savePublishingInformation($request);
        return redirect('dashboard/companies/'.$company->hex.'/edit/publishing-information')->with('message', 'Company publishing information updated!');
    }
}
