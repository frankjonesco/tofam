<x-admin-card>
        {{-- Buttons bar --}}
        <x-buttons-bar>
            <a class="btn btn-primary btn-sm" href="/dashboard/color-swatches">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
        </x-buttons-bar>

        
        <div class="w-100">

            {{-- Form for editing colors --}}
            <form action="/dashboard/color-swatches/store" method="POST" enctype="multipart/form-data">
                @csrf
                
                <h1>Create new color swatch</h1>

                {{-- Edit swatch details --}}
                <label for="">Color swatch name</label>
                <input class="form-control input-lg mb-3" name="name" placeholder="Color swatch name" value="{{old('name')}}">
                @error('name')
                    <p class="text-danger">{{$message}}</p>
                @enderror
                <label for="">Decsription</label>
                <textarea class="form-control mb-3" name="description" rows="3" placeholder="Description">{{old('description')}}</textarea>
                @error('description')
                    <p class="text-danger">{{$message}}</p>
                @enderror

                <label for="image">Image</label>
                <input 
                    type="file"
                    class="form-control mb-3"
                    name="image"
                >
                @error('image')
                    <p class="text-danger">{{$message}}</p>
                @enderror
                
                <button type="submit" class="btn btn-sm btn-success">Create swatch</button>
                

            </form>
        </div>
</x-admin-card>