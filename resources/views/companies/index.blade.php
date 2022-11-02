<x-layout>
    <x-card>
        <h1>Companies</h1>

        <div class="row">
            @foreach($companies as $company)
                <div class="col-3">
                    <x-company-card :company="$company"/>
                </div>
            @endforeach
        </div>

    </x-card>
</x-layout>