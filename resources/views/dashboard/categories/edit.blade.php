<x-layout>
    <x-card>
        {{-- Buttons bar --}}
        <x-buttons-bar>
            <a class="btn btn-primary btn-sm" href="{{url()->previous()}}">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
        </x-buttons-bar>
        <h1>Edit category</h1>
        <div class="w-100 justify-content-center">
            <form action="/dashboard/categories/{{$category->hex}}/update" method="POST" class="w-25">
                @csrf
                @method('PUT')

                {{-- Category name --}}
                <label for="title">Name</label>
                <input 
                    type="text"
                    name="name"
                    class="form-control mb-3"
                    placeholder="Category name"
                    value="{{$category->name}}"
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
                >{{$category->description}}</textarea>
                @error('description')
                    <p class="text-danger">{{$message}}</p>
                @enderror

                {{-- Category status --}}
                <label for="status">Status</label>
                <select 
                    name="status" 
                    class="form-select mb-3"
                >
                    <option value="private" {{($category->status == 'private') ? 'selected' : null}}>Private</option>
                    <option value="public" {{($category->status == 'public') ? 'selected' : null}}>Public</option>
                </select>
                @error('status')
                    <p class="text-danger">{{$message}}</p>
                @enderror

                <button type="submit" class="btn btn-success btn-sm">
                    Update category
                </button>

            </form>
        </div>
    </x-card>
</x-layout>