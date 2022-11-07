@if($tags && is_array($tags))
    <div class="mt-1 mb-3">
        @foreach($tags as $tag)
            <a href="/articles/tags/{{$tag}}" style="text-decoration:none;">
                <span class="badge bg-primary">{{$tag}}</span>
            </a>
        @endforeach
    </div>
@endif