<x-layout>
    <x-card>
        {{-- Buttons bar --}}
        <x-buttons-bar>
            <a class="btn btn-primary btn-sm" href="{{url()->previous()}}">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
        </x-buttons-bar>
        <h1>Register</h1>
        <form action="/users/create" method="post" class="w-25">
            @csrf
            
            <label for="first_name">
                First name
            </label>
            <input type="text" class="form-control mb-3" name="first_name" placeholder="First name" value="{{old('first_name')}}">
            @error('first_name')
                <p>{{$message}}</p>
            @enderror

            <label for="last_name">
                Last name
            </label>
            <input type="text" class="form-control mb-3" name="last_name" placeholder="Last name" value="{{old('last_name')}}">
            @error('last_name')
                <p>{{$message}}</p>
            @enderror

            <label for="email">
                Email
            </label>
            <input type="email" class="form-control mb-3" name="email" placeholder="Email" value="{{old('email')}}">
            @error('email')
                <p>{{$message}}</p>
            @enderror

            <label for="password">
                Password
            </label>
            <input type="password" class="form-control mb-3" name="password" placeholder="Password" value="{{old('password')}}">
            @error('password')
                <p>{{$message}}</p>
            @enderror

            <label for="password_confirmation">
                Confirm password
            </label>
            <input type="password" class="form-control mb-3" name="password_confirmation" placeholder="Confirm password" value="{{old('password_confirmation')}}">

            <button type="submit" class="btn btn-success">
                Create user
            </button>

            <p>Already have an account? <a href="/login">Log in</a></p>

        </form>
    </x-card>
</x-layout>