<x-admin-card>

    <x-edit-company-buttons :company="$company"/>

    <h1>Change image</h1>
    <div class="w-100 justify-content-center">
        <form action="/dashboard/companies/update/image" method="POST" class="w-50" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" name="hex" value="{{$company->hex}}">

            {{-- Family image --}}
            <label for="address_phone">Is the company a family business?</label>
            <input
                type="file"
                class="form-control mb-3"
                name="image"
            >
            @error('image')
                <p class="text-danger">{{$message}}</p>
            @enderror

            <button type="submit" class="btn btn-success btn-sm">
                <i class="fa-regular fa-floppy-disk"></i> Upload & save image
            </button>

        </form>
    </div>
</x-admin-card>