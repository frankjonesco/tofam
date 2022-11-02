<x-layout>
    <x-card>
        <h1>Companies</h1>

        @foreach($companies as $company)
            <a href="/companies/{{$company->hex}}/{{$company->slug}}"> 
                {{$company->handle}}
            </a>   
            <br>
        @endforeach

    </x-card>
</x-layout>