<x-layout>
    <x-card>
    {{-- {{dd($color_swatch)}} --}}
        {{-- Buttons bar --}}
        <x-buttons-bar>
            <a class="btn btn-primary btn-sm" href="{{url()->previous()}}">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
        </x-buttons-bar>
        <div class="w-50">
            <form action="/dashboard/color-swatches/{{$color_swatch->hex}}/update" method="POST">
                @csrf
                @method('PUT')

                <h1>Edit color swatch</h1>
                <label for="">Color swatch name</label>
                <input class="form-control input-lg mb-3" name="name" value="{{$color_swatch->name}}">

                <label for="">Decsription</label>
                <textarea class="form-control mb-3" name="description" rows="3">{{$color_swatch->description}}</textarea>

            
                <table id="colorsTable" class="table">
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
                            <tr id="row_{{$color->fill_id}}">
                                <th id="fill_id_{{$color->fill_id}}" class="align-middle" scope="row">
                                    {{$color->fill_id}}
                                </th>
                                <td class="align-middle">
                                    <div id="color_square_{{$color->fill_id}}" class="color-square" style="background: #{{$color->code}};"></div>
                                </td>
                                @error('code_'.$color->fill_id)
                                    <td class="align-middle">
                                        <input id="input_code_{{$color->fill_id}}" type="text" class="form-control" name="code_{{$color->fill_id}}" value="{{old('code_'.$color->fill_id == true) ? old('code_'.$color->fill_id) : $color->code}}" maxlength="6" autofocus>
                                    </td>
                                @else
                                    <td class="align-middle">
                                        <input id="input_code_{{$color->fill_id}}" type="text" class="form-control" name="code_{{$color->fill_id}}" value="{{old('code_'.$color->fill_id == true) ? old('code_'.$color->fill_id) : $color->code}}"maxlength="6">
                                    </td>                                    
                                @enderror
                                <td class="align-middle">
                                    <input type="text" class="form-control" name="name_{{$color->fill_id}}" value="{{$color->name}}">
                                </td>
                                <td style="text-align: right;" class="align-middle">
                                    <button id="delete_{{$color->fill_id}}" type="button" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i>     
                                        Delete
                                    </button>
                                    <button id="undo_delete_{{$color->fill_id}}" type="button" class="btn btn-secondary btn-sm" style="display: none;">
                                        <i class="fa fa-undo"></i>     
                                        Undo
                                    </button>
                                </td>
                                
                            </tr>

                            @error('code_'.$color->fill_id)
                                <tr>
                                    <td colspan="5">
                                        <p class="text-danger">{{$message}}</p>
                                    </td>
                                </tr>
                            @else
                                @error('name_'.$color->fill_id)
                                    <tr>
                                        <td colspan="5">
                                            <p class="text-danger">{{$message}}</p>
                                        </td>
                                    </tr>
                                @enderror
                            @enderror

                        @endforeach

                        <input type="hidden" name="color_swatch_id" value="{{$color_swatch->id}}">
                        <input id="deleteThese" name="delete_these" type="hidden" value="">
                        <input id="deleteCount" name="delete_count" type="hidden" value="">
                        <input id="newColorCount" name="new_color_count" type="hidden" value="{{count($color_swatch->colors)}}">
                    </tbody>
                </table>

                
                <div class="d-flex justify-content-end">
                    
                    <button type="button" class="btn btn-primary btn-sm me-2" onclick="addRow()">Add another color</button>
                    
                    <a href="{{url()->previous()}}">
                        <button id="test" type="submit" class="btn btn-secondary btn-sm me-2">Cancel</button>
                    </a>
                    <button type="submit" class="btn btn-sm btn-success">Save changes</button>
                </div>
            </form>
        </div>
    </x-card>
</x-layout>


