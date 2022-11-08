<form action="/dashboard/companies/search" method="post" class="mb-4">
    @csrf
    <input 
        type="text" 
        name="search" 
        class="form-control form-control-lg" 
        placeholder="Search..." 
        @if(Session::has('searchTerm') && ((Route::currentRouteName() == 'searchRetrieve') || (Route::currentRouteName() == 'adminSearchRetrieve')))
            value="{{ Session::get('searchTerm') }}"
        @endif
    >
</form>