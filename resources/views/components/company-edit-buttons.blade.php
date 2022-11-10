<x-buttons-bar>
    <a class="btn btn-primary btn-sm" href="{{url()->previous()}}">
        <i class="fa-solid fa-arrow-left"></i> Back
    </a>
    <a class="btn btn-success btn-sm" href="/dashboard/companies/{{$company->hex}}/edit/general">
        <i class="fa-solid fa-list"></i> Edit general
    </a>
    <a class="btn btn-dark btn-sm" href="/dashboard/companies/{{$company->hex}}/edit/storage">
        <i class="fa-solid fa-folder"></i> Storage
    </a>
    <a class="btn btn-secondary btn-sm" href="/dashboard/companies/{{$company->hex}}/edit/image">
        <i class="fa-solid fa-image"></i> Change image
    </a>
    <a class="btn btn-danger btn-sm" href="/dashboard/companies/{{$company->hex}}/edit/address">
        <i class="fa-solid fa-location-dot"></i> Edit address
    </a>
    <a class="btn btn-warning btn-sm" href="/dashboard/companies/{{$company->hex}}/edit/family-details">
        <i class="fa-solid fa-users"></i> Edit family details   
    </a>
    <a class="btn btn-info btn-sm" href="/dashboard/companies/{{$company->hex}}/edit/further-details">
        <i class="fa-solid fa-address-card"></i> Edit further details
    </a>
    <a class="btn btn-danger btn-sm" href="/dashboard/companies/{{$company->hex}}/comments">
        <i class="fa-regular fa-comment"></i> Comments
    </a>
    <a class="btn btn-info btn-sm" href="/dashboard/companies/{{$company->hex}}/contacts">
        <i class="fa-solid fa-users"></i> Contacts
    </a>
    <a class="btn btn-warning btn-sm" href="/dashboard/companies/{{$company->hex}}/rankings">
        <i class="fa-solid fa-line-chart"></i> Rankings
    </a>
    <a class="btn btn-secondary btn-sm" href="/dashboard/companies/{{$company->hex}}/associations">
        <i class="fa-solid fa-line-chart"></i> Associations
    </a>
    <a class="btn btn-primary btn-sm" href="/dashboard/companies/{{$company->hex}}/edit/publishing-information">
        <i class="fa fa-bullhorn"></i> Publishing
    </a>
</x-buttons-bar>