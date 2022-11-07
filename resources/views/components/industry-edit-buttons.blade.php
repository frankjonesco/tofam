<x-buttons-bar>
    <a class="btn btn-primary btn-sm" href="/dashboard/industries">
        <i class="fa-solid fa-arrow-left"></i> Back
    </a>
    <a class="btn btn-success btn-sm" href="/dashboard/industries/{{$industry->hex}}/edit">
        <i class="fa-solid fa-list"></i> Edit
    </a>
    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteIndustryModal">
        <i class="fa-solid fa-trash"></i> Delete
    </button>
    <x-popup-modal :industry="$industry" />
</x-buttons-bar>