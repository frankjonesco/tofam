<x-admin-card>
    <x-company-edit-buttons :company="$company" />
    <h1>Edit contact information</h1>
    <div class="w-100 justify-content-center">
        <form action="/dashboard/companies/update/contact" method="POST" class="w-50">
            @csrf
            @method('PUT')

            {{-- Hexes --}}
            <input type="hidden" name="company_hex" value="{{$company->hex}}">
            <input type="hidden" name="contact_hex" value="{{$contact->hex}}">

            {{-- Salutation --}}
            <label for="registered_name">Salutation</label>
            <input 
                type="text"
                name="salutation"
                class="form-control mb-3"
                placeholder="Salutation"
                value="{{old('salutation') ?? $contact->salutation}}"
            >
            @error('salutation')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- First name --}}
            <label for="first_name">First name</label>
            <input 
                type="text"
                name="first_name"
                class="form-control mb-3"
                placeholder="First name"
                value="{{old('first_name') ?? $contact->first_name}}"
            >
            @error('first_name')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Last name --}}
            <label for="last_name">Last name</label>
            <input 
                type="text"
                name="last_name"
                class="form-control mb-3"
                placeholder="Last name"
                value="{{old('last_name') ?? $contact->last_name}}"
            >
            @error('last_name')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Gender --}}
            <label for="gender">Gender</label>
            <select name="gender" class="form-select mb-3">
                <option value="" selected disabled>Select a gender</option>
                <option value="male" {{($contact->gender == 'male') ? 'selected' : null}}>Male</option>
                <option value="female" {{($contact->gender == 'female') ? 'selected' : null}}>Female</option>
            </select>
            @error('gender')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Job title --}}
            <label for="job_title">Job title</label>
            <input 
                type="text"
                name="job_title"
                class="form-control mb-3"
                placeholder="Job title"
                value="{{old('job_title') ?? $contact->job_title}}"
            >
            @error('job_title')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Department --}}
            <label for="department">Department</label>
            <select name="department" class="form-select mb-3">
                <option value="" selected disabled>Select a department</option>
                <option value="press" {{($contact->department == 'press') ? 'selected' : null}}>Press</option>
                <option value="management" {{($contact->department == 'management') ? 'selected' : null}}>Management</option>
            </select>
            @error('gender')
                <p class="text-danger">{{$message}}</p>
            @enderror
            @error('department')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Email --}}
            <label for="email">Email</label>
            <input 
                type="text"
                name="email"
                class="form-control mb-3"
                placeholder="Email"
                value="{{old('email') ?? $contact->email}}"
            >
            @error('email')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Phone --}}
            <label for="phone">Phone</label>
            <input 
                type="text"
                name="phone"
                class="form-control mb-3"
                placeholder="Phone"
                value="{{old('phone') ?? $contact->phone}}"
            >
            @error('phone')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Mobile --}}
            <label for="mobile">Mobile</label>
            <input 
                type="text"
                name="mobile"
                class="form-control mb-3"
                placeholder="Mobile"
                value="{{old('mobile') ?? $contact->mobile}}"
            >
            @error('mobile')
                <p class="text-danger">{{$message}}</p>
            @enderror

            <button type="submit" class="btn btn-success btn-sm">
                <i class="fa-regular fa-floppy-disk"></i> Save changes
            </button>

        </form>
    </div>
</x-admin-card>