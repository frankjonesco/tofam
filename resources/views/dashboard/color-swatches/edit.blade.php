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
    
        <h1>Color swatch: {{$color_swatch->name}}</h1>

        <form action="/dashboard/color-swatches/{{$color_swatch->hex}}/update" method="POST">
            @csrf
            @method('PUT')
            <table class="table w-100">
                <thead>
                    <tr>
                        <th class="align-middle" scope="col">#</th>
                        <th class="align-middle" scope="col">Color</th>
                        <th class="align-middle" scope="col">Code</th>
                        <th class="align-middle" scope="col">Name</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($color_swatch->colors as $color)
                        <tr>
                            <th class="align-middle" scope="row">
                                {{$color->fill_id}}
                            </th>
                            <td class="align-middle">
                                <div id="color_square_{{$color->fill_id}}" class="color-square" style="background: #{{$color->code}};"></div>
                            </td>
                            <td class="align-middle">
                                <input id="input_code_{{$color->id}}" type="text" class="form-control" name="code_{{$color->id}}" value="{{$color->code}}">
                            </td>
                            <td class="align-middle">
                                <input type="text" class="form-control" name="name_{{$color->id}}" value="{{$color->name}}">
                            </td>  
                        </tr>
                    @endforeach  
                </tbody>
            </table>
            <div class="d-flex justify-content-end">
                <button id="test" type="button" class="btn btn-secondary me-2">Cancel</button>
                <button type="submit" class="btn btn-success">Save changes</button>
            </div>
        </form>
    </x-card>
</x-layout>


<script>    
@foreach($color_swatch->colors as $color)
    



        document.querySelector('#input_code_{{$color->id}}').addEventListener('input', function(e){
            color = "#" + document.getElementById('input_code_{{$color->id}}').value;
            document.getElementById('color_square_{{$color->id}}').style.backgroundColor=color;
        });

       
        



        
   
@endforeach
</script>

       
    