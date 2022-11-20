<x-admin-card>

    <x-category-edit-buttons :category="$category"/>

        <h1>Edit text</h1>
        <div class="w-100 justify-content-center">
            <form action="/dashboard/categories/update/text" method="POST" class="w-50">
                @csrf
                @method('PUT')

                <input type="hidden" name="hex" value="{{$category->hex}}">

                {{-- Category name --}}
                <label for="name">Category name</label>
                <input 
                    id="categoryName"
                    type="text"
                    name="name"
                    class="form-control mb-3 input-sm"
                    placeholder="Category name"
                    value="{{old('title') ? old('title') : $category->name}}"
                    oninput="updateSlug(this)"
                >
                @error('name')
                    <p class="text-danger">{{$message}}</p>
                @enderror

                {{-- Category slug --}}
                <label for="slug">Slug</label>
                <input 
                    id="categorySlug"
                    type="text"
                    name="slug"
                    class="form-control mb-3 input-sm"
                    placeholder="Category name"
                    value="{{old('slug') ? old('slug') : $category->slug}}"
                    disabled
                >
                @error('slug')
                    <p class="text-danger">{{$message}}</p>
                @enderror

                {{-- Category description --}}
                <label for="description">Description</label>
                <textarea 
                    name="description"
                    class="form-control mb-3" 
                    rows="5" 
                    placeholder="Description"
                >{{old('description') ? old('description') : $category->description}}</textarea>
                @error('description')
                    <p class="text-danger">{{$message}}</p>
                @enderror

                <button type="submit" class="btn btn-success btn-sm">
                    <i class="fa-regular fa-floppy-disk"></i> Save changes
                </button>

            </form>
        </div>
</x-admin-card>

<script>

    function updateSlug(name){
        // console.log(fox.value);
        
        categorySlug = document.getElementById('categorySlug');
        
        nameValue = name.value;

        nameValue = nameValue.toLowerCase();

        // Spaces to dashes
        nameValue = nameValue.replace(/\s+/g, '-');

        nameValue = nameValue.replace('ä', 'ae');
        nameValue = nameValue.replace('ö', 'oe');
        nameValue = nameValue.replace('ü', 'ue');
        nameValue = nameValue.replace('ß', 'ss');
        nameValue = nameValue.replace('&', 'and');

        nameValue = nameValue.replace(/[^a-zA-Z0-9,;\- ]/g, '');

        categorySlug.value = nameValue;
    }

</script>