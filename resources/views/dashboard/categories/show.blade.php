<x-admin-card>

    <x-category-edit-buttons :category="$category"/>
    
    {{-- {{dd($category->articles)}} --}}
    <h1>Category: {{$category->name}}</h1>

    <div class="row">
        <div class="col-3">    
            <img 
                src="{{$category->image ? asset('images/categories/'.$category->hex.'/tn-'.$category->image) : asset('images/no-image.png')}}" 
                alt=""
                class="w-100"
                style="border: 1px solid #ddd; padding: 2px;"
            >
        </div>
        <div class="card-body col-9">
            <h5 class="card-title">Companies: {{count($category->companies)}}</h5>
            <h5 class="card-title">Articles: {{count($category->articles)}}</h5>
            <h5 class="card-title">Created by: {{$category->user_id}}</h5>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <h2>Articles</h2>
            @if(count($category->articles) < 1)
                <p>No articles have been added to this category.</p>  
            @else
                @foreach($category->articles as $article)
                    <x-article-card :article="$article" />
                @endforeach
            @endif
        </div>

        <div class="col-6">
            <h2>Companies</h2>
            @if(count($category->companies) < 1)
                <p>No companies have been added to this category.</p>  
            @else
                @foreach($category->companies as $company)
                    <x-company-card :company="$company" />
                @endforeach
            @endif
        </div>
    </div>

</x-admin-card>
