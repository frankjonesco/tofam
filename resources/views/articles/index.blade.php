<x-layout>
    <x-card>
        {{-- Buttons bar --}}
        <x-buttons-bar>
            <a class="btn btn-primary btn-sm" href="{{url()->previous()}}">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
            @auth
                <a class="btn btn-success btn-sm" href="/articles/create">
                    <i class="fa-solid fa-newspaper"></i> Create article
                </a>
            @endauth
        </x-buttons-bar>

        <h1>Articles</h1> 

        @include('partials._search')

        @if(Session::has('searchTerm'))
            <p>Showing {{$count}} results for search term '{{Session::get('searchTerm')}}'</p>
        @endif

        @if(count($articles))
            <div class="container mb-4">
                <div class="row g-2">
                    @foreach($articles as $article)
                        <x-article-card :article="$article" />
                    @endforeach
                </div>
            </div>
            {{ $articles->links() }}
        @else
            <p>There are no articles to display.</p>
        @endif
    </x-card>
</x-layout>