<x-admin-cad>
        {{-- Buttons bar --}}
        <x-buttons-bar>
            <a class="btn btn-primary btn-sm" href="{{url()->previous()}}">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
        </x-buttons-bar>

        <h1>Edit user</h1>

        <form action="/dashboard/users/{{$user->hex}}/update" method="post" class="w-25" enctype="multipart/form-data">
            @csrf
            @method('PUT')
                           
            {{-- First name --}}
            <label for="first_name">
                First name
            </label>
            <input type="text" class="form-control mb-3" name="first_name" placeholder="First name" value="{{$user->first_name}}">
            @error('first_name')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Last name --}}
            <label for="last_name">
                Last name
            </label>
            <input type="text" class="form-control mb-3" name="last_name" placeholder="Last name" value="{{old('last_name') ? old('last_name') : $user->last_name}}">
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
                <option value="male" {{$user->gender == 'male' ? 'selected' : null}}>Male</option>
                <option value="female" {{$user->gender == 'female' ? 'selected' : null}}>Female</option>
                <option value="trans" {{$user->gender == 'trans' ? 'selected' : null}}>Trans</option>
                <option value="prefer_not_to_say" {{$user->gender == 'prefer_not_to_say' ? 'selected' : null}}>Prefer not to say</option>
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
                    <option value="{{$user_type->id}}" {{$user->user_type_id == $user_type->id ? 'selected' : null}}>{{$user_type->name}}</option>
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

            <img 
                src="{{$user->image ? asset('images/users/'.$user->hex.'/tn-'.$user->image) : asset('images/no-image.png')}}" 
                alt=""
                class="mb-3 w-100"
            >

            {{-- Country --}}
            <label for="country_iso">Country</label>
            <select 
                name="country_iso" 
                class="form-select mb-3"
            >   
                <option value="" disabled selected>Select a country</option>
                @foreach($countries as $country)
                    <option value="{{$country->iso}}" {{$user->country_iso == $country->iso ? 'selected' : null}}>{{$country->name}}</option>
                @endforeach
                
            </select>
            @error('country_iso')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Username --}}
            <label for="username">
                Username
            </label>
            <input type="text" class="form-control mb-3" name="username" placeholder="Username" value="{{$user->username}}">
            @error('username')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Email --}}
            <label for="email">
                Email
            </label>
            <input type="email" class="form-control mb-3" name="email" placeholder="Email" value="{{$user->email}}">
            @error('email')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Submit --}}
            <button type="submit" class="btn btn-success btn-sm mb-2">
                Update user
            </button>

            <p>Want to change your password? <a href="/dashboard/users/{{$user->hex}}/password">Click here</a></p>

        </form>

</x-admin-cad>