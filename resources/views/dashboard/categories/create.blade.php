<x-layout>
    <x-card>
        {{-- Buttons bar --}}
        <x-buttons-bar>
            <a class="btn btn-primary btn-sm" href="{{url()->previous()}}">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
        </x-buttons-bar>
        <h1>Create category</h1>
        <div class="w-100 justify-content-center">
            <form action="/dashboard/categories/store" method="POST" class="w-25" enctype="multipart/form-data">
                @csrf

                {{-- Category name --}}
                <label for="title">Name</label>
                <input 
                    type="text"
                    name="name"
                    class="form-control mb-3"
                    placeholder="Category name"
                    value="{{old('name')}}"
                >
                @error('name')
                    <p class="text-danger">{{$message}}</p>
                @enderror

                {{-- Category description --}}
                <label for="description">Description</label>
                <textarea 
                    name="description"
                    class="form-control mb-3" 
                    rows="5" 
                    placeholder="Category description"
                >{{old('description')}}</textarea>
                @error('description')
                    <p class="text-danger">{{$message}}</p>
                @enderror

                {{-- Category image --}}
                <label for="image">Image</label>
                <input 
                    type="file"
                    class="form-control mb-3"
                    name="image"
                >
                @error('image')
                    <p class="text-danger">{{$message}}</p>
                @enderror

                {{-- Category status --}}
                <label for="status">Status</label>
                <select 
                    name="status" 
                    class="form-select mb-3"
                >
                    <option value="private">Private</option>
                    <option value="public">Public</option>
                </select>
                @error('status')
                    <p class="text-danger">{{$message}}</p>
                @enderror

                <button type="submit" class="btn btn-success btn-sm">
                    Create category
                </button>

            </form>
        </div>
    </x-card>
</x-layout>