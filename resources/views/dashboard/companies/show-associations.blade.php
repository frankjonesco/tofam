<x-admin-card>

    <x-company-edit-buttons :company="$company"/>

    <h1>Edit associations</h1>
    <a href="/dashboard/companies/{{$company->hex}}/associations/create">
        <button class="btn btn-success mb-3">Add a new association</button>
    </a>
    <div class="w-100">
        <p>This company is currently associated to the following articles:</p>
        @foreach($company->associations as $association)
            {{$association->article->title}}
            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteAssociationModal_{{$association->id}}">Remove assiciation</button>
            <br/>
        @endforeach
        
    </div>

    <x-popup-modal :associations="$company->associations" />

</x-admin-card>

