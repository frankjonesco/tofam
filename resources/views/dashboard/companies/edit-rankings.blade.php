<x-admin-card>

    <x-company-edit-buttons :company="$company"/>

    <h1>Edit rankings</h1>
    <div class="w-100 justify-content-center">

        @foreach($company->rankings as $ranking)
            <p>{{$ranking->turnover}}</p>
        @endforeach
        
    </div>
</x-admin-card>