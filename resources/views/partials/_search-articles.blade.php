<form action="/articles/search" method="post" class="mb-4">
    @csrf
    <input 
        type="text" 
        name="search" 
        class="form-control form-control-lg" 
        placeholder="Search..." 
        @if(Session::has('searchTerm') && Route::currentRouteName() == 'articlesSearchRetrieve')
            value="{{ Session::get('searchTerm') }}"
        @endif>
</form>