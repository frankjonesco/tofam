<x-layout>
    <x-card>

        {{-- Buttons bar --}}
        <x-buttons-bar>
            <a class="btn btn-primary btn-sm" href="{{url()->previous()}}">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
            @auth
                <a class="btn btn-success btn-sm" href="/dashboard/articles/{{$article->hex}}/edit">
                    <i class="fa-solid fa-pencil"></i> Edit article
                </a>   
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteArticleModal">
                    <i class="fa-solid fa-trash"></i> Delete
                </button>
                <x-popup-modal :article="$article" />
            @endauth
        </x-buttons-bar>

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
                    @if($article->tags && is_array($article->tags))
                        <div class="mt-1 mb-3">
                            @foreach($article->tags as $tag)
                                <a href="/tags/{{$tag}}" style="text-decoration:none;">
                                    <span class="badge bg-primary">{{$tag}}</span>
                                </a>
                            @endforeach
                        </div>
                    @endif

                    <div class="d-flex justify-content-between">
                        <p>{{$article->user->first_name.' '.$article->user->last_name}}</p>
                        <p>{{$article->created_at}}</p>
                    </div>
                    <p>{!!$article->body!!}</p>

                    <p>Views: {{$article->views}}</p>
                </div>
            </div>
        </div>
        

        {{-- Other articles --}}
        @if(count($other_articles))
            
            <h1 class="mb-3">Other Articles</h1>
            <div class="container">
                <div class="row g-2 mb-4">
                    @foreach($other_articles as $other_article)
                        <x-article-card :article="$other_article" />
                    @endforeach
                </div>
            </div>
            
        @else
            <p>There are no articles to display.</p>
        @endif


    </x-card>
</x-layout>



