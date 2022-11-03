{{-- Buttons bar --}}
<x-buttons-bar>
    <a class="btn btn-primary btn-sm" href="{{url()->previous()}}">
        <i class="fa-solid fa-arrow-left"></i> Back
    </a>

    <a class="btn btn-success btn-sm" href="/dashboard/companies/{{$company->hex}}/edit/general">
        <i class="fa-solid fa-list"></i> Edit general
    </a>

    <a class="btn btn-secondary btn-sm" href="/dashboard/companies/{{$company->hex}}/edit/image">
        <i class="fa-solid fa-image"></i> Change image
    </a>

    <a class="btn btn-danger btn-sm" href="/dashboard/companies/{{$company->hex}}/edit/address">
        <i class="fa-solid fa-location-dot"></i> Edit address
    </a>

    <a class="btn btn-warning btn-sm" href="/dashboard/companies/{{$company->hex}}/edit/family">
        <i class="fa-solid fa-users"></i> Edit family information
    </a>

    <a class="btn btn-info btn-sm" href="/dashboard/companies/{{$company->hex}}/edit/details">
        <i class="fa-solid fa-address-card"></i> Edit further details
    </a>
</x-buttons-bar>