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
            <label for="title">Registered name</label>
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

            <button type="submit" class="btn btn-success btn-sm">
                Create company
            </button>

        </form>
    </div>
</x-admin-card>