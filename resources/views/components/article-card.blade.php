<div class="col-4">
    <div class="p-3 border bg-light h-100">
        <div class="card mb-3 h-100">
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
                <h5 class="card-title">
                    {{$article->title}}
                </h5>
                <p class="card-text">
                    {{$article->teaser}}
                </p>
                <p>
                    <small>
                        {{$article->user->first_name.' '.$article->user->last_name}}
                    </small>
                </p>
                <p class="card-text">
                    <small class="text-muted">
                        {{$article->created_at}}
                    </small>
                </p>

                {{-- Article tags --}}

                {{-- {{dd($article->tags)}} --}}
                @if($article->tags && is_array($article->tags))
                    <div class="mt-1 mb-3">
                        @foreach($article->tags as $tag)
                            <a href="/tags/{{$tag}}" style="text-decoration:none;">
                                <span class="badge bg-primary">{{$tag}}</span>
                            </a>
                        @endforeach
                    </div>
                @endif

                <a href="/articles/{{$article->hex}}/{{$article->slug}}" class="btn btn-success btn-sm mt-auto me-auto">
                    <i class="fa-solid fa-newspaper"></i> View
                </a>
            </div>
        </div>
    </div>
</div>