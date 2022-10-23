<x-layout>
    <x-card>
        {{-- Buttons bar --}}
        <x-buttons-bar>
            <a class="btn btn-primary btn-sm" href="{{url()->previous()}}">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
            @auth
                <a class="btn btn-success btn-sm" href="/dashboard/categories/{{$category->hex}}/edit">
                    <i class="fa-solid fa-pencil"></i> Edit category
                </a>  
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal">
                    <i class="fa-solid fa-trash"></i> Delete
                </button>
                <x-popup-modal :category="$category" />
            @endauth
        </x-buttons-bar>
        <h1>Category: {{$category->name}}</h1>

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