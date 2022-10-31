<x-layout>
    <x-card>
        <h1>Companies</h1>

        @foreach($companies as $company)
            {{$company->name}}
            <br>
        @endforeach

    </x-card>
</x-layout>