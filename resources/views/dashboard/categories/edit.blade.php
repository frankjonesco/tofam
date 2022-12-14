<x-admin-card>
        {{-- Buttons bar --}}
        <x-buttons-bar>
            <a class="btn btn-primary btn-sm" href="{{url()->previous()}}">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
        </x-buttons-bar>
        <h1>Edit category</h1>
        <div class="w-100 justify-content-center">
            <form action="/dashboard/categories/{{$category->hex}}/update" method="POST" class="w-50" enctype="multipart/form-data">
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

                <img 
                    src="{{$category->image ? asset('images/categories/'.$category->hex.'/tn-'.$category->image) : asset('images/no-image.png')}}" 
                    alt=""
                    class="mb-3 w-100"
                >

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
                    <i class="fa-regular fa-floppy-disk"></i> Save changes
                </button>

            </form>
        </div>
</x-admin-card>