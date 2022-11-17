<x-layout>
    <x-card>
        {{-- Buttons bar --}}
        <x-buttons-bar>
            <a class="btn btn-primary btn-sm" href="{{url()->previous()}}">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
            @auth
                <a class="btn btn-success btn-sm" href="/dashboard/categories/create">
                    <i class="fa-solid fa-folder-open"></i> Create category
                </a>
            @endauth
        </x-buttons-bar>
        <h1>Categories</h1>


        <div class="container">
            <div class="row">
                @foreach($categories as $category)
                    <div class="col-6">
                        <div class="p-3 border bg-light h-100">
                            <div class="card mb-3 h-100">
                                <div class="view-article-img">
                                    <a href="/categories/{{$category->slug}}">
                                        <img 
                                            src="{{$category->image ? asset('/images/categories/'.$category->hex.'/tn-'.$category->image) : asset('/images/no-image.png')}}" 
                                            class="card-img-top" 
                                            alt="{{$category->name}}"
                                        >
                                    </a>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">
                                        {{$category->name}}
                                    </h5>

                                    @foreach($category->industries as $industry)
                                        {{$industry->name}} ({{$industry->english_name}})<br>
                                    @endforeach
                                    
                                    

                                    <a href="/categories/{{$category->slug}}" class="btn btn-success btn-sm mt-auto me-auto">
                                        <i class="fa-solid fa-folder-open"></i> View
                                    </a>
                                </div>
                            </div>
                        </div>


                        
                    </div>
                @endforeach
            </div>
        </div>
    </x-card>
</x-layout>