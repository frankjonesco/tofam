<x-admin-card>

    <x-company-edit-buttons :company="$company"/>

    <h1>Edit contacts</h1>
    <a href="/dashboard/companies/{{$company->hex}}/contacts/create">
        <button class="btn btn-success">Add new contact</button>
    </a>
    <div class="w-100">

        @foreach($company->contacts as $contact)
            <x-contact-card :contact="$contact" />
        @endforeach
        
    </div>

    <x-popup-modal :contacts="$company->contacts" />

</x-admin-card>

