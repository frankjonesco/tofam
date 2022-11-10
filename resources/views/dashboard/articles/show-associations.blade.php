<x-admin-card>

    <x-article-edit-buttons :article="$article"/>

    <h1>Edit associations</h1>
    <a href="/dashboard/articles/{{$article->hex}}/associations/create">
        <button class="btn btn-success">Add a new association</button>
    </a>
    <div class="w-100">

        @foreach($article->associations as $association)
            {{$association->article->title}}<br/>
        @endforeach
        
    </div>

    {{-- <x-popup-modal :contacts="$company->contacts" /> --}}

</x-admin-card>

