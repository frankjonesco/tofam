<x-admin-card>

    <x-article-edit-buttons :article="$article"/>

        <h1>Edit storage</h1>
        <div class="w-100 justify-content-center">
            <form action="/dashboard/articles/update/storage" method="POST" class="w-50">
                @csrf
                @method('PUT')

                <input type="hidden" name="hex" value="{{$article->hex}}">

                {{-- Article category --}}
                <label for="category_id">Category</label>
                <select 
                    name="category_id" 
                    class="form-select mb-3"
                >
                    <option value="">Uncategorized</option>
                    @if(count($categories) > 0)
                        @foreach($categories as $category)
                            <option value="{{$category->id}}" {{$category->id == $article->category_id ? 'selected' : null}}>{{$category->name}}</option>
                        @endforeach
                    @endif    
                </select>

                @error('category_id')
                    <p class="text-danger">{{$message}}</p>
                @enderror

                <button type="submit" class="btn btn-success btn-sm">
                    <i class="fa-regular fa-floppy-disk"></i> Save changes
                </button>

            </form>
        </div>
</x-admin-card>
