<x-admin-card>
    
    <x-edit-company-buttons :company="$company"/>

    <h1>Edit company</h1>
    <div class="w-100 justify-content-center">
        <form action="/dashboard/companies/store" method="POST" enctype="multipart/form-data" class="w-50">
            @csrf
            @method('PUT')

            {{-- Registered name --}}
            <label for="registered_name">Registered name</label>
            <input 
                type="text"
                name="registered_name"
                class="form-control mb-3"
                placeholder="Registered name"
                value="{{old('registered_name') ? $company->registered_name : $company->registered_name}}"
            >
            @error('registered_name')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Trading name --}}
            <label for="trading_name">Trading name</label>
            <input 
                type="text"
                name="trading_name"
                class="form-control mb-3"
                placeholder="Trading name"
                value="{{old('trading_name') ?? $company->trading_name}}"
            >
            @error('trading_name')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Parent organization name --}}
            <label for="parent_organization">Parent organization</label>
            <input 
                type="text"
                name="parent_organization"
                class="form-control mb-3"
                placeholder="Parent organization"
                value="{{old('parent_organization') ?? $company->parent_organization}}"
            >
            @error('parent_organization')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Headquarters --}}
            <label for="headquarters">Headquarters</label>
            <input 
                type="text"
                name="headquarters"
                class="form-control mb-3"
                placeholder="Headquarters"
                value="{{old('headquarters') ?? $company->headquarters}}"
            >
            @error('headquarters')
                <p class="text-danger">{{$message}}</p>
            @enderror


            {{-- Website --}}
            <label for="website">Website</label>
            <input 
                type="text"
                name="website"
                class="form-control mb-3"
                placeholder="Website"
                value="{{old('website') ?? $company->website}}"
            >
            @error('website')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Description --}}
            <label for="description">Description</label>
            <textarea 
                name="description"
                class="form-control mb-3" 
                rows="5"
                placeholder="Description"
            >{{old('description') ?? $company->description}}</textarea>
            @error('description')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Founded in --}}
            <label for="founded_in">Founded in</label>
            <input 
                type="text"
                name="founded_in"
                class="form-control mb-3"
                placeholder="YYYY"
                value="{{old('founded_in') ?? $company->founded_in}}"
            >
            @error('founded_in')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Founded by --}}
            <label for="founded_by">Founded by</label>
            <input 
                type="text"
                name="founded_by"
                class="form-control mb-3"
                placeholder="Founded by"
                value="{{old('founded_by') ?? $company->founded_by}}"
            >
            @error('founded_by')
                <p class="text-danger">{{$message}}</p>
            @enderror
            
            <h2>Address details</h2>

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


            <h2>Family details</h2>

            {{-- Family business --}}
            <label for="address_phone">Is the company a family business?</label>
            <select name="family_buisiness" class="form-select mb-3">
                <option value="" selected disabled>Please select...</option>
                <option value="1">Yes</option>
                <option value="">No</option>
            </select>
            @error('family_name')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Family name --}}
            <label for="family_name">Family name</label>
            <input 
                type="text"
                name="family_name"
                class="form-control mb-3"
                placeholder="Family name"
                value="{{old('family_name') ?? $company->family_name}}"
            >
            @error('family_name')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Family generations --}}
            <label for="family_generations">Generations</label>
            <input 
                type="text"
                name="family_generations"
                class="form-control mb-3"
                placeholder="Generations"
                value="{{old('family_generations') ?? $company->family_generations}}"
            >
            @error('family_generations')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Family executive --}}
            <label for="family_executive">Does the company have a family executive?</label>
            <select name="family_buisiness" class="form-select mb-3">
                <option value="" selected disabled>Please select...</option>
                <option value="1">Yes</option>
                <option value="">No</option>
            </select>
            @error('family_executive')
                <p class="text-danger">{{$message}}</p>
            @enderror


            <h2>Additional information</h2>

            {{-- Female executive --}}
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="1" name="female_executive">
                <label class="form-check-label" for="female_executive">
                    Female executive
                </label>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="1" name="stock_exchange">
                <label class="form-check-label" for="stock_exchange">
                    Listed on stock exchange
                </label>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="1" name="matchbird_partner">
                <label class="form-check-label" for="matchbird_partner">
                    Matchbird partner
                </label>
            </div>

            <button type="submit" class="btn btn-success btn-sm">
                <i class="fa-regular fa-floppy-disk"></i> Save changes
            </button>

        </form>
    </div>
</x-admin-card>