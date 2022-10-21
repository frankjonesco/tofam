<x-layout>
    <x-card>
        {{-- Buttons bar --}}
        <x-buttons-bar>
            <a class="btn btn-primary btn-sm" href="{{url()->previous()}}">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
            
            <a class="btn btn-secondary btn-sm" href="/articles/create">
                <i class="fa-solid fa-newspaper"></i> Create article
            </a>

            <a class="btn btn-success btn-sm" href="/categories/create">
                <i class="fa-solid fa-folder-open"></i> Create category
            </a>

            <a class="btn btn-success btn-sm" href="/users/create">
                <i class="fa-solid fa-user-plus"></i> Create user
            </a>
        </x-buttons-bar>
        <h1>Dashboard</h1>
    </x-card>
</x-layout>