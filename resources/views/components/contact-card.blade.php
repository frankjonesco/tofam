<div class="card m-3 p-3">
    <div class="row">
        <div class="col-3">
            <div>    
                <img 
                    src="{{(in_array($contact->gender, ['male', 'female'])) ? asset('images/users/default-profile-pic-'.$contact->gender.'.jpg') : asset('images/no-image.png')}}" 
                    class="card-img-top" 
                    alt="{{$contact->hex}}"
                >
            </div>
        </div>
        <div class="col-9">
            <p>{{$contact->formal_name}}</p>
            <p>
                <a href="mailto:{{$contact->email}}">{{$contact->email}}</a>
            </p>
            <p>{{$contact->gender}}</p>
            <p>{{$contact->job_title}}</p>
            <p>{{$contact->department}}</p>
            <p>{{$contact->phone}}</p>
            <p>{{$contact->mobile}}</p>

            <a 
                href="/dashboard/companies/{{$contact->company->hex}}/contacts/edit/{{$contact->hex}}" 
                class="btn btn-success btn-sm mt-auto me-auto"
            >
                <i class="fa-solid fa-pen-to-square"></i> 
                Edit contact
            </a>

            <button 
                type="button" 
                class="btn btn-danger btn-sm" 
                data-bs-toggle="modal" 
                data-bs-target="#deleteContactModal_{{$contact->hex}}"
            >
                <i class="fa-solid fa-trash"></i> 
                Delete
            </button>

        </div>
        
    </div>
    
</div>