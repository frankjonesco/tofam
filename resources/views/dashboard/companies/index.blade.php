<x-admin-card>
        <h1>Companies Library</h1>

        @include('partials._dashboard-search-companies')

        @if(Session::has('searchTerm') && ((Route::currentRouteName() == 'searchRetrieve') || (Route::currentRouteName() == 'dashboardSearchRetrieve')))
            <p>Showing {{$count}} results for search term '{{Session::get('searchTerm')}}'</p>
        @endif

            @foreach($companies as $company)
                <div class="articles-grid">
                    <div class="left-column">
                        <img 
                            src="{{$company->image ? asset('images/companies/'.$company->hex.'/tn-'.$company->image) : asset('images/no-image.png')}}" 
                            alt=""
                            class="w-100"
                            style="border: 1px solid #ddd; padding: 2px;"
                        >
                    </div>

                    <div class="center-column">
                        <h5>{{$company->handle}}</h5>
                        <p>{{$company->description}}</p>
                    </div>

                    <div class="right-column text-right">
                        <a class="btn btn-primary btn-sm" href="/dashboard/companies/{{$company->hex}}/{{$company->slug}}"><i class="fa fa-eye"></i> View</a>
                        <a class="btn btn-success btn-sm" href="/dashboard/companies/{{$company->hex}}/edit"><i class="fa fa-pencil"></i> Edit</a>
                    </div>
                    
                </div>
            @endforeach
        </div>
     

</x-admin-card>
