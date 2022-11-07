<x-admin-card>
    <x-industry-edit-buttons :industry="$industry"/>
        <h1>Edit industry</h1>
        <div class="w-100 justify-content-center">
            <form action="/dashboard/industries/update" method="POST" class="w-50">
                @csrf
                @method('PUT')

                <input type="hidden" name="hex" value="{{$industry->hex}}">

                {{-- Industry name --}}
                <label for="name">Industry name</label>
                <input 
                    id="industryName"
                    type="text"
                    name="name"
                    class="form-control mb-3 input-sm"
                    placeholder="Industry name"
                    value="{{old('name') ? old('name') : $industry->name}}"
                    oninput="updateSlug(this)"
                >
                @error('name')
                    <p class="text-danger">{{$message}}</p>
                @enderror

                {{-- Industry slug --}}
                <label for="slug">Slug</label>
                <input 
                    id="industrySlug"
                    type="text"
                    name="slug"
                    class="form-control mb-3 input-sm"
                    placeholder="Industry name"
                    value="{{old('slug') ? old('slug') : $industry->slug}}"
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
                >{{old('description') ? old('description') : $industry->description}}</textarea>
                @error('description')
                    <p class="text-danger">{{$message}}</p>
                @enderror

                {{-- Industry status --}}
                <label for="status">Status</label>
                <select 
                    name="status" 
                    class="form-select mb-3"
                >
                    <option value="private" {{(old('status') || $industry->status) == 'private' ? 'selected' : null}}>Private</option>
                    <option value="public" {{(old('status') || $industry->status) == 'public' ? 'selected' : null}}>Public</option>
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

<script>

    function updateSlug(name){
        // console.log(fox.value);
        
        industrySlug = document.getElementById('industrySlug');
        
        nameValue = name.value;

        nameValue = nameValue.toLowerCase();

        // Spaces to dashes
        nameValue = nameValue.replace(/\s+/g, '-');

        nameValue = nameValue.replace('ä', 'ae');
        nameValue = nameValue.replace('ö', 'oe');
        nameValue = nameValue.replace('ü', 'ue');
        nameValue = nameValue.replace('ß', 'ss');

        nameValue = nameValue.replace(/[^a-zA-Z0-9,;\- ]/g, '');

        industrySlug.value = nameValue;
    }

</script>