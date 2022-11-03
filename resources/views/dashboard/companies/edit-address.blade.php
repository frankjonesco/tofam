<x-admin-card>
    
    <x-edit-company-buttons :company="$company"/>

    <h1>Edit company address</h1>
    <div class="w-100 justify-content-center">
        <form action="/dashboard/companies/store/address" method="POST" class="w-50">
            @csrf
            @method('PUT')

            {{-- Address building name --}}
            <label for="address_building_name">Address building name</label>
            <input 
                type="text"
                name="address_building_name"
                class="form-control mb-3"
                placeholder="Address building name"
                value="{{old('address_building_name') ?? $company->address_building_name}}"
            >
            @error('address_building_name')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Address number --}}
            <label for="address_number">Address number</label>
            <input 
                type="text"
                name="address_number"
                class="form-control mb-3"
                placeholder="Address number"
                value="{{old('address_number') ?? $company->address_number}}"
            >
            @error('address_number')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Address street --}}
            <label for="address_street">Address street</label>
            <input 
                type="text"
                name="address_street"
                class="form-control mb-3"
                placeholder="Address street"
                value="{{old('address_street') ?? $company->address_street}}"
            >
            @error('address_street')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Address city --}}
            <label for="address_city">Address city</label>
            <input 
                type="text"
                name="address_city"
                class="form-control mb-3"
                placeholder="Address city"
                value="{{old('address_city') ?? $company->address_city}}"
            >
            @error('address_city')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Address state --}}
            <label for="address_state">Address state</label>
            <input 
                type="text"
                name="address_state"
                class="form-control mb-3"
                placeholder="Address state"
                value="{{old('address_state') ?? $company->address_state}}"
            >
            @error('address_state')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Address zip --}}
            <label for="address_zip">Address ZIP</label>
            <input 
                type="text"
                name="address_zip"
                class="form-control mb-3"
                placeholder="Address ZIP"
                value="{{old('address_zip') ?? $company->address_zip}}"
            >
            @error('address_zip')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Address phone --}}
            <label for="address_phone">Address phone</label>
            <input 
                type="text"
                name="address_phone"
                class="form-control mb-3"
                placeholder="Address phone"
                value="{{old('address_phone') ?? $company->address_phone}}"
            >
            @error('address_phone')
                <p class="text-danger">{{$message}}</p>
            @enderror

            <button type="submit" class="btn btn-success btn-sm">
                <i class="fa-regular fa-floppy-disk"></i> Save changes
            </button>

        </form>
    </div>
</x-admin-card>