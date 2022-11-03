<div class="card mb-3">
    <div class="company-image">    
        <img 
            src="{{$company->image ? asset('/images/companies/'.$company->hex.'/'.$company->image) : asset('/images/no-image.png')}}" 
            alt="{{$company->handle}}" 
            class="w-100"
        >
    </div>
    <div class="card-body">
        <h5 class="card-title">{{$company->handle}}</h5>
        <p class="card-text">Views: {{$company->views}}</p>
        <a href="/companies/{{$company->hex}}/{{$company->find_slug}}" class="btn btn-primary btn-sm">
            <i class="fa fa-list"></i> 
            View
        </a>
    </div>
</div>