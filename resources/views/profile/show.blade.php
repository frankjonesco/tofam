{{-- {{dd($user->color_name)}} --}}
<x-layout>
    <x-card>
        <h1>Profile</h1>

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