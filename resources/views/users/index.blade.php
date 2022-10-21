<x-layout>
    <x-card>
        {{-- Buttons bar --}}
        <x-buttons-bar>
            <a class="btn btn-primary btn-sm" href="{{url()->previous()}}">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
            @auth
                <a class="btn btn-success btn-sm" href="/dashboard/users/create">
                    <i class="fa-solid fa-user-plus"></i> Create user
                </a>
            @endauth
        </x-buttons-bar>
        <h1>Users</h1>
        <x-static-message />
        <div class="row g-2">
            @foreach($users as $user)
                <x-user-card :user="$user" />
            @endforeach
        </div>
    </x-card>
</x-layout> 