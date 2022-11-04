<div class="card mb-3">
    <div class="">    
        <img 
            src="{{$industry->image ? asset('images/industries/'.$industry->hex.'/tn-'.$industry->image) : asset('images/no-image.png')}}" 
            alt=""
            class="w-100"
            style="border: 1px solid #ddd; padding: 2px;"
        >
    </div>
    <div class="card-body">
        <h5 class="card-title">{{$industry->name}}</h5>
        <p class="card-text">Companies: {{count($industry->companies)}}</p>
        <a href="/dashboard/industries/{{$industry->hex}}" class="btn btn-primary btn-sm">
            <i class="fa fa-list"></i> 
            View
        </a>
    </div>
</div>