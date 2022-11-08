<x-admin-card>

    <x-company-edit-buttons :company="$company"/>

    <h1>Edit contacts</h1>
    <div class="w-100 justify-content-center">

        @foreach($company->contacts as $contact)
            <p>{{$contact->first_name}}</p>
        @endforeach
        
    </div>
</x-admin-card>