<div class="col-3">
    <div class="p-3 border bg-light h-100">
        <div class="card mb-3 h-100">
            <div class="view-article-img">
                <img 
                    src="{{$user->image ? asset('/images/users/'.$user->hex.'/tn-'.$user->image) : asset('/images/no-image.png')}}" 
                    class="card-img-top" 
                    alt="{{$user->full_name}}"
                >
            </div>
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">
                    {{$user->full_name}}
                </h5>
                <p class="card-text">
                    Articles: {{$user->article_count}}
                </p>
                <div class="d-flex mt-auto">
                    <a href="/dashboard/users/{{$user->hex}}/edit" class="btn btn-success btn-sm me-1">
                        <i class="fa-solid fa-pencil"></i> Edit
                    </a>
                    <a type="button" class="btn btn-danger  btn-sm me-1" data-bs-toggle="modal" data-bs-target="#deleteUserModal{{$user->hex}}">
                        <i class="fa-solid fa-trash"></i> Delete
                    </a>
                    <x-popup-modal :user="$user" />
                </div>
            </div>
        </div>
    </div>
</div>

