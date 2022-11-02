<x-admin-card>
        <h1>Companies Library</h1>

        @include('partials._search')

            @foreach($companies as $company)
                <div class="articles-grid">
                    <div class="left-column">
                        <img 
                            src="{{$company->logo ? asset('images/companies/'.$company->hex.'/tn-'.$company->logo) : asset('images/no-image.png')}}" 
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
                        
                        <a class="btn btn-success btn-sm" href="/dashboard/companies/{{$company->hex}}/edit"><i class="fa fa-pencil"></i> Edit</a>
                    </div>
                    
                </div>
            @endforeach
        </div>
     

</x-admin-card>
