<x-admin-card>

    <x-article-edit-buttons :article="$article"/>

        <h1>Edit general</h1>
        <div class="w-100 justify-content-center">
            <form action="/dashboard/articles/update/text" method="POST" class="w-50">
                @csrf
                @method('PUT')

                <input type="hidden" name="hex" value="{{$article->hex}}">

                {{-- Article title --}}
                <label for="title">Title</label>
                <input 
                    type="text"
                    name="title"
                    class="form-control mb-3 input-sm"
                    placeholder="Article title"
                    value="{{old('title') ? old('title') : $article->title}}"
                >
                @error('title')
                    <p class="text-danger">{{$message}}</p>
                @enderror

                {{-- Article caption --}}
                <label for="caption">Caption</label>
                <input 
                    type="text"
                    name="caption"
                    class="form-control mb-3"
                    placeholder="Article caption"
                    value="{{old('caption') ? old('caption') : $article->caption}}"
                >
                @error('caption')
                    <p class="text-danger">{{$message}}</p>
                @enderror

                {{-- Article teaser --}}
                <label for="teaser">Teaser</label>
                <input 
                    type="text"
                    name="teaser"
                    class="form-control mb-3" 
                    placeholder="Article teaser" 
                    value="{{old('teaser') ? old('teaser') : $article->teaser}}"
                >
                @error('teaser')
                    <p class="text-danger">{{$message}}</p>
                @enderror

                {{-- Article body --}}
                <label for="body">Body</label>
                <textarea 
                    name="body"
                    class="form-control mb-3" 
                    rows="5" 
                    placeholder="Article body"
                >{{old('body') ? old('body') : $article->body}}</textarea>
                @error('body')
                    <p class="text-danger">{{$message}}</p>
                @enderror

                {{-- Article tags --}}
                <label for="tags">Tags <i>(separated by a comma)</i></label>
                <input 
                    type="text"
                    name="tags"
                    class="form-control mb-3" 
                    placeholder="Article tags" 
                    value="{{old('tags') ? old('tags') : str_replace(',', ', ', $article->tags)}}"
                >
                @error('tags')
                    <p class="text-danger">{{$message}}</p>
                @enderror

                <button type="submit" class="btn btn-success btn-sm">
                    <i class="fa-regular fa-floppy-disk"></i> Save changes
                </button>

            </form>
        </div>
</x-admin-card>
