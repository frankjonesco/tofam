<x-layout>
    <x-card>
        {{-- Buttons bar --}}
        <x-buttons-bar>
            <a class="btn btn-primary btn-sm" href="{{url()->previous()}}">
                <i class="fa fa-arrow-left"></i> Back
            </a>
            
            <a class="btn btn-secondary btn-sm" href="/dashboard/articles/create">
                <i class="fa fa-newspaper"></i> Create article
            </a>

            <a class="btn btn-success btn-sm" href="/dashboard/categories/create">
                <i class="fa fa-folder-open"></i> Create category
            </a>

            <a class="btn btn-danger btn-sm" href="/dashboard/users/create">
                <i class="fa fa-user-plus"></i> Create user
            </a>

            <a class="btn btn-warning btn-sm" href="/dashboard/images/check">
                <i class="fa fa-image"></i> Check images
            </a>
            <a class="btn btn-info btn-sm" href="/dashboard/color-swatches">
                <i class="fa fa-brush"></i> Colors
            </a>
        </x-buttons-bar>
        <h1>Dashboard</h1>
    </x-card>
</x-layout>