<x-admin-card>
        <h1>Category Library</h1>


            @foreach($categories as $category)
                <div class="articles-grid">
                    <div class="left-column">
                        <img 
                            src="{{$category->image ? asset('images/categories/'.$category->hex.'/tn-'.$category->image) : asset('images/no-image.png')}}" 
                            alt=""
                            class="w-100"
                            style="border: 1px solid #ddd; padding: 2px;"
                        >
                    </div>

                    <div class="center-column">
                        <h5>{{$category->name}}</h5>
                        <p>{{$category->description}}</p>
                    </div>

                    <div class="right-column text-right">
                        
                        <a class="btn btn-success btn-sm" href="/dashboard/categories/{{$category->hex}}/edit/text"><i class="fa fa-pencil"></i> Edit</a>
                    </div>
                    
                </div>
            @endforeach
        </div>
     

</x-admin-card>
