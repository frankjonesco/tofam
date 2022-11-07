<x-admin-card>
    {{-- Article edit buttons --}}
    <x-article-edit-buttons :article="$article"/>

    {{-- Static message --}}
    <x-static-message />

    {{-- View article card --}}
    <div class="p-3 border bg-light h-100 mb-5">
        <div class="card h-100">
            <div class="view-article-img">
                <a href="/articles/{{$article->hex}}/{{$article->slug}}">
                    <img 
                        src="{{$article->image ? asset('/images/articles/'.$article->hex.'/'.$article->image) : asset('/images/no-image.png')}}" 
                        class="card-img-top" 
                        alt="{{$article->title}}"
                    >
                </a>
            </div>
            <div class="card-body d-flex flex-column">
                <h1>{{$article->title}}</h1>
                <h3>{{$article->caption}}</h3>
                <h5>{{$article->teaser}}</h5>

                {{-- Article tags --}}
                <x-article-tags :tags="$article->tags" />

                <div class="d-flex justify-content-between">
                    <p>{{$article->user->full_name}}</p>
                    <p>{{$article->created_at}}</p>
                </div>
                <p>Category: {{$article->category->name ?? 'Uncategorized'}}</p>
                <p>{!!$article->body!!}</p>

                <p>Views: {{$article->views}}</p>
                <p>Likes: <span id="likeCount">{{$article->likes}}</span></p>

            </div>
        </div>
    </div>
</x-admin-card>



