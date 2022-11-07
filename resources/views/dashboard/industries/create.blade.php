<x-admin-card>

        <h1>Create new industry</h1>
        <div class="w-100 justify-content-center">
            <form action="/dashboard/industries/store" method="POST" class="w-50">
                @csrf

                {{-- Industry name --}}
                <label for="name">Industry name</label>
                <input 
                    id="industryName"
                    type="text"
                    name="name"
                    class="form-control mb-3 input-sm"
                    placeholder="Industry name"
                    value="{{old('name')}}"
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
                    value="{{old('slug')}}"
                    disabled
                >
                @error('slug')
                    <p class="text-danger">{{$message}}</p>
                @enderror

                {{-- Industry description --}}
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

                {{-- Industry status --}}
                <label for="status">Status</label>
                <select 
                    name="status" 
                    class="form-select mb-3"
                >
                    <option value="private" {{old('status') == 'private' ? 'selected' : null}}>Private</option>
                    <option value="public" {{old('status') == 'public' ? 'selected' : null}}>Public</option>
                </select>
                @error('status')
                    <p class="text-danger">{{$message}}</p>
                @enderror

                <button type="submit" class="btn btn-success btn-sm">
                    <i class="fa fa-industry"></i> Create industry
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