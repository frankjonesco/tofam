<div class="card mb-3">
    <div class="">    
        <img 
            src="{{$category->image ? asset('images/categories/'.$category->hex.'/tn-'.$category->image) : asset('images/no-image.png')}}" 
            alt=""
            class="w-100"
            style="border: 1px solid #ddd; padding: 2px;"
        >
    </div>
    <div class="card-body">
        <h5 class="card-title">{{$category->name}}</h5>
        <p class="card-text">Articles: {{count($category->articles)}}</p>
        <p class="card-text">Companies: {{count($category->companies)}}</p>
        <a href="/dashboard/categories/{{$category->hex}}" class="btn btn-primary btn-sm">
            <i class="fa fa-list"></i> 
            View
        </a>
    </div>
</div>