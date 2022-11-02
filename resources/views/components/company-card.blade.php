<div class="card" style="width: 18rem;">
    <div class="" style="height: 180px;">
        <img 
            src="{{$company->logo ? asset('/images/companies/'.$company->hex.'/'.$company->logo) : asset('/images/no-image.png')}}" 
            alt="{{$company->handle}}"
            style=" height: 100%;"
        >
    </div>
    <div class="card-body">
      <h5 class="card-title">{{$company->handle}}</h5>
      <p class="card-text"></p>
      <a href="/companies/{{$company->hex}}/{{$company->slug}}" class="btn btn-primary">Go somewhere</a>
    </div>
  </div>