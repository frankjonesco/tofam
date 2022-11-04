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



    // CATEGORIES: INDEX
    public function categoriesIndex(){
        // dd(Site::allArticles());
        return view('dashboard.categories.index', [
            'categories' => Category::orderBy('name', 'ASC')->get()
        ]);
    }

    // CATEGORIES: MINE
    public function categoriesMine(){
        // dd(Site::allArticles());
        return view('dashboard.categories.index', [
            'categories' => Category::where('user_id', auth()->user()->id)->orderBy('name', 'ASC')->get()
        ]);
    }

    // CATEGORIES: CREATE
    public function categoriesCreate(){
        return view('dashboard.categories.create');
    }

    // CATEGORIES: STORE
    public function categoriesStore(Request $request){
        
        // Validate form fields 
        $request->validate([
            'name' => 'required',
        ]);

        $category = new Category();
        $category->hex = $category->uniqueHex(new Site());
        $category->user_id = auth()->user()->id;
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->description = $request->description;
        $category->status = 'private';
       
        $category->save();

        return redirect('dashboard/categories/'.$category->hex.'/edit/text')->with('message', 'New category created!');
    }

    // CATEGORIES: EDIT TEXT
    public function categoriesEditText(Category $category){
        return view('dashboard.categories.edit-text', [
            'category' => $category
        ]);
    }

    // CATEGORIES: EDIT IMAGE
    public function categoriesEditImage(Category $category){   
        return view('dashboard.categories.edit-image', [
            'category' => $category,
        ]);
    }

    // CATEGORIES: EDIT PUBLISHING
    public function categoriesEditPublishing(Category $category){   
        return view('dashboard.categories.edit-publishing', [
            'category' => $category,
        ]);
    }

    // CATEGORIES: UPDATE TEXT
    public function categoriesUpdateText(Request $request){
        
        // Validate form fields 
        $request->validate([
            'name' => 'required',
        ]);

        $category = Category::where('hex', $request->hex)->first();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->description = $request->description;
       
        $category->save();

        return redirect('dashboard/categories/'.$category->hex.'/edit/text')->with('message', 'Category text updated!');
    }

    // CATEGORIES: UPDATE IMAGE
    public function categoriesUpdateImage(Request $request){

        $site = new Site();
        $category = Category::where('hex', $request->hex)->first();
        
        if($request->hasFile('image')){
            $category->image = $site->handleImageUpload($request, 'categories', $category->hex);
        }
        
        $category->save();

        return redirect('dashboard/categories/'.$category->hex.'/edit/image')->with('message', 'Category image updated!');
    }

    // CATEGORIES: UPDATE PUBLISHING
    public function categoriesUpdatePublishing(Request $request){

        $category = Category::where('hex', $request->hex)->first();
        $category->status = $request->status;
        
        $category->save();

        return redirect('dashboard/categories/'.$category->hex.'/edit/publishing')->with('message', 'Category publishing updated!');
    }



    // ARTICLES: INDEX
    public function articlesIndex(){
        // dd(Site::allArticles());
        return view('dashboard.articles.index', [
            'articles' => Site::allArticles(),
        ]);
    }

    // ARTICLES: MINE
    public function articlesMine(){
        // dd(Site::allArticles());
        return view('dashboard.articles.mine', [
            'articles' => Article::where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC')->get(),
        ]);
    }

    // ARTICLES: CREATE
    public function articlesCreate(){
        return view('dashboard.articles.create');
    }

    // ARTICLES: STORE
    public function articlesStore(Request $request){
        
        // Validate form fields 
        $request->validate([
            'title' => 'required',
            'tags' => ['regex:/^[a-zA-Z0-9 ,]+$/', 'nullable'],
        ],
        [
            'tags.regex' => 'Only alphanumeric characters and commas are allowed in \'tags\'',
            'tags.nullable' => 'Null'
        ]);

        $site = new Site();
        $article = new Article();
        
        $article->hex = $article->uniqueHex($site);
        $article->user_id = auth()->user()->id;
        $article->title = $request->title;
        $article->slug = Str::slug($request->title);
        $article->caption = $request->caption;
        $article->teaser = $request->teaser;
        $article->body = $request->body;
        $article->tags = $article->formatTags($request->tags);
        $article->status = 'private';

        $article->save();

        return redirect('dashboard/articles/'.$article->hex.'/edit/text')->with('message', 'New article created!');
    }

    // ARTICLES: EDIT GENERAL
    public function articlesEditText(Article $article){   
        return view('dashboard.articles.edit-text', [
            'article' => $article
        ]);
    }

    // ARTICLES: EDIT STORAGE
    public function articlesEditStorage(Article $article){   
        return view('dashboard.articles.edit-storage', [
            'article' => $article,
            'categories' => Category::orderBy('id', 'ASC')->get(),
        ]);
    }

    // ARTICLES: EDIT IMAGE
    public function articlesEditImage(Article $article){   
        return view('dashboard.articles.edit-image', [
            'article' => $article,
        ]);
    }

    // ARTICLES: EDIT PUBLISHING
    public function articlesEditPublishing(Article $article){   
        return view('dashboard.articles.edit-publishing', [
            'article' => $article,
        ]);
    }

    // ARTICLES: UPDATE GENERAL
    public function articlesUpdateText(Request $request){
        
        // Validate form fields 
        $request->validate([
            'title' => 'required',
            'tags' => ['regex:/^[a-zA-Z0-9 ,]+$/', 'nullable'],
        ],
        [
            'tags.regex' => 'Only alphanumeric characters and commas are allowed in \'tags\'',
            'tags.nullable' => 'Null'
        ]);

        $article = Article::where('hex', $request->hex)->first();
        $article->title = $request->title;
        $article->caption = $request->caption;
        $article->teaser = $request->teaser;
        $article->body = $request->body;
        $article->tags = $article->formatTags($request->tags);

        $article->save();

        return redirect('dashboard/articles/'.$article->hex.'/edit/text')->with('message', 'Aricle text updated!');
    }

    // ARTICLES: UPDATE STORAGE
    public function articlesUpdateStorage(Request $request){

        $article = Article::where('hex', $request->hex)->first();
        $article->category_id = $request->category_id;
        
        $article->save();

        return redirect('dashboard/articles/'.$article->hex.'/edit/storage')->with('message', 'Aricle storage updated!');
    }

    // ARTICLES: UPDATE IMAGE
    public function articlesUpdateImage(Request $request){

        $site = new Site();
        $article = Article::where('hex', $request->hex)->first();
        
        if($request->hasFile('image')){
            $article->image = $site->handleImageUpload($request, 'articles', $article->hex);
        }
        
        $article->save();

        return redirect('dashboard/articles/'.$article->hex.'/edit/image')->with('message', 'Aricle image updated!');
    }

    // ARTICLES: UPDATE PUBLISHING
    public function articlesUpdatePublishing(Request $request){

        $article = Article::where('hex', $request->hex)->first();
        $article->status = $request->status;
        
        $article->save();

        return redirect('dashboard/articles/'.$article->hex.'/edit/status')->with('message', 'Aricle publishing updated!');
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



    // COLOR SWATCH: INDEX
    public function colorSwatchIndex(){
        return view('dashboard.color-swatches.index', [
            'color_swatches' => ColorSwatch::get()
        ]);
    }

    // COLOR SWATCH: SHOW SINGLE COLOR SWATCH
    public function colorSwatchShow($hex = null){
        $color_swatch = ColorSwatch::where('hex', $hex)->first();
        return view('dashboard.color-swatches.show', [
            'color_swatch' => $color_swatch,
            // 'colors' => Color::where('color_swatch_id', $color_swatch->id)->orgerBy('fill_id', 'ASC')->get()
        ]);
    }

    // COLOR SWATCH: USE THIS SWATCH
    public function colorSwatchUse($hex = null){
        $color_swatch = ColorSwatch::where('hex', $hex)->first();
        $config = Config::where('id', 1)->first();
        $config->color_swatch_id = $color_swatch->id;
        $config->save();
        return redirect('dashboard/color-swatches')->with('messsge', 'Color swatch updated!');
    }

    // COLOR SWATCH: CREATE
    public function colorSwatchCreate(){
        return view('dashboard.color-swatches.create');
    }

    // COLOR SWATCH STORE
    public function colorSwatchStore(Request $request){
        
        $color_swatch = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $site = new Site();
        $color_swatch['hex'] = $site->uniqueHex('color_swatches');
        $color_swatch['user_id'] = auth()->id();
        $color_swatch['slug'] = Str::slug($color_swatch['name']);

        if($request->hasFile('image')){
            $color_swatch['image'] = $site->handleImageUpload($request, 'color_swatches', $color_swatch['hex']);
        }
        
        $color_swatch = ColorSwatch::create($color_swatch);

        $colors = [];
        $default_colors = [
            0 => [
                'code' => 'FFA400',
                'name' => 'Orange Web'
            ],
            1 => [
                'code' => '188FA7',
                'name' => 'Blue Munsell'
            ],
            2 => [
                'code' => 'D6FF79',
                'name' => 'Mindaro'
            ]
        ];

        $x = 0;
        $number_of_colors = 3;
        while($x < $number_of_colors){
            $colors[$x] = [
                'color_swatch_id' => $color_swatch->id,
                'fill_id' => $x + 1,
                'code' => $default_colors[$x]['code'],
                'name' => $default_colors[$x]['name'],
                'created_at' => now(),
                'updated_at' => now()
            ];
            $x++;
        }
    //    dd($colors);
        Color::insert($colors);

        return redirect('dashboard/color-swatches/'.$color_swatch->hex.'/edit');
    }

    // COLOR SWATCH: SHOW EDIT FORM
    public function colorSwatchEdit($hex = null){
        $color_swatch = ColorSwatch::where('hex', $hex)->first();
        return view('dashboard.color-swatches.edit', [
            'color_swatch' => $color_swatch
        ]);
    }

    // COLOR SWATCH: UPDATE COLOR SWATCH
    public function colorSwatchUpdate(Request $request, $hex = null){
        
        $debug = [];


        // Get color swatch
        $color_swatch = ColorSwatch::where('hex', $hex)->first();

        $debug['color_swatch_id'] = $color_swatch->id;

        
        // Validate form fields
        $form_fields = $request->validate([
            'name' => ['required', Rule::unique('color_swatches', 'name')->ignore($color_swatch->id)],
            'description' => 'required'
        ]);

        // Save swatch details
        $color_swatch->name = $request->name;
        $color_swatch->description = $request->description;
        $color_swatch->save();
        
        if($color_swatch->save()){
            $debug['swatch_info_saved'] = true;
        }else{
            $debug['swatch_info_saved'] = false;
        }


        // UPDATE EXISTING COLOR
        $debug['existing_color'] = count($color_swatch->colors);
        foreach($color_swatch->colors as $key => $color){
            // Labels for validation
            $code_label = 'code_' . $color->fill_id;
            $name_label = 'name_' . $color->fill_id;
            // Validate form fields
            $form_fields = $request->validate(
                [
                    $code_label => 'required|max:6|min:6',
                    $name_label => 'required|min:2',
                ],
                [   
                    $code_label.'.required' => 'Please enter a color code.',
                    $code_label.'.max' => 'The color code can only contain 6 charachters.',
                    $code_label.'.min' => 'The color code must be 6 charachters.',
                    $name_label.'.required' => 'Please enter a name for this color.',
                    $name_label.'.min' => 'The color name must contain at least 2 characters.'
                ]
            );
            // Compile data for update query
            $i = $key + 1;
            $data = [
                'code' => $request->$code_label,
                'name' => $request->$name_label,
                'updated_at' => now()
            ];
            $debug['existing_colors_data'][$key] = $data;
            // Update color
            Color::where('id', $color->id)->update($data);
        }


        // ADD NEW COLORS
        $number_of_existing_colors = count($color_swatch->colors);
        $number_of_new_colors = $request->countNewColors;

        $debug['number_of_new_colors'] = $number_of_new_colors;
        $debug['new_colors_data'] = 'empty';

        $x = 1;
        while($x <= $number_of_new_colors){
            $new_color_number = $number_of_existing_colors + $x;
            // Labels for validation
            $code_label = 'code_' . $new_color_number;
            $name_label = 'name_' . $new_color_number;

            // Validate form fields
            $form_fields = $request->validate(
                [
                    $code_label => 'required|max:6|min:6',
                    $name_label => 'required|min:2',
                ],
                [   
                    $code_label.'.required' => 'Please enter a color code.',
                    $code_label.'.max' => 'The color code can only contain 6 charachters.',
                    $code_label.'.min' => 'The color code must be 6 charachters.',
                    $name_label.'.required' => 'Please enter a name for this color.',
                    $name_label.'.min' => 'The color name must contain at least 2 characters.'
                ]
            );

            // Compile data for create query
            $data = [
                'color_swatch_id' => $color_swatch->id,
                'fill_id' => $number_of_existing_colors + $x,
                'code' => $request->$code_label,
                'name' => $request->$name_label,
                'updated_at' => now()
            ];
                
            $debug['new_colors_data'][$x] = 's';

            // Create color
            Color::create($data);
            $x++;
        }


        // DELETE COLORS
        $debug['delete_ids'] = 'empty';

        // If there are IDs to delete...
        if(!empty($request->idsToBeDeleted)){
            $delete_list = $request->idsToBeDeleted;

            // Replace multiple commas
            $delete_list = preg_replace('/,+/', ',', $delete_list);

            // Trim commas from list
            $delete_list = trim($delete_list, ',');

            $debug['delete_ids'] = $delete_list;

            // Explode list to array
            $delete_list = explode(',', $delete_list);

            // If ID in delete array then delete color
            foreach($delete_list as $key => $delete_color){
                $color = Color::where(['color_swatch_id' => $request->color_swatch_id, 'fill_id' => $delete_color]);
                if($color->delete()){
                    $debug['deleted_success'][$key] = $delete_color;
                }else{
                    $debug['deleted_error'][$key] = $delete_color;
                }
            }
        }


        // REORDER COLORS
        $colors = Color::where('color_swatch_id', $color_swatch->id)->orderBy('id', 'ASC')->get();
        foreach($colors as $key => $color){
            $color['fill_id'] = $key + 1;
            $color->save();
        }
        

        //dd($debug);

        return redirect('dashboard/color-swatches/'.$hex)->with('message', 'Color swatch updated!');
    }

    // COLOR SWATCH: DELETE SWATCH AND ASSOCIATED COLORS
    public function colorSwatchDestroy($hex = null){
        $color_swatch = ColorSwatch::where('hex', $hex)->first();
        $color_swatch->delete();
        return redirect('dashboard/color-swatches')->with('message', 'Color swatch deleted!');
    }

    // COLOR SWATCH: DELETE A COLOR FROM A SWATCH
    public function colorSwatchDestroyColor(Request $request, $hex = null){
        
        $colors = Color::where('color_swatch_id', $request->color_swatch_id)->get();
        
        foreach($colors as $color){
            if($color->fill_id > $request->color_fill_id){
                Color::where('id', $color->id)->update(['fill_id' => ($color->fill_id - 1)]);
            }
        }

        $color = Color::where('id', $request->color_id);
        $color->delete();

        return back()->with('message', 'Color removed from swatch!');

    }
}
