<x-layout>
    <x-card>
    
        {{-- Buttons bar --}}
        <x-buttons-bar>
            <a class="btn btn-primary btn-sm" href="{{url()->previous()}}">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
            @auth
                <a class="btn btn-success btn-sm" href="/dashboard/color-swatches/{{$color_swatch->hex}}/edit">
                    <i class="fa-solid fa-pencil"></i> Edit color swatch
                </a>
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteColorSwatchModal">
                    <i class="fa-solid fa-trash"></i> Delete
                </button>
                <x-popup-modal :colorSwatch="$color_swatch" />
            @endauth
        </x-buttons-bar>
        
        <div class="w-50">
            <h1>{{$color_swatch->name}}</h1>
            <p>
                <b>Description:</b><br>
                {{$color_swatch->description}}
            </p>
            <table class="table mt-5">
                <thead>
                <tr>
                    <th class="align-middle" scope="col">#</th>
                    <th class="align-middle" scope="col">Color</th>
                    <th class="align-middle" scope="col">Code</th>
                    <th class="align-middle" scope="col">Name</th>
                    <th scope="col">Created</th>
                    <th scope="col">Last updated</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($color_swatch->colors as $color)
                        <tr>
                            <th class="align-middle" scope="row">{{$color->fill_id}}</th>
                            <td class="align-middle">
                                <div class="color-square" style="background: #{{$color->code}};"></div>
                            </td>
                            <td class="align-middle">#{{$color->code}}</td>
                            <td class="align-middle">{{$color->name}}</td>
                            <td class="align-right">{{$color->created_at}}</td>
                            <td class="align-right">{{$color->updated_at}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-card>
</x-layout>