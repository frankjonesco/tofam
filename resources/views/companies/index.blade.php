<x-layout>
    <x-card>
        <h1>Companies</h1>

        @include('partials._search-companies')
        
        @if(Session::has('searchTerm') && Route::currentRouteName() == 'companiesSearchRetrieve')
            <p>Showing {{$count}} results for search term '{{Session::get('searchTerm')}}'</p>
        @endif

        <div class="row">
            @foreach($companies as $company)
                <div class="col-3">
                    <x-company-card :company="$company"/>
                </div>
            @endforeach

            {{ $companies->links() }}
        </div>

    </x-card>
</x-layout>