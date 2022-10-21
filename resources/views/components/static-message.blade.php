@if(session()->has('staticError'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{session('staticError')}}
    </div>
@endif