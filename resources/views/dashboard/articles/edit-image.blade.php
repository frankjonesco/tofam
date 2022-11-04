<x-admin-card>

    <x-article-edit-buttons :article="$article"/>

        <h1>Edit image</h1>
        <div class="w-100 justify-content-center">
            <form action="/dashboard/articles/update/image" method="POST" enctype="multipart/form-data" class="w-50">
                @csrf
                @method('PUT')

                <input type="hidden" name="hex" value="{{$article->hex}}">

                {{-- Article image --}}
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
                    src="{{$article->image ? asset('images/articles/'.$article->hex.'/tn-'.$article->image) : asset('images/no-image.png')}}" 
                    alt=""
                    class="mb-3 w-100"
                >

           

                <button type="submit" class="btn btn-success btn-sm">
                    <i class="fa-regular fa-floppy-disk"></i> Save changes
                </button>

            </form>
        </div>
</x-admin-card>
