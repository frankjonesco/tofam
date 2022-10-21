<x-layout>
    <x-card>
        {{-- Buttons bar --}}
        <x-buttons-bar>
            <a class="btn btn-primary btn-sm" href="{{url()->previous()}}">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
        </x-buttons-bar>
        <h1>Create account</h1>
        <form action="/dashboard/users/store" method="post" class="w-25">
            @csrf
            
            {{-- First name --}}
            <label for="first_name">
                First name
            </label>
            <input type="text" class="form-control mb-3" name="first_name" placeholder="First name" value="{{old('first_name')}}">
            @error('first_name')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Last name --}}
            <label for="last_name">
                Last name
            </label>
            <input type="text" class="form-control mb-3" name="last_name" placeholder="Last name" value="{{old('last_name')}}">
            @error('last_name')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Email --}}
            <label for="email">
                Email
            </label>
            <input type="email" class="form-control mb-3" name="email" placeholder="Email" value="{{old('email')}}">
            @error('email')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Password --}}
            <label for="password">
                Password
            </label>
            <input type="password" class="form-control mb-3" name="password" placeholder="Password" value="{{old('password')}}">
            @error('password')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Password confirmation --}}
            <label for="password_confirmation">
                Confirm password
            </label>
            <input type="password" class="form-control mb-3" name="password_confirmation" placeholder="Confirm password" value="{{old('password_confirmation')}}">

            {{-- Submit --}}
            <button type="submit" class="btn btn-success btn-sm mb-2">
                Create account
            </button>

            <p>Already have an account? <a href="/login">Log in</a></p>

        </form>
    </x-card>
</x-layout>