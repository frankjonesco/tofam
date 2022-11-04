<x-admin-card>

    <x-category-edit-buttons :category="$category"/>

        <h1>Edit text</h1>
        <div class="w-100 justify-content-center">
            <form action="/dashboard/categories/update/publishing" method="POST" class="w-50">
                @csrf
                @method('PUT')

                <input type="hidden" name="hex" value="{{$category->hex}}">

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

