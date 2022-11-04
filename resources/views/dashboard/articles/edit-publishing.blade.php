<x-admin-card>

    <x-article-edit-buttons :article="$article"/>

        <h1>Edit article</h1>
        <div class="w-100 justify-content-center">
            <form action="/dashboard/articles/{{$article->hex}}/update" method="POST" enctype="multipart/form-data" class="w-50">
                @csrf
                @method('PUT')

                <input type="hidden" name="hex" value="{{$article->hex}}">

                {{-- Article status --}}
                <label for="status">Status</label>
                <select 
                    name="status" 
                    class="form-select mb-3"
                >
                    <option value="private" {{($article->status == 'private') ? 'selected' : null}}>Private</option>
                    <option value="public" {{($article->status == 'public') ? 'selected' : null}}>Public</option>
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
