<x-admin-card>
    
    <x-edit-company-buttons :company="$company"/>

    <h1>Edit general information</h1>
    <div class="w-100 justify-content-center">
        <form action="/dashboard/companies/store/general" method="POST" class="w-50">
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

            <button type="submit" class="btn btn-success btn-sm">
                <i class="fa-regular fa-floppy-disk"></i> Save changes
            </button>

        </form>
    </div>
</x-admin-card>