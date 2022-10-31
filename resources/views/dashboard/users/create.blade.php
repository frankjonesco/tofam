<x-admin-card>
        {{-- Buttons bar --}}
        <x-buttons-bar>
            <a class="btn btn-primary btn-sm" href="{{url()->previous()}}">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
        </x-buttons-bar>

        <h1>Create user</h1>

        <form action="/dashboard/users/store" method="post" class="w-25" enctype="multipart/form-data">
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

            {{-- Gender --}}
            <label for="gender">Gender</label>
            <select 
                name="gender" 
                class="form-select mb-3"
            >   
                <option value="" disabled selected>Select a gender</option>
                <option value="male" {{old('gender') == 'male' ? 'selected' : null}}>Male</option>
                <option value="female" {{old('gender') == 'female' ? 'selected' : null}}>Female</option>
                <option value="trans" {{old('gender') == 'trans' ? 'selected' : null}}>Trans</option>
                <option value="prefer_not_to_say" {{old('gender') == 'prefer_not_to_say' ? 'selected' : null}}>Prefer not to say</option>
            </select>
            @error('gender')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- User type --}}
            <label for="user_type_id">User type</label>
            <select 
                name="user_type_id" 
                class="form-select mb-3"
            >   
                <option value="" disabled selected>Select a user type</option>
                @foreach($user_types as $user_type)
                    <option value="{{$user_type->id}}" {{old('user_type_id') == $user_type->id ? 'selected' : null}}>{{$user_type->name}}</option>
                @endforeach
                
            </select>
            @error('user_type_id')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Image --}}
            <label for="image">Image</label>
            <input 
                type="file"
                class="form-control mb-3"
                name="image"
            >
            @error('image')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Country --}}
            <label for="country">Country</label>
            <select 
                name="country" 
                class="form-select mb-3"
            >   
                <option value="" disabled selected>Select a country</option>
                @foreach($countries as $country)
                    <option value="{{$country->iso}}" {{old('country') == $country->iso ? 'selected' : null}}>{{$country->name}}</option>
                @endforeach
                
            </select>
            @error('country')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Username --}}
            <label for="username">
                Username
            </label>
            <input type="text" class="form-control mb-3" name="username" placeholder="Username" value="{{old('username')}}">
            @error('username')
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
            <input type="password" class="form-control mb-3" name="password" placeholder="Password">
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
                Create user
            </button>

        </form>

</x-admin-card>