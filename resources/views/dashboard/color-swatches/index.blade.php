<x-layout>
    <x-card>

        {{-- Buttons bar --}}
        <x-buttons-bar>
            <a class="btn btn-primary btn-sm" href="{{url()->previous()}}">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
            @auth
                <a class="btn btn-success btn-sm" href="/dashboard/color-swatches/create">
                    <i class="fa-solid fa-brush"></i> Create color swatch
                </a>
            @endauth
        </x-buttons-bar>

        <h1>Color swatches</h1>
        @foreach($color_swatches as $color_swatch)
            <div class="d-flex">
                <div class="card swatch-card w-50 py-4 pb-2">
                    <div class="mx-3">
                        @foreach($color_swatch->colors as $key => $color)
                            <div class="color-square me-2 mb-2" style="background: #{{$color->code}};"></div>
                        @endforeach
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">
                            {{$color_swatch->name}}
                        </h3>
                        <p class="card-text">
                            {{$color_swatch->description}}
                        </p>
                        <a href="/dashboard/color-swatches/{{$color_swatch->hex}}" class="btn btn-primary">
                            Edit color swatch
                        </a>
                    </div>
                </div>
            
            
        @endforeach
    </x-card>
</x-layout>