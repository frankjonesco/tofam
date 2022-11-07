<div class="card mb-3">
    <div class="company-image">    
        <img 
            src="{{$article->getThumbnail($article)}}" 
            class="card-img-top" 
            alt="{{$article->title}}"
        >
    </div>
    <div class="card-body">
        <h5 class="card-title">
            {{$article->title}}
        </h5>
        <p class="card-text">
            {{$article->teaser}}
        </p>
        <p>
            <small>
                {{$article->user->full_name}}
            </small>
        </p>
        <p class="card-text">
            <small class="text-muted">
                {{$article->created_at}}
            </small>
        </p>

        {{-- Article tags --}}
        <x-article-tags :tags="$article->tags" />
        

        <a href="/articles/{{$article->hex}}/{{$article->slug}}" class="btn btn-success btn-sm mt-auto me-auto">
            <i class="fa-solid fa-newspaper"></i> View
        </a>
    </div>
</div>