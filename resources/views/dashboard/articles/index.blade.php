<x-admin-card>
        {{-- Buttons bar --}}
        <x-buttons-bar>
            <a class="btn btn-primary btn-sm" href="{{url()->previous()}}">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
        </x-buttons-bar>

        <h1>Article Library</h1>

        <div class="row">
            <div class="col-2 bg-info">Hex</div>
            <div class="col-6">Title</div>
            <div class="col-4 text-right">Views</div>
            @foreach($articles as $article)
                <div class="col-2 bg-info">{{$article->hex}}</div>
                <div class="col-6">{{$article->title}}</div>
                <div class="col-4 text-right">{{$article->views}}</div>
            @endforeach
        </div>
     

</x-admin-card>
