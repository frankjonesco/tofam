<x-admin-card>

    <x-category-edit-buttons :category="$category"/>

        <h1>Edit text</h1>
        <div class="w-100 justify-content-center">
            <form action="/dashboard/categories/update/image" method="POST" class="w-50" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="hidden" name="hex" value="{{$category->hex}}">

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

                <button type="submit" class="btn btn-success btn-sm">
                    <i class="fa-regular fa-floppy-disk"></i> Save changes
                </button>

            </form>
        </div>
</x-admin-card>