<script>

    function adjestBoxes(countValue){
        document.querySelector('#input_code_' + countValue).addEventListener('input', function(e){
            color = "#" + document.getElementById('input_code_' + countValue).value;
            console.log('Color: ' + color);
            document.getElementById('color_square_' + countValue).style.backgroundColor=color;
        });
    }

    function addRow(){

        newColorCount = document.getElementById('newColorCount')
        countValue = parseInt(newColorCount.value, 10) + 1;
        newColorCount.value = countValue;

        var myHtmlContent = '<th id="fill_id_' + countValue + '" class="align-middle" scope="row">' + countValue + '</th><td class="align-middle"><div id="color_square_' + countValue + '" class="color-square" style="background: #FFFFFF;"></div></td><td class="align-middle"><input id="input_code_' + countValue + '" type="text" class="form-control" name="code_' + countValue + '" value="FFFFFF" maxlength="6"></td><td class="align-middle"><input type="text" class="form-control" name="name_' + countValue + '" value="Plain White"></td><td style="text-align: right;" class="align-middle"><button id="delete_' + countValue + '" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>Delete</button><button id="undo_delete_' + countValue + '" type="button" class="btn btn-secondary btn-sm" style="display: none;"><i class="fa fa-undo"></i>Undo</button></td>';

        var tableRef = document.getElementById('colorsTable').getElementsByTagName('tbody')[0];

        var newRow = tableRef.insertRow(tableRef.rows.length);
        newRow.innerHTML = myHtmlContent;


        // document.querySelector('#input_code_' + countValue).addEventListener('input', function(e){
        //     color = "#" + document.getElementById('input_code_' + countValue).value;
        //     document.getElementById('color_square_' + countValue).style.backgroundColor=color;
        // );
        console.log('Row added!');
        console.log('Number of rows: ' + countValue);
        
        adjestBoxes(countValue);
       
        
    }


    function colorCount(colors) {
        var colors = colors.split(',');
        return colors.length - 1;
    }
   


    @foreach($color_swatch->colors as $color)

        deleteThese = document.getElementById("deleteThese");

        row_{{$color->fill_id}} = document.getElementById("row_{{$color->fill_id}}");

        deleteBtn_{{$color->fill_id}} = document.getElementById('delete_{{$color->fill_id}}');
        undoDeleteBtn_{{$color->fill_id}} = document.getElementById('undo_delete_{{$color->fill_id}}');
    
        deleteBtn_{{$color->fill_id}}.addEventListener('click', function(e){
            row_{{$color->fill_id}}.style.opacity="0.3";
            deleteBtn_{{$color->fill_id}}.style.display="none";
            undoDeleteBtn_{{$color->fill_id}}.style.display="inline-block";

            deleteThese.value+="{{$color->fill_id}},";

            newColorCount = document.getElementById('newColorCount')
            countValue = parseInt(newColorCount.value, 10) - 1;
            newColorCount.value = countValue;

            
            deleteCount.value = colorCount(deleteThese.value);

        });

        undoDeleteBtn_{{$color->fill_id}}.addEventListener('click', function(e){
            row_{{$color->fill_id}}.style.opacity="1";
            undoDeleteBtn_{{$color->fill_id}}.style.display="none";
            deleteBtn_{{$color->fill_id}}.style.display="inline-block";

            
            oldList_{{$color->fill_id}} = deleteThese.value.toString().split(',');
            oldList_{{$color->fill_id}} = oldList_{{$color->fill_id}}.filter(function (el) {
              return el != null;
            });

            for (var i = 0; i < oldList_{{$color->fill_id}}.length; i++) {
                if (oldList_{{$color->fill_id}}[i] == {{$color->fill_id}}) {
                    console.log('DELETE THIS: ' + i)
                    var spliced_{{$color->fill_id}} = oldList_{{$color->fill_id}}.splice(i, 1);
                }
            }

            deleteThese.value = oldList_{{$color->fill_id}};

            newColorCount = document.getElementById('newColorCount')
            countValue = parseInt(newColorCount.value, 10) + 1;
            newColorCount.value = countValue;

            deleteCount.value = colorCount(deleteThese.value);
            

        });

    @endforeach
</script>

<script>    
    @foreach($color_swatch->colors as $color)
        document.querySelector('#input_code_{{$color->fill_id}}').addEventListener('input', function(e){
            color = "#" + document.getElementById('input_code_{{$color->fill_id}}').value;
            document.getElementById('color_square_{{$color->fill_id}}').style.backgroundColor=color;
        });
    @endforeach
</script>

       
    