<x-layout>
    <x-card>
        {{-- Buttons bar --}}
        <x-buttons-bar>
            <a class="btn btn-primary btn-sm" href="{{url()->previous()}}">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
        </x-buttons-bar>
        <h1>Change password</h1>

        <form action="/dashboard/users/{{$user->hex}}/password" method="post" class="w-25">
            @csrf
            @method('PUT')
            {{-- Old password --}}
            <label for="old_password">
                Old password
            </label>
            <input type="password" class="form-control mb-3" name="old_password" placeholder="Old password">
            @error('old_password')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- New password --}}
            <label for="new_password">
                New password
            </label>
            <input type="password" class="form-control mb-3" name="new_password" placeholder="New password">
            @error('new_password')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- New password confirmation --}}
            <label for="new_password_confirmation">
                Confirm new password
            </label>
            <input type="password" class="form-control mb-3" name="new_password_confirmation" placeholder="Confirm new password">

            {{-- Submit --}}
            <button type="submit" class="btn btn-success btn-sm mb-2">
                Save changes
            </button>

        </form>
    </x-card>
</x-layout>