<x-layout>
    <x-card>
    {{-- {{dd($color_swatch)}} --}}
        {{-- Buttons bar --}}
        <x-buttons-bar>
            <a class="btn btn-primary btn-sm" href="{{url()->previous()}}">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
            @auth
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteColorSwatchModal">
                    <i class="fa-solid fa-trash"></i> Delete
                </button>
                <x-popup-modal :colorSwatch="$color_swatch" />
            @endauth
        </x-buttons-bar>
        <form action="/dashboard/color-swatches/{{$color_swatch->hex}}/update" method="POST">
            @csrf
            @method('PUT')

            <h1>Edit color swatch</h1>
            <label for="">Color swatch name</label>
            <input class="form-control input-lg w-50 mb-3" value="{{$color_swatch->name}}">

            <label for="">Decsription</label>
            <textarea class="form-control mb-3 w-50">{{$color_swatch->description}}</textarea>

        
            <table class="table w-50">
                <thead>
                    <tr>
                        <th class="align-middle" scope="col">#</th>
                        <th class="align-middle" scope="col">Color</th>
                        <th class="align-middle" scope="col">Code</th>
                        <th class="align-middle" scope="col">Name</th>
                        <th class="align-middle" scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($color_swatch->colors as $color)
                        <tr id="row_{{$color->id}}">
                            <th id="fill_id_{{$color->fill_id}}" class="align-middle" scope="row">
                                {{$color->fill_id}}
                            </th>
                            <td class="align-middle">
                                <div id="color_square_{{$color->fill_id}}" class="color-square" style="background: #{{$color->code}};"></div>
                            </td>
                            <td class="align-middle">
                                <input id="input_code_{{$color->fill_id}}" type="text" class="form-control" name="code_{{$color->fill_id}}" value="{{$color->code}}">
                            </td>
                            <td class="align-middle">
                                <input type="text" class="form-control" name="name_{{$color->fill_id}}" value="{{$color->name}}">
                            </td>
                            <td style="text-align: right;" class="align-middle">
                                <a id="delete_{{$color->fill_id}}" href="/dashboard" class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i>     
                                    Delete
                                </a>
                            </td>
                        </tr>
                        <script>
                            document.getElementById('delete_{{$color->fill_id}}').addEventListener('click', function(e){
                                e.preventDefault();
                                // alert("row_{{$color->id}}");
                                document.getElementById('row_{{$color->fill_id}}').style.display='none';
                            });
                        </script>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-end">
                <a href="{{url()->previous()}}">
                    <button id="test" type="button" class="btn btn-secondary me-2">Cancel</button>
                </a>
                <button type="submit" class="btn btn-success">Save changes</button>
            </div>
        </form>
    </x-card>
</x-layout>


<script>    
    @foreach($color_swatch->colors as $color)
        document.querySelector('#input_code_{{$color->fill_id}}').addEventListener('input', function(e){
            color = "#" + document.getElementById('input_code_{{$color->fill_id}}').value;
            document.getElementById('color_square_{{$color->fill_id}}').style.backgroundColor=color;
        });
    @endforeach
</script>

       
    