<x-admin-card>
    {{-- {{dd($category->articles)}} --}}
    <h1>Industry: {{$industry->name}}</h1>

    <div class="row">
        <div class="col-3">    
            <img 
                src="{{$industry->image ? asset('images/industries/'.$industry->hex.'/tn-'.$industry->image) : asset('images/no-image.png')}}" 
                alt=""
                class="w-100"
                style="border: 1px solid #ddd; padding: 2px;"
            >
        </div>
        <div class="card-body col-9">
            <h5 class="card-title">Companies: {{count($industry->companies)}}</h5>
            <h5 class="card-title">Created by: {{$industry->user_id}}</h5>
        </div>
    </div>

    <div class="row">
        
            <h2>Companies</h2>
            
            @if(count($industry->companies) < 1)
                <p>No companies have been added to this category.</p>  
            @else
                @foreach($industry->companies as $company)
                    <div class="col-3">
                        <x-company-card :company="$company" />
                    </div>
                @endforeach
            @endif
        </div>
    </div>

</x-admin-card>
