<x-admin-card>
        <h1>Industry Library</h1>

        

            
            @foreach($industries as $industry)

                
                <div class="articles-grid">
                    <div class="left-column">
                        <img 
                            src="{{$industry->image ? asset('images/industries/'.$industry->hex.'/tn-'.$industry->image) : asset('images/no-image.png')}}" 
                            alt=""
                            class="w-100"
                            style="border: 1px solid #ddd; padding: 2px;"
                        >
                    </div>

                    <div class="center-column">
                        <h5>{{count($industry->companies)}} - {{$industry->name}}</h5>
                    </div>

                    <div class="right-column text-right">
                        
                        <a class="btn btn-success btn-sm" href="/dashboard/industries/{{$industry->hex}}/edit"><i class="fa fa-pencil"></i> Edit</a>
                    </div>
                    
                </div>
            @endforeach
        </div>
     

</x-admin-card>
