<x-admin-card>

    <x-company-edit-buttons :company="$company"/>

    <h1>Edit publish settings</h1>
    <div class="w-100 justify-content-center">
        <form action="/dashboard/companies/update/publishing" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" name="hex" value="{{$company->hex}}">

            <p>Created: {{$company->created_at}}</p>
            <p>Updated: {{$company->updated_at}}</p>

            {{-- Hex --}}
            <label for="hex">Company HEX (unique ID)</label>
            <input class="form-control mb-3" type="text" name="hex" value="{{$company->hex}}" disabled>

            {{-- Hex --}}
            <label for="hex">Company slug</label>
            <input class="form-control mb-3" type="text" name="slug" value="{{$company->slug}}" disabled>

            {{-- Hex --}}
            <label for="force_slug">Force company slug</label>
            <input class="form-control mb-3" type="text" name="force_slug" value="{{$company->force_slug}}">

            {{-- Tofam status --}}
            <label for="tofam_status">TOFAM status</label>
            <select name="tofam_status" class="form-select mb-3">
                <option value="" selected disabled>Select TOFAM status...</option>
                <option value="in" {{$company->tofam_status == 'in' ? 'selected' : null}}>In</option>
                <option value="out" {{$company->tofam_status == 'out' ? 'selected' : null}}>Out</option>
            </select>
            @error('tofam_status')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Status --}}
            <label for="status">Status</label>
            <select name="status" class="form-select mb-3">
                <option value="" selected disabled>Select status...</option>
                <option value="public" {{$company->status == 'public' ? 'selected' : null}}>Public</option>
                <option value="private" {{$company->status == 'private' ? 'selected' : null}}>Private</option>
                <option value="unlisted" {{$company->status == 'unlisted' ? 'selected' : null}}>Unlisted</option>
            </select>
            @error('tofam_status')
                <p class="text-danger">{{$message}}</p>
            @enderror

            
            <button type="submit" class="btn btn-success btn-sm">
                <i class="fa-regular fa-floppy-disk"></i> Save changes
            </button>

        </form>
    </div>
</x-admin-card>