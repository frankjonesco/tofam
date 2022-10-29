{{-- {{dd($user->color_name)}} --}}
<x-layout>
    <x-card>
        <h1>Profile</h1>

        <div class="d-flex">

            <div class="w-50 p-5">
                <div class="card bg-light pb-5 border">
                    <img src="{{asset('images/users/'.$user->hex.'/'.$user->image)}}" alt="" class="m-5 w-75 mx-auto border">
                    <div class="card-body px-5">
                        <h5 class="card-title">{{$user->full_name}}</h5>
                        <div class="d-flex">
                            <div class="w-50">
                                <i class="fa fa-map-marker" aria-hidden="true"></i> {{$user->country->name ?? null}}
                            </div>
                            <div class="w-50"></div>
                        </div>                        
                        <a href="#" class="btn btn-primary">Edit profile</a>
                    </div>
                </div>
            </div>

            <div class="w-50 p-5">
                <div class="card bg-light pb-5 border">
                    <div class="card-body px-5 pt-5">
                        <h5 class="card-title">{{$user->full_name}}</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>

                <div class="card bg-light pb-5 mt-5 border">
                    <div class="card-body px-5 pt-5">
                        <h5 class="card-title">{{$user->full_name}}</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>

        </div>

        <img src="{{asset('images/users/'.$user->hex.'/'.$user->image)}}" alt="">

        <p>Hex: {{$user->hex}}</p>
        <p>User type: {{$user->user_type->name}}</p>
        <p>First name: {{$user->first_name}}</p>
        <p>Last name: {{$user->last_name}}</p>
        <p>Email: {{$user->email}}</p>
        <p>Email verified at: {{$user->email_verified_at}}</p>
        <p>Gender: {{$user->gender}}</p>
        <p>Country: {{$user->country->name ?? null}}</p>
        <p>Color: {{$user->color->code}}</p>
        <p>Created at: {{$user->created_at}}</p>
        <p>Updated at: {{$user->updated_at}}</p>
        <p>Number of articles: {{$user->article_count}}</p>
    </x-card>
</x-layout>