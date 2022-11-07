{{-- Buttons bar --}}
<x-buttons-bar>
    <a class="btn btn-primary btn-sm" href="/dashboard/categories">
        <i class="fa-solid fa-arrow-left"></i> Back
    </a>

    <a class="btn btn-success btn-sm" href="/dashboard/categories/{{$category->hex}}/edit/text">
        <i class="fa-solid fa-list"></i> Edit text
    </a>

    <a class="btn btn-secondary btn-sm" href="/dashboard/categories/{{$category->hex}}/edit/image">
        <i class="fa-solid fa-image"></i> Change image
    </a>

    <a class="btn btn-primary btn-sm" href="/dashboard/categories/{{$category->hex}}/edit/publishing">
        <i class="fa fa-bullhorn"></i> Publishing
    </a>

    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal">
        <i class="fa-solid fa-trash"></i> Delete
    </button>
    <x-popup-modal :category="$category" />
    
</x-buttons-bar>