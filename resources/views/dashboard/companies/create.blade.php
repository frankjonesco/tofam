<x-admin-card>

    {{-- Buttons bar --}}
    <x-buttons-bar>
        <a class="btn btn-primary btn-sm" href="{{url()->previous()}}">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
    </x-buttons-bar>

    <h1>Create company</h1>
    <div class="w-100 justify-content-center">
        <form action="/dashboard/companies/store" method="POST" enctype="multipart/form-data" class="w-50">
            @csrf

            {{-- Registered name --}}
            <label for="registered_name">Registered name</label>
            <input 
                type="text"
                name="registered_name"
                class="form-control mb-3"
                placeholder="Registered name"
                value="{{old('registered_name')}}"
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
                value="{{old('trading_name')}}"
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
                value="{{old('parent_organization')}}"
            >
            @error('parent_organization')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Founded in --}}
            <label for="founded_in">Founded in</label>
            <input 
                type="text"
                name="founded_in"
                class="form-control mb-3"
                placeholder="YYYY"
                value="{{old('founded_in')}}"
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
                value="{{old('founded_by')}}"
            >
            @error('founded_by')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Headquarters --}}
            <label for="headquarters">Headquarters</label>
            <input 
                type="text"
                name="headquarters"
                class="form-control mb-3"
                placeholder="Headquarters"
                value="{{old('headquarters')}}"
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
                value="{{old('website')}}"
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
            >{{old('description')}}</textarea>
            @error('description')
                <p class="text-danger">{{$message}}</p>
            @enderror

            <button type="submit" class="btn btn-success btn-sm">
                Create company
            </button>

        </form>
    </div>
</x-admin-card>