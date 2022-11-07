<x-admin-card>
    <x-static-message />
    <h1>Article Library</h1>
        @include('partials._search')
        @foreach($articles as $article)
            <div class="articles-grid">
                <div class="left-column">
                    <img 
                        src="{{$article->image ? asset('images/articles/'.$article->hex.'/tn-'.$article->image) : asset('images/no-image.png')}}" 
                        alt=""
                        class="w-100"
                        style="border: 1px solid #ddd; padding: 2px;"
                    >
                </div>
                <div class="center-column">
                    <h5>
                        <a href="/dashboard/articles/{{$article->hex}}">
                            {{$article->short_title}}
                        </a>
                    </h5>
                    <p>{!!$article->short_body!!}</p>
                </div>
                <div class="right-column text-right">
                    <a class="btn btn-success btn-sm" href="/dashboard/articles/{{$article->hex}}/edit/text">
                        <i class="fa fa-pencil"></i> 
                        Edit
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</x-admin-card>
