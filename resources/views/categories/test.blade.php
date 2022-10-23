<x-layout>
    <x-card>
         {{-- Buttons bar --}}
         <x-buttons-bar>
            <a class="btn btn-primary btn-sm" href="{{url()->previous()}}">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
        </x-buttons-bar>
        <h1>Test</h1>
    </x-card>
</x-layout>