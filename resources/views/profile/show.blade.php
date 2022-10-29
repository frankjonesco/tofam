{{-- {{dd($user->color_name)}} --}}
<x-layout>
    <x-card>
        <h1>Profile</h1>

        <div class="d-flex">

            <div class="w-50 p-3">
                <div class="card bg-light pb-5 border">
                    <img src="{{asset('images/users/'.$user->hex.'/'.$user->image)}}" alt="" class="m-5 w-50 mx-auto border">
                    <div class="card-body px-5">
                        <h2 class="card-title mb-4">{{$user->full_name}}</h2>
                        <div class="d-flex pb-5">
                            <div class="w-50 h5">
                                <i class="fa fa-map-marker" aria-hidden="true"></i> {!!$user->country->name ?? '<i class="text-muted">Not set</i>'!!}
                            </div>
                            <div class="w-50 h5">
                                <i class="fa fa-map-marker" aria-hidden="true"></i> {!!ucfirst($user->gender) ?? '<i class="text-muted">Not set</i>'!!}
                            </div>
                        </div>                        
                        <a href="#" class="btn btn-primary">Edit profile</a>
                    </div>
                </div>
            </div>

            <div class="w-50 p-3">
                <div class="card bg-light border mb-4">
                    <div class="card-body p-5">
                        <h2 class="card-title mb-4">My articles</h2>

                
                        
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Views</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->articles as $key => $article)
                                    @if($key < 5)
                                        <tr>
                                            <td>{{$article->title}}</td>
                                            <td>{{$article->views}}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        
                        <a href="/dashboard/articles" class="btn btn-primary mt-3">View all</a>
                    </div>
                </div>


                <div class="card bg-light border">
                    <div class="card-body p-5">
                        <h2 class="card-title mb-4">Account information</h2>
                        
                        <div class="d-flex pb-5 row">
                            <div class="col-6 h5">
                                <i class="fa fa-envelope" aria-hidden="true"></i> {{$user->email}}
                            </div>
                            <div class="col-6 h5">
                                <i class="fa fa-phone" aria-hidden="true"></i> {!!$user->phone ?? '<i class="text-muted">Not set</i>'!!}
                            </div>

                            <div class="col-6 h5">
                                <i class="fa fa-brush"></i> 
                                <div style="
                                    width: 20px;
                                    height: 20px;
                                    background: #{{$user->color->code}};
                                    border: 1px solid #999;
                                    padding: 2px;
                                    display: inline-block;
                                ">  
                                </div>
                            </div>
                            <div class="col-6 h5">
                                <i class="fa fa-phone" aria-hidden="true"></i> {!!$user->phone ?? '<i class="text-muted">Not set</i>'!!}
                            </div>
                        </div>      

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