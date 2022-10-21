<x-layout>
    <x-card>
        {{-- Buttons bar --}}
        <x-buttons-bar>
            <a class="btn btn-primary btn-sm" href="{{url()->previous()}}">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
            @auth
                <a class="btn btn-success btn-sm" href="/categories/create">
                    <i class="fa-solid fa-folder-open"></i> Create category
                </a>
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal">
                    <i class="fa-solid fa-trash"></i> Delete
                </button>
                <x-popup-modal :category="$category" />
            @endauth
        </x-buttons-bar>
        <h1>Category: {{$category->name}}</h1>

        @if(count($articles))
            @foreach($articles as $article)
                <x-article-card :article="$article" />
            @endforeach
        @else
            <p>There is nothing in this category.</p>
        @endif
    </x-card>
</x-layout>