<x-admin-card>

    <x-edit-company-buttons :company="$company"/>

    <h1>Edit family information</h1>
    <div class="w-100 justify-content-center">
        <form action="/dashboard/companies/store/family" method="POST" class="w-50">
            @csrf
            @method('PUT')

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

            <button type="submit" class="btn btn-success btn-sm">
                <i class="fa-regular fa-floppy-disk"></i> Save changes
            </button>

        </form>
    </div>
</x-admin-card>