{{-- Buttons bar --}}
<x-buttons-bar>
    <a class="btn btn-primary btn-sm" href="{{url()->previous()}}">
        <i class="fa-solid fa-arrow-left"></i> Back
    </a>

    <a class="btn btn-success btn-sm" href="/dashboard/articles/{{$article->hex}}/edit/text">
        <i class="fa-solid fa-list"></i> Edit general
    </a>

    <a class="btn btn-dark btn-sm" href="/dashboard/articles/{{$article->hex}}/edit/storage">
        <i class="fa-solid fa-folder"></i> Storage
    </a>

    <a class="btn btn-secondary btn-sm" href="/dashboard/articles/{{$article->hex}}/edit/image">
        <i class="fa-solid fa-image"></i> Change image
    </a>

    <a class="btn btn-primary btn-sm" href="/dashboard/articles/{{$article->hex}}/edit/publishing">
        <i class="fa fa-bullhorn"></i> Publishing
    </a>

    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteArticleModal">
        <i class="fa-solid fa-trash"></i> Delete
    </button>
    <x-popup-modal :article="$article" />
</x-buttons-bar>