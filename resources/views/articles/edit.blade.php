<x-layout>
    <x-card>
        {{-- Buttons bar --}}
        <x-buttons-bar>
            <a class="btn btn-primary btn-sm" href="{{url()->previous()}}">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
        </x-buttons-bar>
        <h1>Edit</h1>
        <div class="w-100 justify-content-center">
            <form action="/articles/{{$article->hex}}/update" method="POST" enctype="multipart/form-data" class="w-25">
                @csrf
                @method('PUT')

                {{-- Article title --}}
                <label for="title">Title</label>
                <input 
                    type="text"
                    name="title"
                    class="form-control mb-3"
                    placeholder="Article title"
                    value="{{$article->title}}"
                >
                @error('title')
                    <p>{{$message}}</p>
                @enderror

                {{-- Article caption --}}
                <label for="caption">Caption</label>
                <input 
                    type="text"
                    name="caption"
                    class="form-control mb-3"
                    placeholder="Article caption"
                    value="{{$article->caption}}"
                >
                @error('caption')
                    <p>{{$message}}</p>
                @enderror

                {{-- Article teaser --}}
                <label for="teaser">Teaser</label>
                <input 
                    type="text"
                    name="teaser"
                    class="form-control mb-3" 
                    placeholder="Article teaser" 
                    value="{{$article->teaser}}"
                >
                @error('teaser')
                    <p>{{$message}}</p>
                @enderror

                {{-- Article body --}}
                <label for="body">Body</label>
                <textarea 
                    name="body"
                    class="form-control mb-3" 
                    rows="5" 
                    placeholder="Article body"
                >{{$article->body}}</textarea>
                @error('body')
                    <p>{{$message}}</p>
                @enderror

                {{-- Article image --}}
                <label for="image">Image</label>
                <input 
                    type="file"
                    class="form-control mb-3"
                    name="image"
                >
                @error('image')
                    <p>{{$message}}</p>
                @enderror

                <img 
                    src="{{$article->image ? asset('images/articles/'.$article->hex.'/'.$article->image) : asset('images/no-image.png')}}" 
                    alt=""
                >

                {{-- Article tags --}}
                <label for="tags">Tags <i>(separated by a comma)</i></label>
                <input 
                    type="text"
                    name="tags"
                    class="form-control mb-3" 
                    placeholder="Article tags" 
                    value="{{str_replace(',', ', ', $article->tags)}}"
                >
                @error('tags')
                    <p>{{$message}}</p>
                @enderror


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
                    <p>{{$message}}</p>
                @enderror

                <button type="submit" class="btn btn-success mb-3">
                    Update artilce
                </button>

            </form>
        </div>
    </x-card>
</x-layout>