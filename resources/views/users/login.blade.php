<x-layout>
    <x-card>
        {{-- Buttons bar --}}
        <x-buttons-bar>
            <a class="btn btn-primary btn-sm" href="{{url()->previous()}}">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
        </x-buttons-bar>

        <h1>Log in</h1>
        <x-static-message />
        <form action="/users/authenticate" method="post" class="w-25">
            @csrf

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

            <button type="submit" class="btn btn-success">
                Log in
            </button>

            <p>Don't have an account? <a href="/register">Register</a></p>

        </form>
    </x-card>
</x-layout>