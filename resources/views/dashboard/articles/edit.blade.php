<x-admin-card>
        {{-- Buttons bar --}}
        <x-buttons-bar>
            <a class="btn btn-primary btn-sm" href="{{url()->previous()}}">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
        </x-buttons-bar>
        <h1>Edit article</h1>
        <div class="w-100 justify-content-center">
            <form action="/dashboard/articles/{{$article->hex}}/update" method="POST" enctype="multipart/form-data" class="w-50">
                @csrf
                @method('PUT')

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

                {{-- Article category --}}
                <label for="category">Category</label>
                <select 
                    name="category" 
                    class="form-select mb-3"
                >
                    <option value="">Select category</option>
                    
                    @if(count($categories) > 0)
                        @foreach($categories as $category)
                            <option value="{{$category->id}}" {{$category->id == $article->category_id ? 'selected' : null}}>{{$category->name}}</option>
                        @endforeach
                    @endif
                    
                </select>
                @error('category')
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
                    Update artilce
                </button>

            </form>
        </div>
</x-admin-card>
